import json
from sentence_transformers import SentenceTransformer
import numpy as np
import pickle

# Load mô hình embedding (bạn có thể thay bằng model khác nếu muốn)
model = SentenceTransformer('all-MiniLM-L6-v2')

# Load dữ liệu từ file JSONL
data_path = 'data.jsonl'
qa_pairs = []
with open(data_path, 'r', encoding='utf-8') as f:
    for line in f:
        obj = json.loads(line)
        qa_pairs.append((obj['question'], obj['answer']))

# Tạo embedding cho các câu hỏi
questions = [q for q, a in qa_pairs]
answers = [a for q, a in qa_pairs]
question_embeddings = model.encode(questions, convert_to_numpy=True)

# Lưu lại vector + câu trả lời
with open('vector_store.pkl', 'wb') as f:
    pickle.dump({'embeddings': question_embeddings, 'answers': answers, 'questions': questions}, f)

print("✅ Done! Đã lưu embeddings vào vector_store.pkl")
