# TutorLink

TutorLink is a full-stack tutoring management system designed to manage students, tutors, lessons, locations, and course specializations in a university-style tutoring environment. It was built with PHP, MySQL, HTML, CSS, and JavaScript.

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

- PHP (version 8.3.30)
- MySQL (version 8.0.44)
- HTML
- CSS
- JavaScript
- MAMP (version 7.4)
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

## Example Workflows

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

## Database Design

Core tables include:

* Students
* Tutors
* Lessons
* Courses
* Locations
* TutorCourses

The TutorCourses table handles the many-to-many relationship between tutors and courses.

## What This Project Demonstrates

* Full-stack CRUD development
* Relational database design
* Many-to-many data modeling
* Validation and conflict enforcement
* Dynamic frontend/backend interaction
* Workflow-based system design
* Maintainable code organization

## Running Locally

1. Clone or download this repository into your web server directory.  
   Example with MAMP on macOS: place the project inside `htdocs`, such as  
   `.../MAMP/htdocs/TUTORLINK/`

2. Import the TutorLink database into MySQL using a tool such as phpMyAdmin.

3. Open `PHP/db.php` and update the database connection settings so they match your machine:
   - host
   - username
   - password
   - database name
   - port

4. Start Apache and MySQL.  
   I used **MAMP** for local development.
   In the MAMP app dashboard, set the web server to Apache, and the PHP version (e.g., 8.3.30, or later versions if you pay for **MAMP PRO**).
   Then click on the Start button and proceed to Step 5.

5. Open the project in your browser through Apache, not by opening the files directly.  
   Example:
   ```text
   http://localhost:8888/TUTORLINK/Dashboard.php
   ```
   or whatever local URL matches your setup.
   
6. If everything is configured correctly, the TutorLink dashboard should load, and the system will be ready to use.

## Future Improvements

* Prepared statements for all SQL queries
* Auth and role-based access control
* Better room-hours parsing from database strings
* Calendar-style scheduling UI
* Analytics and reporting

```markdown
## Author

**Devaansh Singhal**
```
