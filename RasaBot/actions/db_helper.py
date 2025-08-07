from dotenv import load_dotenv
import pymysql
import os

class MySQLHelper:
    _instance = None
    _connection = None
    _config = None

    def __new__(cls):
        if cls._instance is None:
            cls._instance = super(MySQLHelper, cls).__new__(cls)
            cls._instance._initialize()
        return cls._instance

    def _initialize(self):
        load_dotenv()
        self._config = {
            "host": os.getenv("DB_HOST", "localhost"),
            "port": int(os.getenv("DB_PORT", 3306)),
            "user": os.getenv("DB_USERNAME", "root"),
            "database": os.getenv("DB_DATABASE", ""),
            "password": os.getenv("DB_PASSWORD", ""),
            "cursorclass": pymysql.cursors.DictCursor,
            "autocommit": True,
        }
        self._connection = pymysql.connect(**self._config)

    def _ensure_connection(self):
        if not self._connection or not self._connection.open:
            self._connection = pymysql.connect(**self._config)

    def fetch_one(self, query, params=None):
        self._ensure_connection()
        with self._connection.cursor() as cursor:
            cursor.execute(query, params or ())
            return cursor.fetchone()

    def fetch_all(self, query, params=None):
        self._ensure_connection()
        with self._connection.cursor() as cursor:
            cursor.execute(query, params or ())
            return cursor.fetchall()

    def execute(self, query, params=None):
        self._ensure_connection()
        with self._connection.cursor() as cursor:
            cursor.execute(query, params or ())
            return cursor.rowcount 