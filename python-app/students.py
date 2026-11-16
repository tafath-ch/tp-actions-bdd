import psycopg2


def get_connection():
    return psycopg2.connect(
        host="localhost", dbname="tp", user="postgres", password="postgres"
    )


def add_student(conn, name, grade):
    with conn.cursor() as cur:
        cur.execute(
            "INSERT INTO students (name, grade) VALUES (%s, %s) RETURNING id",
            (name, grade),
        )
        new_id = cur.fetchone()[0]
    conn.commit()
    return new_id


def get_student(conn, student_id):
    with conn.cursor() as cur:
        cur.execute("SELECT name, grade FROM students WHERE id = %s", (student_id,))
        row = cur.fetchone()
    if row is None:
        return None
    return {"name": row[0], "grade": float(row[1])}


def average_grade(conn):
    with conn.cursor() as cur:
        cur.execute("SELECT AVG(grade) FROM students")
        result = cur.fetchone()[0]
    return float(result) if result is not None else 0.0
