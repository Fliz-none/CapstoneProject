from rasa_sdk import Action, Tracker
from rasa_sdk.executor import CollectingDispatcher
from db_helper import MySQLHelper
from helper import Helper
from rasa_sdk.events import UserUtteranceReverted
from rasa_sdk.events import SlotSet
from datetime import datetime
from unidecode import unidecode
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
                        o.id,
                        o.customer_id
                    FROM orders o
                    WHERE o.id = %s AND o.customer_id = %s
                    GROUP BY o.id
                """,
                (order_numeric_id, customer_id),
            )

            if result:
                status = result.get("status")
                # Chuyển datetime về chuỗi nếu cần
                order_data = Helper.dict_with_serialized_datetimes(result)

                dispatcher.utter_message(
                    text=f"🧾Dưới đây là thông tin đơn hàng của bạn: ",
                    json_message={"order": order_data, "action": "check_order"},
                )
            else:
                dispatcher.utter_message(
                    text=f"Không tìm thấy đơn hàng `{order_id}`. Vui lòng kiểm tra lại."
                )
        except Exception as e:
            dispatcher.utter_message(
                text=f"💥Lỗi hệ thống: {str(e)}! Vui lòng thử lại sau."
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
                dispatcher.utter_message(text=f"❌Đơn hàng `{order_id}` đã được hủy.")
            else:
                dispatcher.utter_message(text="❌Đơn hàng thuộc về bạn hoặc đã bị hủy.")
        except Exception as e:
            dispatcher.utter_message(text=f"💥Lỗi hệ thống: {str(e)}")

        return []


class ActionAskToConfirmCancel(Action):
    def name(self) -> str:
        return "action_ask_to_confirm_cancel"

    def run(self, dispatcher, tracker, domain):
        order_id = tracker.get_slot("order_id")
        if not order_id:
            dispatcher.utter_message(
                text="❌Bạn muốn hủy đơn hàng nào? Vui lòng cung cấp mã đơn."
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
            dispatcher.utter_message(text="Bạn cho biết thêm thông tin sản phẩm được không?")
            return []

        try:
            wildcard = f"%{product}%"
            results = db.fetch_all(
                """
                SELECT 
                    p.id AS product_id,
                    p.name AS product_name,
                    pv.name AS variable_name,
                    pu.term AS unit_term,
                    pu.price AS unit_price,
                    SUM(s.quantity) AS total_base_unit
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
                    text="🔍 Tìm thấy một số kết quả phù hợp theo yêu cầu của bạn:"
                )

                data = [Helper.dict_with_serialized_datetimes(row) for row in results]
                dispatcher.utter_message(json_message={
                    "stock": data,
                    "action": "check_stock",
                    "text": f"Tìm thấy {len(results)} kết quả."
                })

                first_product = results[0]
                return [
                    SlotSet("last_product_id", first_product["product_id"]),
                    SlotSet("last_product_name", first_product["product_name"])
                ]
            else:
                dispatcher.utter_message(
                    text=f"Có vẻ sản phẩm bạn tìm đã hết hàng. Chọn sản phẩm khác bạn nhé!"
                )
                return []

        except Exception as e:
            dispatcher.utter_message(text=f"💥 Lỗi hệ thống: {str(e)}")
            return []


class ActionCheckProduct(Action):
    def name(self) -> str:
        return "action_check_product"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        product_name = tracker.get_slot("product_name")
        if not product_name:
            dispatcher.utter_message(text="Bạn vui lòng cung cấp thêm tên sản phẩm nhé.")
            return []

        try:
            result = db.fetch_one(
                """
                SELECT 
                    p.*,
                    GROUP_CONCAT(DISTINCT c.name) AS catalogues,
                    GROUP_CONCAT(DISTINCT c.slug) AS catalogue_slug,
                    GROUP_CONCAT(DISTINCT v.name) AS variables,
                    GROUP_CONCAT(DISTINCT u.term) AS units,
                    GROUP_CONCAT(DISTINCT d.name) AS discounts
                FROM products p
                LEFT JOIN catalogue_product cp ON cp.product_id = p.id
                LEFT JOIN catalogues c ON c.id = cp.catalogue_id
                LEFT JOIN variables v ON v.product_id = p.id
                LEFT JOIN units u ON u.variable_id = v.id
                LEFT JOIN discount_unit du ON du.unit_id = u.id
                LEFT JOIN discounts d ON d.id = du.discount_id
                WHERE 
                    SOUNDEX(p.name) = SOUNDEX(%s)
                    OR LOWER(p.name) LIKE LOWER(CONCAT('%%', %s, '%%'))
                GROUP BY p.id
                """,
                (product_name, product_name),
            )

            if result:
                product_data = Helper.dict_with_serialized_datetimes(result)

                dispatcher.utter_message(
                    text="ℹ️ Dưới đây là thông tin chi tiết:",
                    json_message={"action": "ask_product", "product": product_data},
                )

                return [
                    SlotSet("last_product_id", product_data["id"]),
                    SlotSet("last_product_name", product_data["name"])
                ]
            else:
                dispatcher.utter_message(
                    text=f"❌ Không tìm thấy sản phẩm liên quan. Vui lòng thử với sản phẩm khác nhé!"
                )
                return []

        except Exception as e:
            dispatcher.utter_message(text=f"💥 Lỗi hệ thống: {str(e)}. Vui lòng thử lại.")
            return []

class ActionAskBranch(Action):
    def name(self) -> str:
        return "action_ask_branch"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        try:
            results = db.fetch_all("SELECT name, address, phone FROM branches")

            if results:
                dispatcher.utter_message(
                    text="Các chi nhánh của cửa hàng gồm:",
                    json_message={"branches": results, "action": "ask_branch"},
                )
            else:
                dispatcher.utter_message(text="Không tìm thấy chi nhánh nào.")
        except Exception as e:
            dispatcher.utter_message(text=f"💥Lỗi hệ thống: {str(e)}. Vui lòng thử lại.")

        return []


class ActionAskPost(Action):
    def name(self) -> str:
        return "action_ask_post"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        try:
            results = db.fetch_all(
                """
                SELECT p.*, c.name AS category, c.slug as category_slug
                FROM posts p
                LEFT JOIN categories c ON c.id = p.category_id
                ORDER BY p.created_at DESC
                LIMIT 3;
                """
            )

            if results:
                data = [Helper.dict_with_serialized_datetimes(row) for row in results]
                dispatcher.utter_message(
                    text="Dưới đây là một số bài viết mới nhất:",
                    json_message={"posts": data, "action": "ask_post"},
                )
            else:
                dispatcher.utter_message(text="Hiện tại chưa có bài viết nào.")
        except Exception as e:
            dispatcher.utter_message(text=f"💥Lỗi hệ thống: {str(e)}. Vui lòng thử lại.")
        return []

class ActionAskCompany(Action):
    def name(self) -> str:
        return "action_ask_company"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        try:
            results = db.fetch_all(
                """
                SELECT `key`, `value`
                FROM settings
            """
            )
            if results:
                settings = {row["key"]: row["value"] for row in results}
                shop_info = {
                    "company_name": settings.get("company_name"),
                    "company_introduce": settings.get("company_introduce"),
                    "company_description": settings.get("company_description"),
                    "company_slogan": settings.get("company_slogan"),
                    "company_address": settings.get("company_address"),
                    "company_hotline": settings.get("company_hotline"),
                    "company_email": settings.get("company_email"),
                    "social_facebook": settings.get("social_facebook"),
                    "social_zalo": settings.get("social_zalo"),
                    "social_youtube": settings.get("social_youtube"),
                    "social_tiktok": settings.get("social_tiktok"),
                    "social_telegram": settings.get("social_telegram"),
                }

                dispatcher.utter_message(
                    text="🏢Đây là thông tin chi tiết của công ty:",
                    json_message={"shop_info": shop_info, "action": "ask_company"},
                )
            else:
                dispatcher.utter_message(text="Chưa có thông tin cấu hình.")
        except Exception as e:
            dispatcher.utter_message(text=f"💥Lỗi hệ thống: {str(e)}. Vui lòng thử lại.")
        return []



class ActionAskPromotions(Action):
    def name(self) -> str:
        return "action_ask_promotions"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        today = datetime.now().date()

        query = """
            SELECT 
                d.*,
                b.name AS branch_name,
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'product_name', p.name,
                        'variable_name', v.name,
                        'unit_name', u.term
                    )
                ) AS products
            FROM discounts d
            JOIN branches b ON d.branch_id = b.id
            JOIN discount_unit du ON du.discount_id = d.id
            JOIN units u ON du.unit_id = u.id
            JOIN variables v ON u.variable_id = v.id
            JOIN products p ON v.product_id = p.id
            WHERE d.start_date <= %s
              AND (d.end_date IS NULL OR d.end_date >= %s)
              AND d.status = 1
            GROUP BY d.id, b.name
            ORDER BY d.start_date DESC
            LIMIT 5
        """
        results = db.fetch_all(query, (today, today))

        if results:
            data = [Helper.dict_with_serialized_datetimes(row) for row in results]

            dispatcher.utter_message(
                text="Dưới đây là các khuyến mãi hấp dẫn đang diễn ra:",
                json_message={"promotions": data, "action": "ask_promotions"},
            )
        else:
            dispatcher.utter_message(
                text="Hiện không có khuyến mãi nào đang diễn ra."
            )

        return []

class ActionDefaultFallback(Action):
    def name(self):
        return "action_default_fallback"

    def run(self, dispatcher: CollectingDispatcher,
            tracker: Tracker,
            domain: dict):

        last_intent = tracker.latest_message.get("intent", {}).get("name")
        active_loop = tracker.active_loop.get("name")

        if last_intent == "affirm_cancel" and not active_loop:
            dispatcher.utter_message(text="👍Ok, tiếp tục nhé!")
            return [UserUtteranceReverted()]  # Chặn vòng lặp

        dispatcher.utter_message(text="Xin lỗi, mình chưa hiểu. Bạn nói rõ hơn nhé?")
        return []

class ActionCheckPrice(Action):
    def name(self) -> str:
        return "action_check_price"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        product_id = tracker.get_slot("last_product_id")
        product_name = tracker.get_slot("last_product_name")

        if not product_id:
            dispatcher.utter_message(text="Bạn muốn hỏi giá sản phẩm nào ạ?")
            return []

        try:
            result = db.fetch_one(
                """
                SELECT MIN(u.price) as min_price, MAX(u.price) as max_price
                FROM units u
                JOIN variables v ON v.id = u.variable_id
                WHERE v.product_id = %s
                """,
                (product_id,),
            )

            if result and result["min_price"] is not None:
                if result["min_price"] == result["max_price"]:
                    dispatcher.utter_message(text=f"💰 Giá của {product_name} là {result['min_price']:,}đ")
                else:
                    dispatcher.utter_message(
                        text=f"💰{product_name} có giá từ {result['min_price']:,}đ đến {result['max_price']:,}đ"
                    )
            else:
                dispatcher.utter_message(text=f"❌ Không tìm thấy giá cho {product_name}.")
        except Exception as e:
            dispatcher.utter_message(text=f"💥 Lỗi hệ thống: {str(e)}.")
        return []