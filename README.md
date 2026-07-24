# Portfolio Builder CMS

Enterprise-grade Dynamic Portfolio Builder CMS built with Laravel 12 and Bootstrap 5.3.

A complete platform that allows admins to create, manage, customize and control portfolio websites from a dashboard.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Bootstrap 5.3, Blade Templates, Alpine.js, Chart.js, AOS Animations
- **Database:** MySQL / SQLite
- **Auth:** Laravel Breeze
- **Permissions:** Spatie Permission
- **Media:** Spatie Media Library, Intervention Image

## Features

- Authentication (Login, Register, Password Reset, Email Verification)
- Admin Dashboard with stats and charts
- Profile Manager (name, bio, image, resume, social links)
- Skills Manager with categories and animated progress bars
- Experience Timeline CRUD
- Education Manager
- Projects Portfolio with categories, gallery, filters, search
- Services Module
- Testimonials with ratings
- Certifications Module
- Blog CMS (posts, categories, tags, SEO, rich editor)
- Contact Form with inbox and reply
- Newsletter with CSV export
- Media Library
- SEO Manager (meta tags, Open Graph, Twitter Cards)
- Analytics Dashboard (visitors, browsers, countries)
- Theme System with 8 switchable themes
- Theme Customizer (colors, fonts, layout)
- Page Builder (show/hide/reorder sections)
- Settings Manager (site info, social links, contact)
- Spatie Roles & Permissions (admin, editor)

## 8 Themes

| Theme | Style |
|-------|-------|
| Developer | Dark terminal-style, monospace, green accents |
| Modern | Clean white, gradient hero, smooth animations |
| Creative | Bold colorful, split-screen, vibrant gradients |
| Freelancer | Warm friendly, timeline, pricing cards, carousel |
| Agency | Professional blue/white, service cards, stat counters |
| Corporate | Conservative navy, structured, formal |
| Minimal | Ultra-clean B&W, whitespace-heavy, typography |
| Premium SaaS | Tech startup, gradients, glassmorphism |

## Installation

```bash
# Clone the repository
git clone <repo-url>
cd portfolio-builder

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate:fresh --seed

# Storage link
php artisan storage:link

# Build frontend assets
npm run build

# Start development server
php artisan serve
```

## Admin Login

| Field | Value |
|-------|-------|
| **URL** | `http://localhost:8000/admin` |
| **Email** | `admin@portfoliobuilder.com` |
| **Password** | `password` |

> After login, you will be redirected to the Admin Dashboard at `/admin`.

## Project Structure

```
portfolio-builder/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # 25 admin controllers
│   │   ├── Auth/            # Breeze auth controllers
│   │   └── Frontend/        # Public-facing controllers
│   ├── Models/              # 26 Eloquent models
│   ├── Providers/           # ThemeServiceProvider
│   └── Services/            # ThemeManager service
├── database/
│   ├── migrations/          # 28+ table migrations
│   └── seeders/             # Sample data seeders
├── resources/
│   └── views/
│       ├── admin/           # 40 admin Blade views
│       ├── auth/            # Breeze auth views
│       ├── frontend/        # Public page views
│       ├── layouts/         # Admin master layout
│       └── themes/          # 8 themes x 12 files
│           ├── developer/
│           ├── modern/
│           ├── creative/
│           ├── freelancer/
│           ├── agency/
│           ├── corporate/
│           ├── minimal/
│           └── premium-saas/
├── routes/
│   ├── web.php              # Frontend + auth routes
│   ├── admin.php            # All admin routes
│   └── auth.php             # Breeze auth routes
└── public/
    └── storage/             # Uploaded files (symlinked)
```

## Database Schema

28 tables covering: users, profiles, social_links, about_sections, skill_categories, skills, experiences, educations, project_categories, projects, project_images, services, testimonials, certifications, blog_categories, blog_tags, blog_posts, blog_post_tag, messages, newsletters, seo_settings, analytics, settings, themes, theme_customizations, page_sections, visitors, plus Spatie permission/media tables.

## Routes

- **Frontend:** Home, Blog, Blog Post, Project Detail, Contact, Newsletter Subscribe
- **Admin:** 120+ routes covering all CRUD modules
- **Auth:** Login, Register, Password Reset, Email Verification, Profile

## Performance & Security

- CSRF Protection (Laravel built-in)
- XSS Protection (Blade auto-escaping)
- SQL Injection Protection (Eloquent ORM)
- Spatie Roles & Permissions
- Lazy Loading on images
- Database query optimization
- Asset compilation via Vite
- Session-based authentication with encryption

## License

MIT License
