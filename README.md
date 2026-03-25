# Group 8 — SCHOOL ATTENDANCE SYSTEM API

City College of Calamba
Department of Computing and Informatics
Midterm Output

---

## TEAM MEMBERS & CONTRIBUTIONS

| Team Member               | Role & Contribution |
| ------------------------- | ------------------- |
| Pasciolco, Joseph T.      | Leader – 100%       |
| Merano, Mark Joseph M.    | Member – 100%       |
| Jay-R Altoveros           | Member – 100%       |
| Laugian, Van Adriane      | Member – 100%       |
| Orjalezaz, Michael Leonel | Member – 60%        |

---

## SYSTEM FILE STRUCTURE

```
api/
 ├── students.php     # CRUD operations for students
 ├── subject.php      # CRUD operations for subjects
 └── attendance.php   # Attendance logging and relationships

config/
 └── database.php     # PostgreSQL connection setup

test.php              # Server/database connection test
database.sql          # (To be added) Full schema
```

---

## INSTALLATION & SETUP

### 1. Create Database & Tables

Run this in pgAdmin 4 Query Tool:

```sql
CREATE DATABASE attendance_db;
\connect attendance_db;

CREATE TABLE students (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE subjects (
    id SERIAL PRIMARY KEY,
    subject_name VARCHAR(100) NOT NULL
);

CREATE TABLE attendance (
    id SERIAL PRIMARY KEY,
    student_id INT NOT NULL REFERENCES students(id),
    subject_id INT NOT NULL REFERENCES subjects(id),
    attendance_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL
);
```

---

### 2. Update Database Credentials

Edit config/database.php:

```php
private $host = "localhost";
private $db_name = "attendance_db";
private $username = "postgres";
private $password = "09215101525";
```

Change only if your PostgreSQL credentials are different.

---

### 3. Run the API Locally

Using PHP built-in server:

```bash
php -S localhost:8000 -t Group8_School_Attendance_System
```

Test connection:

```
http://localhost:8000/test.php
```

---

## API BASE URL

```
http://localhost:8000/Group8_School_Attendance_System
```

---

## API ENDPOINTS

### 1. STUDENTS API (api/students.php)

Fields: id, name, email

| Method | Endpoint                  | Description        |
| ------ | ------------------------- | ------------------ |
| GET    | /api/students.php         | Get all students   |
| GET    | /api/students.php?id={id} | Get student by ID  |
| POST   | /api/students.php         | Create new student |
| PUT    | /api/students.php?id={id} | Update student     |
| DELETE | /api/students.php?id={id} | Delete student     |

Sample Response:

```json
{
  "id": 1,
  "name": "Joseph Pasciolco",
  "email": "joseph@gmail.com"
}
```

POST/PUT Body:

```json
{
  "name": "Joseph Pasciolco",
  "email": "joseph@gmail.com"
}
```

---

### 2. SUBJECTS API (api/subject.php)

Fields: id, subject_name

| Method | Endpoint                 | Description       |
| ------ | ------------------------ | ----------------- |
| GET    | /api/subject.php         | Get all subjects  |
| GET    | /api/subject.php?id={id} | Get subject by ID |
| POST   | /api/subject.php         | Create subject    |
| PUT    | /api/subject.php?id={id} | Update subject    |
| DELETE | /api/subject.php?id={id} | Delete subject    |

Sample Response:

```json
{
  "id": 1,
  "subject_name": "Object-Oriented Programming"
}
```

POST/PUT Body:

```json
{
  "subject_name": "Object-Oriented Programming"
}
```

---

### 3. ATTENDANCE API (api/attendance.php)

Fields: id, student_id, subject_id, attendance_date, status

| Method | Endpoint                    | Description       |
| ------ | --------------------------- | ----------------- |
| GET    | /api/attendance.php         | Get all records   |
| GET    | /api/attendance.php?id={id} | Get record by ID  |
| POST   | /api/attendance.php         | Create attendance |
| PUT    | /api/attendance.php?id={id} | Update attendance |
| DELETE | /api/attendance.php?id={id} | Delete record     |

Sample Response:

```json
{
  "id": 1,
  "student": "Joseph Pasciolco",
  "subject": "Object-Oriented Programming",
  "attendance_date": "2024-03-26",
  "status": "Present"
}
```

POST/PUT Body:

```json
{
  "student_id": 1,
  "subject_id": 1,
  "attendance_date": "2024-03-26",
  "status": "Present"
}
```

---
