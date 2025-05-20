import pickle
from sentence_transformers import SentenceTransformer

# Danh sách câu trả lời mẫu (có thể thay thế bằng dữ liệu thật)
answers = [
    "Xin chào! Tôi có thể giúp gì cho bạn?",
    "Bạn cần hỗ trợ về sản phẩm nào?",
    "Vui lòng cung cấp thêm chi tiết về vấn đề bạn gặp phải.",
    "Cảm ơn bạn đã liên hệ với chúng tôi."
]

# Load sentence transformer model
model = SentenceTransformer('all-MiniLM-L6-v2')

# Tạo embedding cho mỗi câu trả lời
embeddings = model.encode(answers)

# Lưu vào file
vector_store = {
    'answers': answers,
    'embeddings': embeddings
}

with open("vector_store.pkl", "wb") as f:
    pickle.dump(vector_store, f)

print("✅ Đã tạo xong file vector_store.pkl")
