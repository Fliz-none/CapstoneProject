# data.py
import jsonlines

def load_data_jsonl(file_path):
    pairs = []
    with jsonlines.open(file_path) as reader:
        for obj in reader:
            question = obj.get("input")
            answer = obj.get("output")
            if question and answer:
                pairs.append((question.lower(), answer.lower()))
    return pairs
