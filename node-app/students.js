
const { Client } = require("pg");

async function connectDB() {
  const client = new Client({
    host: "localhost",
    port: 5432,
    user: "postgres",
    password: "postgres",
    database: "tp"
  });

  await client.connect();
  return client;
}

async function addStudent(client, name, grade) {
  await client.query(
    "INSERT INTO students (name, grade) VALUES ($1, $2)",
    [name, grade]
  );
}

async function getStudent(client, id) {
  const result = await client.query(
    "SELECT * FROM students WHERE id = $1",
    [id]
  );

  return result.rows[0] || null;
}

async function averageGrade(client) {
  const result = await client.query(
    "SELECT AVG(grade) FROM students"
  );

  return Number(result.rows[0].avg);
}

module.exports = {
  connectDB,
  addStudent,
  getStudent,
  averageGrade
};
