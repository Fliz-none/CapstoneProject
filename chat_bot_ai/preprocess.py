import nltk
from nltk.tokenize import word_tokenize

nltk.download('punkt')

def tokenize(sentence):
    return word_tokenize(sentence.lower())

def preprocess_text(text):
    # Dùng tokenize rồi nối lại thành chuỗi
    return " ".join(tokenize(text))


def build_vocab(pairs):
    special_tokens = ["<PAD>", "<SOS>", "<EOS>", "<UNK>"]
    word2idx = {token: idx for idx, token in enumerate(special_tokens)}
    idx2word = list(special_tokens)

    for question, answer in pairs:
        for sentence in [question, answer]:
            for word in tokenize(sentence):
                if word not in word2idx:
                    word2idx[word] = len(idx2word)
                    idx2word.append(word)

    return word2idx, idx2word
