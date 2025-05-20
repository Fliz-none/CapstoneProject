import torch
import torch.nn as nn
import torch.optim as optim
import pickle
from model import Encoder, Decoder
from preprocess import tokenize, build_vocab
from data import load_data_jsonl
from sentence_transformers import SentenceTransformer
import numpy as np

# ==========================
# Cấu hình
# ==========================
HIDDEN_SIZE = 64
EMBED_SIZE = 32
LR = 0.01
EPOCHS = 300
JSONL_PATH = "data.jsonl"
DEVICE = torch.device("cuda" if torch.cuda.is_available() else "cpu")

# ==========================
# Load và xử lý dữ liệu
# ==========================
pairs = load_data_jsonl(JSONL_PATH)
word2idx, idx2word = build_vocab(pairs)

# Lưu vocab để dùng sau này
with open("vocab.pkl", "wb") as f:
    pickle.dump((word2idx, idx2word), f)

vocab_size = len(word2idx)

def tensor_from_sentence(sentence):
    tokens = tokenize(sentence)
    ids = [word2idx.get(word, word2idx["<UNK>"]) for word in tokens]
    ids.append(word2idx["<EOS>"])
    return torch.tensor(ids, dtype=torch.long).unsqueeze(1)  # (seq_len, 1)

# ==========================
# Khởi tạo mô hình
# ==========================
encoder = Encoder(vocab_size, EMBED_SIZE, HIDDEN_SIZE).to(DEVICE)
decoder = Decoder(vocab_size, EMBED_SIZE, HIDDEN_SIZE).to(DEVICE)

enc_opt = optim.Adam(encoder.parameters(), lr=LR)
dec_opt = optim.Adam(decoder.parameters(), lr=LR)
loss_fn = nn.CrossEntropyLoss()

# ==========================
# Huấn luyện mô hình
# ==========================
for epoch in range(1, EPOCHS + 1):
    total_loss = 0

    for question, answer in pairs:
        input_tensor = tensor_from_sentence(question).to(DEVICE)
        target_tensor = tensor_from_sentence(answer).to(DEVICE)

        hidden = encoder(input_tensor)

        dec_input = torch.tensor([[word2idx["<SOS>"]]], device=DEVICE)
        loss = 0

        for t in range(target_tensor.size(0)):
            output, hidden = decoder(dec_input, hidden)
            loss += loss_fn(output, target_tensor[t])
            dec_input = target_tensor[t].unsqueeze(0)

        enc_opt.zero_grad()
        dec_opt.zero_grad()
        loss.backward()
        enc_opt.step()
        dec_opt.step()

        total_loss += loss.item()

    if epoch % 25 == 0 or epoch == 1:
        print(f"[Epoch {epoch}] Loss: {total_loss:.4f}")

# ==========================
# Lưu mô hình
# ==========================
torch.save(encoder.state_dict(), "encoder.pth")
torch.save(decoder.state_dict(), "decoder.pth")
print("✅ Mô hình đã được lưu thành công.")

# ==========================
# Tạo và lưu vector embedding cho câu trả lời (semantic search)
# ==========================
sentence_model = SentenceTransformer('paraphrase-MiniLM-L6-v2')
answers = [answer for _, answer in pairs]
answer_vectors = sentence_model.encode(answers, show_progress_bar=True)

with open("answer_vectors.pkl", "wb") as f:
    pickle.dump((answers, answer_vectors), f)
print("✅ Đã lưu vector embedding của câu trả lời.")
