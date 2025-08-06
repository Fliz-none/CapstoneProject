from rasa_sdk import Action, Tracker
from rasa_sdk.executor import CollectingDispatcher
from .db_helper import MySQLHelper
from .helper import Helper
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


class ActionCheckProduct(Action):
    def name(self) -> str:
        return "action_check_product"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        product_name = tracker.get_slot("product_name")
        if not product_name:
            dispatcher.utter_message(text="Bạn vui lòng cung cấp tên sản phẩm.")
            return []

        try:
            result = db.fetch_one(
                """
                SELECT 
                    p.id,
                    p.name,
                    p.excerpt,
                    p.description,
                    GROUP_CONCAT(DISTINCT c.name) AS catalogues,
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
                (product_name, product_name)
            )
            if result:
                product_data = Helper.dict_with_serialized_datetimes(result)
                dispatcher.utter_message(
                    text=f"Sản phẩm `{product_name}` có thông tin chi tiết như sau:",
                      json_message={
                        "action": "ask_product",
                        "product": product_data
                    }
                )
            else:
                dispatcher.utter_message(text=f"Không tìm thấy sản phẩm `{product_name}`.")
        except Exception as e:
            dispatcher.utter_message(text=f"Lỗi hệ thống: {str(e)}. Vui lòng thử lại.")
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
                    json_message={
                        "branches": results, 
                        "action": "ask_branch"
                    }
                )
            else:
                dispatcher.utter_message(text="Không tìm thấy chi nhánh nào.")
        except Exception as e:
            dispatcher.utter_message(text=f"Lỗi hệ thống: {str(e)}. Vui lòng thử lại.")
        
        return []


class ActionAskPost(Action):
    def name(self) -> str:
        return "action_ask_post"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        try:
            results = db.fetch_all("""
                SELECT title, excerpt, content, created_at
                FROM posts
                ORDER BY created_at DESC
                LIMIT 3
            """)
            if results:
                for row in results:
                    if "created_at" in row and isinstance(row["created_at"], (datetime, )):
                        row["created_at"] = row["created_at"].isoformat()

                dispatcher.utter_message(
                    text="Dưới đây là một số bài viết mới nhất:",
                    json_message={
                        "posts": results,
                        "action": "ask_post"
                    }
                )
            else:
                dispatcher.utter_message(text="Hiện tại chưa có bài viết nào.")
        except Exception as e:
            dispatcher.utter_message(text=f"Lỗi hệ thống: {str(e)}. Vui lòng thử lại.")
        return []


class ActionAskCompany(Action):
    def name(self) -> str:
        return "action_ask_company"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        try:
            results = db.fetch_all("""
                SELECT `key`, `value`
                FROM settings
            """)
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
                    "social_telegram": settings.get("social_telegram")
                }

                dispatcher.utter_message(
                    text="Đây là thông tin chi tiết của công ty:",
                    json_message={
                        "shop_info": shop_info,
                        "action": "ask_company"
                    }
                )
            else:
                dispatcher.utter_message(text="Chưa có thông tin cấu hình.")
        except Exception as e:
            dispatcher.utter_message(text=f"Lỗi hệ thống: {str(e)}. Vui lòng thử lại.")
        return []

class ActionAskPromotions(Action):
    def name(self) -> str:
        return "action_ask_promotions"

    def run(self, dispatcher: CollectingDispatcher, tracker: Tracker, domain: dict):
        branch = tracker.get_slot("branch_name")

        if not branch:
            dispatcher.utter_message(text="Bạn muốn hỏi khuyến mãi ở chi nhánh nào?")
            return []

        # Bỏ dấu và lowercase tên chi nhánh người dùng nhập
        branch_no_accent = unidecode(branch).lower()

        # Lấy tất cả các chi nhánh và bỏ dấu để so sánh
        all_branches = db.fetch_all("SELECT id, name FROM branches")

        matched_branch_ids = []
        for b in all_branches:
            name_no_accent = unidecode(b["name"]).lower()
            if branch_no_accent in name_no_accent:
                matched_branch_ids.append(b["id"])

        if not matched_branch_ids:
            dispatcher.utter_message(text=f"Không tìm thấy chi nhánh nào giống '{branch}'")
            return []

        # Truy vấn khuyến mãi theo danh sách branch_id tìm được
        format_strings = ','.join(['%s'] * len(matched_branch_ids))
        query = f"""
            SELECT d.*
            FROM discounts d
            WHERE d.branch_id IN ({format_strings})
            ORDER BY d.start_date DESC
            LIMIT 5
        """
        results = db.fetch_all(query, matched_branch_ids)

        if results:
            for row in results:
                if "start_date" in row and isinstance(row["start_date"], datetime):
                    row["start_date"] = row["start_date"].isoformat()
                if "end_date" in row and isinstance(row["end_date"], datetime):
                    row["end_date"] = row["end_date"].isoformat()

            dispatcher.utter_message(
                text=f"Đây là các khuyến mãi tại chi nhánh gần giống '{branch}':",
                json_message={
                    "promotions": results,
                    "action": "ask_promotions"
                }
            )
        else:
            dispatcher.utter_message(text=f"Không có khuyến mãi nào tại chi nhánh gần giống '{branch}'.")

        return []
