
const {
  connectDB,
  addStudent,
  getStudent,
  averageGrade
} = require("./students");

let client;

beforeAll(async () => {
  client = await connectDB();
});

beforeEach(async () => {
  await client.query("TRUNCATE TABLE students RESTART IDENTITY");
});

afterAll(async () => {
  await client.end();
});

test("Ajouter et lire un étudiant", async () => {
  await addStudent(client, "Sara", 15);

  const student = await getStudent(client, 1);

  expect(student.name).toBe("Sara");
  expect(Number(student.grade)).toBe(15);
});

test("Lire un étudiant inexistant", async () => {
  const student = await getStudent(client, 999);

  expect(student).toBeNull();
});

test("Calculer la moyenne", async () => {
  await addStudent(client, "Amel", 10);
  await addStudent(client, "Karim", 14);

  expect(await averageGrade(client)).toBe(12);
});
