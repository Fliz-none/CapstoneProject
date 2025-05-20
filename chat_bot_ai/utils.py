import mysql.connector
from dotenv import load_dotenv
import os, re, torch
from preprocess import tokenize

# Load biến môi trường từ file .env
load_dotenv()

def get_connection():
    """
    Kết nối tới database laravel core
    """
    return mysql.connector.connect(
        host=os.getenv("DB_HOST"),
        user=os.getenv("DB_USER"),
        password=os.getenv("DB_PASSWORD"),
        database=os.getenv("DB_NAME")
    )

def check_stock(product_name):
    try:
        conn = get_connection()
        cursor = conn.cursor(dictionary=True)

        query = """
            SELECT 
                p.name AS product_name,
                pv.name AS variable_name,
                pu.term AS unit_term,
                SUM(s.quantity * pu.rate) AS total_base_unit
            FROM 
                products p
            JOIN variables pv ON pv.product_id = p.id
            JOIN units pu ON pu.variable_id = pv.id
            JOIN import_details ip ON ip.unit_id = pu.id
            JOIN stocks s ON s.import_detail_id = ip.id
            WHERE 
                (p.name LIKE %s
                OR pv.name LIKE %s
                OR pu.term LIKE %s)
                AND s.quantity > 0
            GROUP BY 
                pv.id, pu.id;
        """

        cursor.execute(query, (f"%{product_name}%", f"%{product_name}%", f"%{product_name}%"))
        results = cursor.fetchall()

        if not results:
            return f"Trong kho đã hết sản phẩm {product_name} rồi ạ."

        # Format kết quả
        response = f"Dạ bên em còn {product_name} ạ"

        for result in results:
            response += f" - Tên sản phẩm : {result['product_name']}"
            response += f" - Biến thể : {result['variable_name']}"
            response += f" - Đơn vị : {result['unit_term']}"
            response += f" - Số lượng : {result['total_base_unit']}"
        return response

    except Exception as e:
        return f"Lỗi truy vấn kho hàng: {e}"

    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

def extract_product_name(user_input):
    """
    Tách tên sản phẩm từ câu hỏi của người dùng dựa vào từ khóa cố định.
    Nếu không chứa từ khóa nào thì trả về None.
    """
    # Đưa về chữ thường để dễ xử lý
    lowered_input = user_input.lower()

    # Các cụm từ khóa cần có trong câu hỏi
    keywords = [
        "còn hàng không", "còn hàng", "có hàng không",
        "còn không", "kiểm tra", "còn không shop", 
        "có không", "còn không vậy", "còn hàng không shop",
        "có hàng không shop",
        "còn không vậy shop"
    ]
    
    keywords = sorted(keywords, key=len, reverse=True)
    # Nếu không chứa bất kỳ từ khóa nào thì trả về None
    if not any(kw in lowered_input for kw in keywords):
        return None
    # Loại bỏ các từ khóa
    for word in keywords:
        lowered_input = lowered_input.replace(word, '')
    # Loại bỏ dấu câu
    lowered_input = re.sub(r'[?.!,]', '', lowered_input)
    # Loại bỏ khoảng trắng dư thừa
    product_name = lowered_input.strip()
    return product_name if product_name else None

def evaluate(sentence, encoder, decoder, word2idx, idx2word, max_length=20):
    tokens = tokenize(sentence)
    input_indices = [word2idx.get(word, word2idx["<UNK>"]) for word in tokens]
    input_tensor = torch.tensor(input_indices).unsqueeze(1)  # (seq_len, batch=1)

    hidden = encoder(input_tensor)

    decoder_input = torch.tensor([[word2idx["<SOS>"]]])  # (1,1)

    decoded_words = []

    for _ in range(max_length):
        output, hidden = decoder(decoder_input, hidden)
        topv, topi = output.topk(1)
        next_word_idx = topi.item()
        next_word = idx2word[next_word_idx]

        if next_word == "<EOS>":
            break
        decoded_words.append(next_word)

        decoder_input = topi.detach().view(1, 1)

    # Trường hợp không sinh ra từ hoặc chỉ sinh ra 1 từ không có ý nghĩa
    if not decoded_words or len(decoded_words) < 2:
        return "Chatbot chưa có dữ liệu cho câu hỏi của anh/chị. Vui lòng đợi nhân viên tư vấn."

    return " ".join(decoded_words)