from flask import Flask, request, jsonify
import torch
import pickle
import numpy as np
from model import Encoder, Decoder
from preprocess import tokenize, preprocess_text
from sentence_transformers import SentenceTransformer
from datetime import datetime
import json
import os
from utils import get_connection, check_stock, extract_product_name, evaluate

app = Flask(__name__)

# Config
SIMILARITY_THRESHOLD = 0.7  # Ngưỡng similarity tối thiểu
EMBEDDING_MODEL = 'all-MiniLM-L6-v2'  # Dùng model thống nhất
EMBEDDING_FILE = 'vector_store.pkl'  # File embedding thống nhất

# Load vocab và models
with open("vocab.pkl", "rb") as f:
    word2idx, idx2word = pickle.load(f)

vocab_size = len(word2idx)
embed_size = 32
hidden_size = 64

encoder = Encoder(vocab_size, embed_size, hidden_size)
decoder = Decoder(vocab_size, embed_size, hidden_size)
encoder.load_state_dict(torch.load("encoder.pth"))
decoder.load_state_dict(torch.load("decoder.pth"))
encoder.eval()
decoder.eval()

# Load semantic search model và data
sentence_model = SentenceTransformer(EMBEDDING_MODEL)
with open(EMBEDDING_FILE, "rb") as f:
    vector_data = pickle.load(f)
    answer_vectors = vector_data['embeddings']
    answers = vector_data['answers']

def search_answer_semantic(question):
    # Tiền xử lý câu hỏi
    processed_question = preprocess_text(question)

    # Tính embedding và similarity
    question_vector = sentence_model.encode([processed_question])
    similarities = np.dot(answer_vectors, question_vector.T).flatten()
    best_idx = np.argmax(similarities)
    
    # Kiểm tra ngưỡng similarity
    if similarities[best_idx] < SIMILARITY_THRESHOLD:
        return None  # Không tìm thấy câu trả lời phù hợp
    
    return answers[best_idx], similarities[best_idx]

@app.route("/chat", methods=["POST"])
def chat():
    user_input = request.json.get("message", "").strip()
    
    if not user_input:
        return jsonify({"response": "Vui lòng nhập câu hỏi.", "method": "input_check", "confidence": 0.0}), 400

    # ======= Ưu tiên xử lý câu hỏi liên quan hàng hóa ========
    if extract_product_name(user_input) is not None:
        try:
            print("Processing product name...")
            product_name = extract_product_name(user_input)
            response = check_stock(product_name)
            method = "inventory_check"
            similarity = 1.0
            
            return jsonify({
                "input": user_input,
                "response": response,
                "method": method,
                "confidence": similarity
            })
        except Exception as e:
            print(f"Error processing product name: {e}")

    # ======= Semantic Search ========
    result = search_answer_semantic(user_input)

    if result is not None:
        semantic_response, similarity = result
        response = semantic_response
        method = "semantic_search"
    else:
        # ======= Seq2Seq Fallback ========
        rnn_response = evaluate(user_input, encoder, decoder, word2idx, idx2word)
        response = rnn_response
        method = "seq2seq"
        similarity = 0.0

    # ======= Ghi log ========
    log_entry = {
        "input": user_input,
        "output": response,
        "method": method,
        "confidence": float(similarity),
        "timestamp": datetime.now().isoformat()
    }
    
    with open("log.jsonl", "a", encoding="utf-8") as f:
        f.write(json.dumps(log_entry, ensure_ascii=False) + "\n")

    return jsonify({
        "input": user_input,
        "response": response,
        "method": method,
        "confidence": similarity
    })

if __name__ == "__main__":
    try:
        conn = get_connection()
        if conn.is_connected():
            print("✅ Kết nối db laravel core thành công!")
            conn.close()
        else:
            print("❌ Kết nối thất bại.")
    except Exception as e:
        print(f"⚠️ Lỗi khi kết nối database: {str(e)}")
    
    # Luôn khởi chạy Flask app dù có kết nối được DB hay không
    app.run(host="0.0.0.0", port=5000)
