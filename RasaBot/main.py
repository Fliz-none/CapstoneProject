from fastapi import FastAPI, Request, HTTPException
from fastapi.middleware.cors import CORSMiddleware
import jwt
import httpx
from dotenv import load_dotenv
import os

# Load .env
load_dotenv()
SECRET = os.getenv("JWT_SECRET")
if not SECRET:
    raise RuntimeError("JWT_SECRET is not set in .env")

app = FastAPI()

# CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Cho phép tất cả origin trong quá trình dev
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


@app.post("/webhooks/smsolutions/webhook")
async def rasa_webhook(request: Request):
    # ✅ Kiểm tra Bearer token
    auth = request.headers.get("authorization", "")
    if not auth.startswith("Bearer "):
        raise HTTPException(status_code=401, detail="Unauthorized")

    token = auth[7:]
    try:
        payload = jwt.decode(
            token,
            SECRET,
            algorithms=["HS256"],
            options={"verify_aud": False, "verify_sub": False},
        )
    except jwt.ExpiredSignatureError:
        raise HTTPException(status_code=401, detail="Token expired")
    except jwt.InvalidTokenError:
        raise HTTPException(status_code=401, detail="Invalid token")

    # ✅ Lấy dữ liệu từ body (json hoặc form-data)
    content_type = request.headers.get("content-type", "")
    if "application/json" in content_type:
        try:
            data = await request.json()
        except Exception:
            raise HTTPException(status_code=400, detail="Invalid JSON body")
    elif (
        "multipart/form-data" in content_type
        or "application/x-www-form-urlencoded" in content_type
    ):
        form = await request.form()
        data = dict(form)
    else:
        raise HTTPException(status_code=415, detail="Unsupported Content-Type")

    # ✅ Lấy sender và message
    sender = payload.get("sub") or data.get("sender")
    message = data.get("message")
    if not sender or not message:
        raise HTTPException(status_code=400, detail="Missing sender or message")

    # ✅ Gửi sang Rasa REST webhook
    async with httpx.AsyncClient() as client:
        try:
            response = await client.post(
                "http://localhost:5005/webhooks/rest/webhook",
                json={"sender": sender, "message": message},
                timeout=10.0,
            )
            response.raise_for_status()
        except httpx.HTTPError as e:
            raise HTTPException(
                status_code=502, detail=f"Failed to reach Rasa: {str(e)}"
            )

    return response.json()
