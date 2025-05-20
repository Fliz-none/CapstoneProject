from sentence_transformers import SentenceTransformer
from sklearn.metrics.pairwise import cosine_similarity
import pickle
import numpy as np
import os

# Load SentenceTransformer model
model = SentenceTransformer("all-MiniLM-L6-v2")

# Load vector_store đã embed sẵn
with open(os.path.join("embeddings", "vector_store.pkl"), "rb") as f:
    data = pickle.load(f)

questions = data["questions"]
answers = data["answers"]
embeddings = data["embeddings"]

def search_answer(user_input, top_k=1):
    user_vec = model.encode([user_input])
    scores = cosine_similarity(user_vec, embeddings)[0]
    top_idx = np.argmax(scores)
    return answers[top_idx], questions[top_idx], scores[top_idx]
