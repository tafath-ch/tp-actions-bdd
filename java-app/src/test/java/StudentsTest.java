
import org.junit.jupiter.api.*;
import java.sql.*;

import static org.junit.jupiter.api.Assertions.*;

public class StudentsTest {

    private Connection conn;

    @BeforeEach
    void setUp() throws Exception {
        conn = Students.connectDB();

        try (Statement stmt = conn.createStatement()) {
            stmt.executeUpdate(
                "TRUNCATE TABLE students RESTART IDENTITY"
            );
        }
    }

    @AfterEach
    void tearDown() throws Exception {
        conn.close();
    }

    @Test
    void testAddAndReadStudent() throws Exception {
        Students.addStudent(conn, "Sara", 15);

        ResultSet rs = Students.getStudent(conn, 1);

        assertTrue(rs.next());
        assertEquals("Sara", rs.getString("name"));
        assertEquals(15.0, rs.getDouble("grade"));
    }

    @Test
    void testStudentNotFound() throws Exception {
        ResultSet rs = Students.getStudent(conn, 999);

        assertFalse(rs.next());
    }

    @Test
    void testAverageGrade() throws Exception {
        Students.addStudent(conn, "Amel", 10);
        Students.addStudent(conn, "Karim", 14);

        assertEquals(12.0, Students.averageGrade(conn), 0.001);
    }
}
