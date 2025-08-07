from fastapi import FastAPI, Request, HTTPException
from fastapi.middleware.cors import CORSMiddleware
import jwt
import httpx
from dotenv import load_dotenv
import os

# Load .env file
load_dotenv()

SECRET = os.getenv("JWT_SECRET")
if not SECRET:
    raise RuntimeError("JWT_SECRET is not set in .env")

app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost", "http://127.0.0.1", "*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.post("/webhooks/smssolutions/webhook")
async def rasa_webhook(request: Request):
    # ✅ Kiểm tra token
    auth = request.headers.get("authorization", "")
    if not auth.startswith("Bearer "):
        raise HTTPException(status_code=401, detail="Unauthorized")

    token = auth[7:]
    try:
        payload = jwt.decode(
            token,
            SECRET,
            algorithms=["HS256"],
            options={"verify_aud": False, "verify_sub": False}
        )
    except jwt.ExpiredSignatureError:
        raise HTTPException(status_code=401, detail="Token expired")
    except jwt.InvalidTokenError:
        raise HTTPException(status_code=401, detail="Invalid token")

    # ✅ Xử lý input từ cả form-data và JSON
    content_type = request.headers.get("content-type", "")
    if "application/json" in content_type:
        data = await request.json()
    elif "multipart/form-data" in content_type or "application/x-www-form-urlencoded" in content_type:
        form = await request.form()
        data = dict(form)
    else:
        raise HTTPException(status_code=415, detail="Unsupported Content-Type")

    sender = payload.get("sub") or data.get("sender")
    message = data.get("message")

    if not sender or not message:
        raise HTTPException(status_code=400, detail="Missing sender or message")

    # ✅ Gửi đến Rasa
    async with httpx.AsyncClient() as client:
        response = await client.post(
            "http://localhost:5005/webhooks/rest/webhook",
            json={
                "sender": sender,
                "message": message
            }
        )
        rasa_response = response.json()

    return rasa_response
