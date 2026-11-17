import pytest
from students import get_connection, add_student, get_student, average_grade


@pytest.fixture
def conn():
    c = get_connection()
    with c.cursor() as cur:
        cur.execute("TRUNCATE students RESTART IDENTITY")  # table vidée avant chaque test
    c.commit()
    yield c
    c.close()


def test_ajout_et_lecture(conn):
    new_id = add_student(conn, "Sara", 16)
    student = get_student(conn, new_id)
    assert student["name"] == "Sara"
    assert student["grade"] == 16.0


def test_etudiant_inexistant(conn):
    assert get_student(conn, 999) is None


def test_moyenne(conn):
    add_student(conn, "Amel", 10)
    add_student(conn, "Karim", 14)
    assert average_grade(conn) == 13.0
