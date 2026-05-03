# Moonje College Management System

A complete College Management System built with **PHP + MySQL** for **XAMPP**.
Includes a public landing page plus full **Student** and **Teacher** modules.

## Features

### Student Module
- Register / Login / Logout
- Dashboard with pending fees, upcoming exams, notices and events
- View Syllabus (course / year specific)
- View Class Time Table
- Examination Schedule
- Fees statement (paid / pending / partial)
- Notices feed
- Events list
- Get Direction (embedded Google Map + contact info)
- Profile (update phone / address)

### Teacher Module
- Login / Logout
- Dashboard with statistics
- View / Add / Delete Students
- Add / View / Delete Notices
- Add / View / Delete Events
- Manage Time Table (per course/year, multiple periods/days)
- Add / View / Delete Examination schedule
- Manage Fees records (add / track / delete)

---

## Setup Instructions (XAMPP)

### 1. Copy the project
Copy the entire `college-management/` folder into your XAMPP htdocs directory:

```
C:\xampp\htdocs\college-management\
```

### 2. Start XAMPP
Open the **XAMPP Control Panel** and start:
- **Apache**
- **MySQL**

### 3. Create the database
Open your browser and go to:

```
http://localhost/phpmyadmin
```

Then either:
- **Option A (recommended):** Click the **Import** tab → choose `database.sql` → click **Go**.
  This creates the `college_db` database with all tables and sample data automatically.
- **Option B:** Click **New** → name it `college_db` → click **Create** → select it → **Import** → choose `database.sql` → **Go**.

### 4. Open the website
Visit:

```
http://localhost/college-management/
```

### 5. Default Login Credentials

**Teacher (Admin):**
```
Email:    admin@college.edu
Password: admin123
```

Other sample teachers (all use password `admin123`):
- priya@college.edu
- amit@college.edu

**Student:**
```
Email:    student@college.edu
Password: admin123
```

Other sample students: sneha@college.edu, arjun@college.edu (also `admin123`).

You can also register new students from the Student → Register page.

---

## Project Structure

```
college-management/
├── README.md                ← this file
├── database.sql             ← MySQL schema + sample data
├── index.php                ← public landing page
│
├── config/
│   └── db.php               ← database connection + helpers
│
├── includes/                ← reusable header/footer/sidebar
│   ├── header_public.php
│   ├── footer.php
│   ├── student_header.php
│   ├── student_footer.php
│   ├── teacher_header.php
│   └── teacher_footer.php
│
├── assets/
│   └── css/style.css        ← single stylesheet
│
├── student/
│   ├── login.php            register.php   logout.php
│   ├── dashboard.php
│   ├── syllabus.php         timetable.php
│   ├── examination.php      fees.php
│   ├── notices.php          events.php
│   ├── direction.php        profile.php
│
└── teacher/
    ├── login.php            logout.php
    ├── dashboard.php
    ├── students.php         add_student.php   view_student.php
    ├── notices.php          add_notice.php
    ├── timetable.php        add_timetable.php
    ├── events.php           add_event.php
    ├── exams.php            add_exam.php
    └── fees.php
```

---

## Database Tables

| Table          | Purpose                              |
|----------------|--------------------------------------|
| `students`     | Student accounts and profiles        |
| `teachers`     | Teacher / admin accounts             |
| `notices`      | College notices and announcements    |
| `events`       | Upcoming and past events             |
| `syllabus`     | Course-wise subject syllabus         |
| `fees`         | Per-student fee statements           |
| `examinations` | Exam schedules                       |
| `timetable`    | Weekly class periods                 |

---

## Tech Stack

- **PHP 7.4+ / 8.x** (works with default XAMPP)
- **MySQL / MariaDB**
- **Vanilla CSS** (no external frameworks)
- **Sessions** for authentication
- **bcrypt** (`password_hash`) for password security
- **Prepared statements** for SQL safety

---

## Common Issues

**"Connection failed"** → Make sure MySQL is running in XAMPP and `college_db` exists.

**"Table doesn't exist"** → Re-import `database.sql` from phpMyAdmin.

**Login not working with sample accounts** → Use exact emails listed above with password `admin123`.

**Want to reset everything?** → Drop the `college_db` database in phpMyAdmin and re-import `database.sql`.

---

## Customization Tips

- Change college name / branding in `includes/header_public.php`, `student_header.php`, `teacher_header.php`.
- Theme colors live at the top of `assets/css/style.css` (CSS variables).
- Map location: edit the iframe `src` in `student/direction.php`.
- DB credentials: `config/db.php`.

Enjoy! 🎓
