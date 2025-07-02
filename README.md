# ToDoinAja

A personal productivity system built with Laravel and Bootstrap 5. Features:
- PIN-based authentication (email + 4-digit PIN)
- User-specific activity management (private data per user)
- Activity CRUD (create, read, update, delete)
- Time tracking for activities
- Activity logging
- Category management with color coding
- Standard to-do list features
- **Automatic deadline reminders via email**
- Modern Jira-inspired UI design
- SweetAlert2 integration for enhanced user experience

## Key Features

### 🔐 Secure Authentication
- PIN-based login system (no passwords required)
- Email verification and unique email enforcement
- 4-digit PIN generation and secure hashing
- Automatic PIN resend functionality

### 📧 Smart Email Reminders
- **3-day advance notice**: Get reminded 3 days before your task deadline
- **30-minute urgent alerts**: Last-minute reminders when deadlines approach
- Professional HTML email templates
- Duplicate reminder prevention
- Works automatically in the background

### 🎯 Task Management
- Create, edit, and organize tasks with deadlines
- Color-coded categories for better organization
- Quick category assignment
- Task status tracking (To-Do, In Progress, Completed)
- Visual deadline indicators (overdue, urgent, upcoming)
- Expandable task details with descriptions and links
- Time tracking for productivity analysis

### 🎨 Modern Interface
- Jira-inspired responsive design
- Bootstrap 5 styling
- Intuitive user experience
- Mobile-friendly layout

## Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL database
- Mail server configuration (for email reminders)

### Installation Steps
1. **Database Setup**: Copy `.env.example` to `.env` and configure your database settings:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todoinaja
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

2. **Email Configuration**: Set up your email settings for deadline reminders:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your_email@gmail.com
   MAIL_PASSWORD=your_app_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_email@gmail.com
   MAIL_FROM_NAME="ToDoinAja"
   ```

3. **Install Dependencies**: Run `composer install` to install Laravel dependencies.

4. **Generate App Key**: Run `php artisan key:generate` to set the application key.

5. **Run Migrations**: Run `php artisan migrate` to create all database tables.

6. **Start the Scheduler**: For automatic deadline reminders, run:
   ```bash
   php artisan schedule:work
   ```
   Or set up a cron job to run `php artisan schedule:run` every minute.

7. **Serve the Application**: Start the development server with `php artisan serve`.

## Usage

### Getting Started
1. **Registration**: Enter your email to create an account - a 4-digit PIN will be sent to your email
2. **Login**: Use your email and the received PIN to access your dashboard
3. **Create Tasks**: Add tasks with titles, descriptions, deadlines, and categories
4. **Stay Organized**: Tasks are automatically organized by deadline status with visual indicators

### Deadline Reminders
The system automatically sends email reminders:
- **3 days before deadline**: Advance warning to help you plan
- **30 minutes before deadline**: Urgent final reminder

To test the reminder system:
```bash
# Create test tasks
php artisan test:create-deadline-task --type=3days
php artisan test:create-deadline-task --type=30minutes

# Manually trigger reminder check
php artisan reminders:send-deadline-reminders
```

### Commands
- `php artisan reminders:send-deadline-reminders` - Send deadline reminders
- `php artisan test:create-deadline-task` - Create test tasks for testing reminders
- `php artisan schedule:work` - Run the task scheduler

---
This project is for personal use and does not require email/password authentication.

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
