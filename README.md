# Portfolio Builder CMS

Enterprise-grade Dynamic Portfolio Builder CMS built with Laravel 12 and Bootstrap 5.3.

A complete platform that allows admins to create, manage, customize and control portfolio websites from a dashboard.

## Tech Stack

- **Backend:** Laravel 12.64, PHP 8.2.12
- **Frontend:** Bootstrap 5.3.3, Blade Templates, Alpine.js, Chart.js, AOS Animations
- **Build Tool:** Vite 7.3.6
- **CSS:** Tailwind CSS (Breeze auth views), Bootstrap 5.3.3 (admin panel)
- **Database:** MySQL / SQLite (for testing)
- **Auth:** Laravel Breeze
- **Permissions:** Spatie Permission 6.x
- **Media:** Spatie Media Library 11.x, Intervention Image 3.x

## Features

### Authentication & Authorization
- Login, Register, Password Reset, Email Verification
- Spatie Roles & Permissions (admin, editor)
- IDOR prevention via ownership checks on all controllers

### Admin Dashboard
- Stats overview with Chart.js visualizations
- Visitor analytics, browser stats, country breakdowns
- Real-time notification bell (unread messages)

### Content Management
- **Profile Manager** - name, bio, image, resume, social links
- **Skills Manager** - categories, animated progress bars, color coding
- **Experience Timeline** - CRUD with date ranges and technologies
- **Education Manager** - institutions, degrees, results
- **Projects Portfolio** - categories, gallery, filters, search, featured projects
- **Services Module** - icons, features lists
- **Testimonials** - client reviews with star ratings
- **Certifications** - organizations, dates, credential IDs, verification URLs

### Blog CMS
- Rich text editor for posts
- Categories and tags management
- SEO fields per post (meta title, description)
- Featured posts, reading time, view counts
- Published/draft status with scheduling

### Communication
- Contact form with inbox and message management
- Newsletter subscribers with CSV export
- CSV injection prevention on export

### SEO & Analytics
- SEO Manager (meta tags, Open Graph, Twitter Cards)
- Analytics dashboard with visitor tracking
- Browser and country breakdowns

### Theme System
- 8 switchable themes with live preview
- Theme Customizer (colors, fonts, layout settings)
- Page Builder for section ordering and visibility

### Media & Settings
- Media Library with upload, preview, delete
- Settings Manager (site info, social links, contact details)

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

# Configure .env for your database (MySQL)
# DB_DATABASE=portfolio_builder
# DB_USERNAME=root
# DB_PASSWORD=

# Database setup (creates tables + seeds demo data)
php artisan migrate:fresh --seed

# Storage symlink (for uploaded files)
php artisan storage:link

# Build frontend assets
npm run build

# Start development server
php artisan serve
```

## Demo Credentials

| Role | Email | Password | Access |
|------|-------|----------|--------|
| Admin | admin@portfolio.com | password | Full admin dashboard at `/admin` |
| Normal User | user@portfolio.com | password | Standard user access |

## Project Structure

```
portfolio-builder/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # 17+ admin controllers (extend AdminController)
│   │   │   ├── Auth/            # Breeze auth controllers
│   │   │   └── Frontend/        # Public-facing controllers
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Models/                  # 26 Eloquent models
│   ├── Providers/
│   │   └── ThemeServiceProvider.php
│   └── Services/
│       └── ThemeManager.php
├── database/
│   ├── migrations/              # 31 migration files
│   └── seeders/
│       ├── UserSeeder.php       # Creates demo admin + normal user
│       ├── RolePermissionSeeder.php
│       ├── ThemeSeeder.php
│       └── ProfileSeeder.php
├── resources/
│   └── views/
│       ├── admin/               # 40+ admin Blade views
│       ├── auth/                # Breeze auth views (Tailwind)
│       ├── frontend/            # Public page views
│       ├── layouts/
│       │   ├── app.blade.php    # Frontend layout
│       │   └── admin.blade.php  # Admin layout (Bootstrap 5)
│       └── themes/              # 8 themes x 12+ files each
│           ├── developer/
│           ├── modern/
│           ├── creative/
│           ├── freelancer/
│           ├── agency/
│           ├── corporate/
│           ├── minimal/
│           └── premium-saas/
├── routes/
│   ├── web.php                  # Frontend + auth routes
│   ├── admin.php                # All admin routes (120+)
│   └── auth.php                 # Breeze auth routes
├── tests/                       # 56 tests (PHPUnit 11)
│   ├── Feature/
│   │   ├── AdminAccessTest.php
│   │   ├── AdminCrudTest.php
│   │   ├── FrontendTest.php
│   │   ├── AuthenticationTest.php
│   │   └── Auth/                # Breeze auth tests
│   └── Unit/
└── public/
    └── build/                   # Vite compiled assets
```

## Database Schema

31 tables covering: users, profiles, social_links, about_sections, skill_categories, skills, experiences, educations, project_categories, projects, project_images, services, testimonials, certifications, blog_categories, blog_tags, blog_posts, blog_post_tag, messages, newsletters, seo_settings, analytics, settings, themes, theme_customizations, page_sections, visitors, plus Spatie permission/media/cache/job tables.

## Routes

- **Frontend (6):** Home, Blog Index, Blog Post, Project Detail, Contact Submit, Newsletter Subscribe
- **Admin (120+):** Full CRUD for all content modules, dashboard, analytics, settings, themes, page builder, media
- **Auth (8):** Login, Register, Password Reset/Confirm, Email Verification, Profile Edit/Update

## Testing

```bash
# Run all 56 tests
php artisan test

# Run specific test suite
php artisan test --filter=AdminCrudTest
php artisan test --filter=FrontendTest
```

## Security Features

- CSRF Protection (Laravel middleware)
- XSS Protection (Blade auto-escaping)
- SQL Injection Protection (Eloquent ORM)
- IDOR Prevention (ownership checks via `authorizeOwnership()`)
- Spatie Roles & Permissions (admin access gate)
- CSV Injection Prevention (sanitized export)
- Path Traversal Protection (validated file paths)
- Secure Password Hashing (bcrypt)
- Session-based Authentication with Encryption

## License

MIT License
