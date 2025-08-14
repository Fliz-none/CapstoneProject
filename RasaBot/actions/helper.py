import re
from datetime import datetime, date


class Helper:
    @staticmethod
    def extract_order_numeric_id(order_id):
        match = re.search(r"\d+", order_id)
        return int(match.group()) if match else None

    @staticmethod
    def dict_with_serialized_datetimes(row):
        return {
            key: (value.isoformat() if isinstance(value, (datetime, date)) else value)
            for key, value in dict(row).items()
        }

    @staticmethod
    def get_customer_id(tracker):
        try:
            return int(tracker.sender_id)
        except (ValueError, TypeError):
            return None

    @staticmethod
    def get_order_numeric_id_from_slot(tracker):
        order_id = tracker.get_slot("order_id")
        if not order_id:
            return None, "Vui lòng cung cấp mã đơn hàng."

        order_numeric_id = Helper.extract_order_numeric_id(order_id)
        if not order_numeric_id:
            return None, "Mã đơn hàng không hợp lệ."

        return order_numeric_id, None
