from rasa_sdk import Action, Tracker
from rasa_sdk.executor import CollectingDispatcher
from db_helper import MySQLHelper
from helper import Helper
import time

# Singleton DB instance
db = MySQLHelper()


# ORDER ACTION
class ActionCheckOrder(Action):
    def name(self) -> str:
        return "action_check_order"

    def run(self, dispatcher, tracker, domain):
        order_id = tracker.get_slot("order_id")
        order_numeric_id, error = Helper.get_order_numeric_id_from_slot(tracker)
        if error:
            dispatcher.utter_message(text=error)
            return []
        customer_id = Helper.get_customer_id(tracker)
        if customer_id is None:
            dispatcher.utter_message(text="Dữ liệu không hợp lệ.")
            return []
        try:
            # Fetch đơn hàng và chi tiết
            result = db.fetch_one(
                """
                    SELECT 
                        o.*, 
                        JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'product_name', p.name,
                                'variable_name', v.name,
                                'unit_name', u.term,
                                'gallery', p.gallery,
                                'quantity', d.quantity,
                                'price', d.price
                            )
                        ) AS details
                    FROM orders o
                    LEFT JOIN details d ON o.id = d.order_id
                    LEFT JOIN units u ON d.unit_id = u.id
                    LEFT JOIN variables v ON u.variable_id = v.id
                    LEFT JOIN products p ON v.product_id = p.id
                    WHERE o.id = %s AND o.customer_id = %s
                    GROUP BY o.id
                """,
                (order_numeric_id, customer_id),
            )

            if result:
                status = result.get("status")
                customer = result.get("customer_name", "Khách hàng")
                # Chuyển datetime về chuỗi nếu cần
                order_data = Helper.dict_with_serialized_datetimes(result)

                dispatcher.utter_message(
                    text=f"Đơn hàng `{order_id}` của {customer} hiện: {Helper.render_order_status(status)}.",
                    json_message={"order": order_data},
                )
            else:
                dispatcher.utter_message(
                    text=f"Không tìm thấy đơn hàng `{order_id}`. Vui lòng thử lại sau."
                )
        except Exception as e:
            dispatcher.utter_message(
                text=f"Lỗi hệ thống: {str(e)}! Vui lòng thử lại sau."
            )
        return []


class ActionCancelOrder(Action):
    def name(self) -> str:
        return "action_cancel_order"

    def run(self, dispatcher, tracker, domain):
        order_id = tracker.get_slot("order_id")
        order_numeric_id, error = Helper.get_order_numeric_id_from_slot(tracker)
        if error:
            dispatcher.utter_message(text=error)
            return []

        customer_id = Helper.get_customer_id(tracker)
        if customer_id is None:
            dispatcher.utter_message(text="Dữ liệu không hợp lệ.")
            return []

        try:
            affected = db.execute(
                "UPDATE orders SET status = 0 WHERE id = %s AND customer_id = %s",
                (order_numeric_id, customer_id),
            )

            if affected > 0:
                dispatcher.utter_message(text=f"Đơn hàng `{order_id}` đã được hủy.")
            else:
                dispatcher.utter_message(text="Đơn hàng thuộc về bạn hoặc đã bị hủy.")
        except Exception as e:
            dispatcher.utter_message(text=f"Lỗi hệ thống: {str(e)}")

        return []


class ActionAskToConfirmCancel(Action):
    def name(self) -> str:
        return "action_ask_to_confirm_cancel"

    def run(self, dispatcher, tracker, domain):
        order_id = tracker.get_slot("order_id")
        if not order_id:
            dispatcher.utter_message(
                text="Bạn muốn hủy đơn hàng nào? Vui lòng cung cấp mã đơn."
            )
            return []
        dispatcher.utter_message(
            text=f"Bạn có chắc chắn muốn hủy đơn hàng `{order_id}` không?"
        )
        return []


# PRODUCT ACTION
class ActionCheckStock(Action):
    def name(self) -> str:
        return "action_check_stock"

    def run(self, dispatcher, tracker, domain):
        product = tracker.get_slot("product_name")
        print(str(product) + " ====================== ")
        print("Slots:", tracker.current_slot_values())
        if not product:
            dispatcher.utter_message(text="Bạn muốn hỏi sản phẩm nào?")
            return []

        try:
            wildcard = f"%{product}%"
            results = db.fetch_all(
                """
                SELECT 
                    p.name AS product_name,
                    pv.name AS variable_name,
                    pu.term AS unit_term,
                    pu.price AS unit_price,
                    SUM(s.quantity * pu.rate) AS total_base_unit
                FROM 
                    products p
                JOIN variables pv ON pv.product_id = p.id
                JOIN units pu ON pu.variable_id = pv.id
                JOIN import_details ip ON ip.unit_id = pu.id
                JOIN stocks s ON s.import_detail_id = ip.id
                WHERE 
                    (p.name LIKE %s OR pv.name LIKE %s OR pu.term LIKE %s)
                    AND s.quantity > 0
                GROUP BY 
                    pv.id, pu.id
                """,
                (wildcard, wildcard, wildcard),
            )

            if results:
                dispatcher.utter_message(
                    text="Tìm thấy " + str(len(results)) + " kết quả"
                )

                # Gửi kèm JSON nếu cần
                data = [
                    Helper.dict_with_serialized_datetimes(row) for row in results
                ]
                dispatcher.utter_message(json_message={"stock": data})

            else:
                dispatcher.utter_message(
                    text=f"Có vẻ '{product}' đã hết hàng. Chọn sản phẩm khác bạn nhé!"
                )

        except Exception as e:
            dispatcher.utter_message(text=f"Lỗi hệ thống: {str(e)}")
        return []
