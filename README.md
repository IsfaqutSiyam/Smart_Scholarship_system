# Scholarify

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License" />
</p>

<p align="center">
  <strong>Scholarify</strong> is a modern Laravel-based platform that helps Bangladeshi students discover Chinese universities, scholarships, and academic opportunities with confidence.
</p>

<p align="center">
  It combines a polished student experience, an admin dashboard, and an explainable recommendation engine to make university selection simpler, faster, and more transparent.
</p>

## Why Scholarify?

Scholarify addresses a real challenge for students planning to study abroad: finding the right university and scholarship match without overwhelming spreadsheets or scattered information.

### Highlights

- Browse universities across China with regional, city, and language-based filters
- Explore scholarships and eligibility criteria in a structured way
- Receive personalized recommendations based on academic profile and preferences
- Manage applications and track academic opportunities from one dashboard
- Support both student and admin roles through a clean, responsive interface

## Key Features

### Student Experience

- Personalized dashboard with recommendation insights
- Academic profile completion flow
- University and scholarship discovery pages
- Recommendation engine with score breakdowns
- Application tracking and saved opportunities

### Admin Experience

- Full university, program, and scholarship management
- Content control for visibility and data updates
- Dashboard view for key statistics and opportunities

## Tech Stack

| Layer | Technology |
|------|------------|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade Templates + Tailwind CSS |
| Database | MySQL / SQLite for local development |
| Authentication | Laravel session-based auth |
| Deployment | Ready for modern hosting platforms such as Render |

## Project Overview

Scholarify is built for students who want a smarter way to explore study-abroad options in China. Instead of manually comparing programs and scholarship requirements, the platform helps users understand which universities and scholarships best fit their profile.

## Demo Accounts

| Role | Email | Password |
|------|------|----------|
| Admin | admin@scholarify.bd | password |
| Student | student@scholarify.bd | password |

## Quick Start

```bash
git clone <your-repo-url>
cd scholarify
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

### Prerequisites

Make sure you have the following installed:

- PHP 8.2+
- Composer
- MySQL or SQLite
- A local web server such as XAMPP, Laragon, or Laravel's built-in server

### Installation

1. Clone the repository
   ```bash
   git clone <your-repo-url>
   cd scholarify
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Create your environment file
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database
   - For local development, SQLite is already supported through the project configuration.
   - If you prefer MySQL, update the database credentials in your .env file.

5. Run migrations and seed the database
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. Start the application
   ```bash
   php artisan serve
   ```

Then open your browser at:

```text
http://localhost:8000
```

## Recommendation Engine

The recommendation system evaluates each active academic program using a rule-based scoring model based on:

- Field-of-study match
- CGPA fit
- Language proficiency compatibility
- University ranking tier

Each recommendation includes a score and a breakdown so users can understand why a university or program was suggested.

## Project Structure

```text
scholarify/
├── app/
│   ├── Http/Controllers
│   ├── Models
│   └── Services
├── database/
│   ├── migrations
│   └── seeders
├── resources/views
├── routes
└── tests
```

## Deployment

Scholarify is ready to be deployed to a modern hosting platform such as Render, Railway, or a VPS.

For production deployments:

- Use a hosted database instead of local SQLite
- Set environment variables securely
- Run migrations and seed data after deployment

## Troubleshooting

If you see an error on first run:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

If Composer fails to autoload classes:

```bash
composer dump-autoload
```

## Contributing

Contributions are welcome.

If you would like to contribute:

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a pull request

## Acknowledgements

Built with Laravel, Tailwind CSS, and a focus on practical student support.

Developed as a software engineering project with a strong emphasis on usability, real-world problem solving, and scalable web application design.

---

<p align="center">
  Built with care for students exploring their next academic chapter.
</p>

Built with Laravel, Tailwind CSS, and a focus on practical student support.

Developed as a software engineering project with a strong emphasis on usability, real-world problem solving, and scalable web application design.

---

Built with care for students exploring their next academic chapter.
