# TutorLink

TutorLink is a full-stack tutoring management system built with PHP, MySQL, HTML, CSS, and JavaScript. It was designed to manage students, tutors, lessons, locations, and course specializations in a university-style tutoring environment.

## Features

- Student registration, editing, viewing, and deletion
- Two-step tutor registration for UTD and external tutors
- Tutor-course specialization management through a many-to-many relationship
- Dynamic lesson booking by course or custom topic
- Tutor filtering based on selected course specialization
- Availability engine with clickable time-slot generation
- Duration-aware scheduling
- Tutor conflict detection
- Room conflict detection during rescheduling
- Lesson status updates for cancellation and no-show
- Dashboard views for students, tutors, and lessons
- Search and filtering for large course catalogs

## Tech Stack

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- MAMP
- Git / GitHub

## Highlights

### Dynamic scheduling engine
TutorLink generates available lesson times based on:
- tutor
- date
- room
- duration

It excludes overlapping lessons using interval-based conflict logic and returns available slots as JSON for frontend rendering.

### Tutor specialization filtering
The system uses a junction table to model tutor-course relationships. When a course is selected during lesson booking, only tutors qualified for that course remain available in the UI.

### Dual-list course management
Tutor specializations can be edited through a dual-list interface that allows courses to be added or removed cleanly.

## Project Structure

```text
TUTORLINK/
├── Dashboard.php
├── CSS/
├── Students/
├── Tutors/
├── Lessons/
└── PHP/
```

Example Workflows

Add a tutor

1. Complete tutor registration step 1
2. Route to UTD or External step 2
3. Search/filter courses
4. Assign course specializations
5. Save tutor

Book a lesson

1. Select student, tutor, and location
2. Choose a course or enter a topic
3. Pick a date
4. Check availability
5. Select a generated time slot
6. Submit lesson

Edit a tutor

1. Open tutor editor
2. Update tutor info
3. Add or remove courses using the dual-list interface
4. Save changes

Database Design

Core tables include:

* Students
* Tutors
* Lessons
* Courses
* Locations
* TutorCourses

The TutorCourses table handles the many-to-many relationship between tutors and courses.

What This Project Demonstrates

* Full-stack CRUD development
* Relational database design
* Many-to-many data modeling
* Validation and conflict enforcement
* Dynamic frontend/backend interaction
* Workflow-based system design
* Maintainable code organization

Running Locally

1. Clone the repository
2. Import the TutorLink database into MySQL
3. Update PHP/db.php to match your local configuration
4. Start Apache and MySQL
5. Open the project through your local server

Future Improvements

* Prepared statements for all SQL queries
* Auth and role-based access control
* Better room-hours parsing from database strings
* Calendar-style scheduling UI
* Analytics and reporting

Author

Devaansh Singhal
