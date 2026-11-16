
<?php

class Students
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = new PDO(
            "pgsql:host=localhost;port=5432;dbname=tp",
            "postgres",
            "postgres"
        );

        $this->conn->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    public function addStudent(string $name, float $grade): void
    {
        $sql = "INSERT INTO students (name, grade) VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $grade]);
    }

    public function getStudent(int $id): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM students WHERE id = ?"
        );

        $stmt->execute([$id]);

        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        return $student ?: null;
    }

    public function averageGrade(): float
    {
        $stmt = $this->conn->query(
            "SELECT AVG(grade) FROM students"
        );

        return (float) $stmt->fetchColumn();
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
