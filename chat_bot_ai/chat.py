import torch
from model import Encoder, Decoder
from preprocess import tokenize, build_vocab
from data import pairs

device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
word2idx, idx2word = build_vocab(pairs)
vocab_size = len(word2idx)

encoder = Encoder(vocab_size, 32, 64).to(device)
decoder = Decoder(vocab_size, 32, 64).to(device)
encoder.load_state_dict(torch.load("encoder.pth"))
decoder.load_state_dict(torch.load("decoder.pth"))
encoder.eval()
decoder.eval()

def tensor_from_sentence(sentence):
    tokens = tokenize(sentence)
    ids = [word2idx.get(word, 0) for word in tokens]
    return torch.tensor(ids, dtype=torch.long).unsqueeze(1).to(device)

def generate_reply(sentence):
    input_tensor = tensor_from_sentence(sentence)
    hidden = encoder(input_tensor)

    dec_input = torch.tensor([[word2idx["<SOS>"]]], device=device)
    decoded_words = []

    for _ in range(20):
        output, hidden = decoder(dec_input, hidden)
        top1 = output.argmax(1)
        word = idx2word[top1.item()]
        if word == "<EOS>":
            break
        decoded_words.append(word)
        dec_input = top1.unsqueeze(0)

    return " ".join(decoded_words)

while True:
    user_input = input("Bạn: ")
    reply = generate_reply(user_input)
    print("Bot:", reply)
