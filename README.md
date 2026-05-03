# EduNexus – Smart College Management System

EduNexus is a modern **College Management System** designed for educational institutions to streamline academic, administrative, and student-related operations. Built using **PHP** and **MySQL**, the platform provides an intuitive and efficient digital environment for students, faculty, and administrators.

It offers a centralized solution for managing student records, academic activities, notices, events, examinations, fees, and campus-related information.

---

## Features

### Student Module

* Secure Registration, Login, and Logout
* Personalized Student Dashboard
* View Course-wise Syllabus
* Access Class Timetable
* Check Examination Schedule
* View Fee Status and Payment History
* Read Notices and Announcements
* Explore Upcoming College Events
* Campus Navigation with Google Maps Integration
* Update Personal Profile Information

### Teacher / Admin Module

* Secure Login and Logout
* Administrative Dashboard with Key Statistics
* Add, View, Edit, and Delete Student Records
* Publish and Manage Notices
* Create and Manage College Events
* Manage Class Timetables
* Schedule and Manage Examinations
* Maintain Student Fee Records
* Monitor Academic and Administrative Activities

---

## Technology Stack

* **Frontend:** HTML5, CSS3, JavaScript
* **Backend:** PHP
* **Database:** MySQL
* **Server Environment:** XAMPP / Apache
* **Authentication:** PHP Sessions
* **Security:** Password Hashing and Prepared Statements

---

## Project Modules

* Student Management
* Teacher Management
* Notice Management
* Event Management
* Examination Management
* Fee Management
* Timetable Management
* Syllabus Management
* Campus Navigation System

---

## Installation and Setup

### Prerequisites

* XAMPP (Apache and MySQL)
* Web Browser (Chrome, Edge, Firefox)

### Steps to Run the Project

1. Clone or download this repository.
2. Copy the project folder to your XAMPP `htdocs` directory.

```bash
C:\xampp\htdocs\edunexus\
```

3. Start **Apache** and **MySQL** from the XAMPP Control Panel.
4. Open **phpMyAdmin**.
5. Create a new database named:

```sql
edunexus_db
```

6. Import the provided SQL file into the database.
7. Open your browser and navigate to:

```bash
http://localhost/edunexus/
```

---

## Default Login Credentials

### Admin / Teacher

* **Email:** [admin@edunexus.com](mailto:admin@edunexus.com)
* **Password:** admin123

### Student

* **Email:** [student@edunexus.com](mailto:student@edunexus.com)
* **Password:** student123

---

## Project Structure

```text
edunexus/
├── README.md
├── database.sql
├── index.php
├── config/
│   └── db.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── sidebar.php
├── student/
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   ├── profile.php
│   ├── syllabus.php
│   ├── timetable.php
│   ├── examination.php
│   ├── fees.php
│   ├── notices.php
│   ├── events.php
│   └── direction.php
└── teacher/
    ├── login.php
    ├── dashboard.php
    ├── students.php
    ├── notices.php
    ├── events.php
    ├── timetable.php
    ├── exams.php
    └── fees.php
```

---

## Database Tables

* `students` – Stores student details and profiles
* `teachers` – Stores faculty and administrator records
* `notices` – College announcements and notices
* `events` – Event details and schedules
* `syllabus` – Course and subject syllabus information
* `timetable` – Weekly class schedules
* `examinations` – Examination timetables
* `fees` – Student fee records and payment details

---

## Key Highlights

* User-friendly interface
* Secure authentication system
* Responsive design
* Centralized data management
* Easy to maintain and customize
* Scalable architecture for future enhancements

---

## Future Enhancements

* Online Fee Payment Integration
* Attendance Management System
* Library Management Module
* Placement and Internship Portal
* Mobile Application Support
* Email and SMS Notifications
* Advanced Analytics Dashboard

---

## Security Features

* Password Encryption using `password_hash()`
* SQL Injection Prevention with Prepared Statements
* Session-based Authentication
* Input Validation and Sanitization

---

## Contributing

Contributions are welcome. Feel free to fork this repository and submit pull requests for improvements or new features.

---

## License

This project is developed for educational and academic purposes.

---

## Author

**Shruti Bedse**

---

## Acknowledgements

* Dr. Moonje Institute
* Faculty Mentors and Project Guides
* Open Source Community

---

**EduNexus – Empowering Smart Campus Management**
