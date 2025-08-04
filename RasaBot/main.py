from fastapi import FastAPI, Request, HTTPException
from fastapi.middleware.cors import CORSMiddleware
import jwt
import httpx
from dotenv import load_dotenv
import os

# Load .env file
load_dotenv()

# Đọc biến môi trường
SECRET = os.getenv("JWT_SECRET")

if not SECRET:
    raise RuntimeError("JWT_SECRET is not set in .env")

app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost", "http://127.0.0.1", "*"],  # Cho phép nguồn truy cập (client)
    allow_credentials=True,
    allow_methods=["*"],        # Cho phép tất cả method: GET, POST, ...
    allow_headers=["*"],        # Cho phép tất cả headers
)

@app.post("/webhooks/smssolutions/webhook")
async def rasa_webhook(request: Request):
    auth = request.headers.get("authorization", "")
    if not auth.startswith("Bearer "):
        raise HTTPException(status_code=401, detail="Unauthorized")

    token = auth[7:]
    print(jwt.decode(
            token,
            SECRET,
            algorithms=["HS256"],
            options={"verify_aud": False, "verify_sub": False, }
        ))
    try:
        payload = jwt.decode(
            token,
            SECRET,
            algorithms=["HS256"],
            options={"verify_aud": False, "verify_sub": False, }
        )

    except jwt.ExpiredSignatureError:
        raise HTTPException(status_code=401, detail="Token expired")
    except jwt.InvalidTokenError:
        raise HTTPException(status_code=401, detail="Invalid token")

    data = await request.json()

    async with httpx.AsyncClient() as client:
        response = await client.post(
            "http://localhost:5005/webhooks/rest/webhook",
            json={
                "sender": payload["sub"],
                "message": data["message"]
            }
        )
        rasa_response = response.json()

    return rasa_response
