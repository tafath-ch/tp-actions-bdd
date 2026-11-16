
<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Students.php';

class StudentsTest extends TestCase
{
    private Students $students;

    protected function setUp(): void
    {
        $this->students = new Students();

        $this->students->getConnection()->exec(
            "TRUNCATE TABLE students RESTART IDENTITY"
        );
    }

    public function testAddAndReadStudent(): void
    {
        $this->students->addStudent("Sara", 15);

        $student = $this->students->getStudent(1);

        $this->assertEquals("Sara", $student["name"]);
        $this->assertEquals(15, (float) $student["grade"]);
    }

    public function testStudentNotFound(): void
    {
        $student = $this->students->getStudent(999);

        $this->assertNull($student);
    }

    public function testAverageGrade(): void
    {
        $this->students->addStudent("Amel", 10);
        $this->students->addStudent("Karim", 14);

        $this->assertEquals(
            12.0,
            $this->students->averageGrade()
        );
    }
}
