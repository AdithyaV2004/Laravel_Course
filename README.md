# CourseHub

CourseHub is a Laravel-based online learning platform that connects teachers and students. Teachers can publish courses and upload learning materials, while students can browse, purchase, and access courses through a single web application.

## Features

### Students

- Register and log in as a student
- Browse and search available courses
- Purchase courses using the demo purchase flow
- View purchased courses in **My Learning**
- Download materials for courses they can access
- Ask questions and reply in the course forum

### Teachers

- Register and log in as a teacher
- Create and publish courses
- Set course prices and descriptions
- Upload private course materials
- View enrolled students and course earnings
- Participate in course discussions

### Platform

- Role-based access for students and teachers
- Authentication, validation, and CSRF protection
- SQLite database configuration for local development
- Protected course-file downloads
- Course enrollment tracking
- One-level forum replies

## Technology Stack

- PHP 8.3+
- Laravel 13
- SQLite
- Blade templates
- Vite
- Tailwind CSS

## Requirements

Before installing the project, make sure the following are available:

- PHP 8.3 or later
- Composer
- Node.js and npm
- PHP SQLite extension

## Installation

1. Clone the repository and enter the project directory:

   ```bash
   git clone <repository-url>
   cd coursehub
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create the environment file:

   ```bash
   cp .env.example .env
   ```

   On Windows PowerShell, use:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Ensure SQLite is selected in `.env`:

   ```dotenv
   DB_CONNECTION=sqlite
   ```

   Create `database/database.sqlite` if it does not already exist.

6. Run the database migrations:

   ```bash
   php artisan migrate
   ```

7. Install frontend dependencies and build the assets:

   ```bash
   npm install
   npm run build
   ```

## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in a browser.

For frontend development with Vite, run the following in a separate terminal:

```bash
npm run dev
```

The project also provides a combined development command:

```bash
composer run dev
```

## Basic Usage

1. Register an account and choose either **Student** or **Teacher**.
2. As a teacher, open the teacher dashboard and create a course.
3. As a student, browse the course catalogue and open a course.
4. Complete the demo purchase flow to access the course material.
5. Use the course forum to ask questions or reply to existing discussions.

## Project Structure

```text
app/
├── Http/Controllers/       Application controllers
└── Models/                 User, Course, and Comment models
database/
└── migrations/             Database schema and relationships
resources/
└── views/                  Blade pages and layouts
routes/
└── web.php                 Web routes
storage/
└── app/                    Private uploaded course files
```

## Database Design

The main tables are:

- `users` - user accounts and roles
- `courses` - course details, pricing, and file metadata
- `purchases` - student-course enrollments and paid prices
- `comments` - course discussions and replies

## Testing

Run the application test suite with:

```bash
php artisan test
```

## Current Limitations

- Purchases are simulated; no real payment gateway is connected.
- The project does not currently include quizzes, certificates, or course progress tracking.
- There is no separate administrator dashboard.
- Course search currently searches course titles.

## Future Enhancements

- Integrate Stripe or Razorpay
- Add quizzes, assignments, and certificates
- Add video lessons and progress tracking
- Add ratings and reviews
- Add administrator controls
- Add email notifications

## License

This project is based on the Laravel framework and is intended for educational and demonstration purposes.