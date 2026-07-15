# Md Moklesar Rahman — Portfolio

A modern, dynamic portfolio web application built with React, TypeScript, Vite, Tailwind CSS, and Supabase.

**Live Site:** [md-moklesar-rahman-bappy.github.io](https://md-moklesar-rahman-bappy.github.io/Md-Moklesar-Rahman/)

## Tech Stack

- **Frontend:** React 19 + TypeScript + Vite
- **Styling:** Tailwind CSS 3 with dark/light mode
- **UI:** Framer Motion, Lucide React
- **Backend/Database:** Supabase (PostgreSQL + Auth + Storage)
- **Validation:** Zod
- **Hosting:** Netlify-ready

## Features

- Modern responsive public portfolio with dark/light theme toggle
- Hero section with typing animation
- Dynamic sections: About, Skills, Services, Projects, Experience, Education, Contact
- Project detail modal with category filtering
- Contact form with validation and honeypot spam protection
- Secure admin dashboard at `/admin`
- Full CRUD management for all portfolio content
- Media upload and management (Supabase Storage)
- Contact message inbox with read/unread status
- Supabase Row-Level Security (RLS)
- SEO-friendly metadata

## Folder Structure

```
src/
  components/
    layout/      # Navbar, Footer
    sections/    # HeroSection, AboutSection, SkillsSection, ServicesSection, ProjectsSection, ExperienceSection, EducationSection, ContactSection
    ui/          # ThemeToggle, SectionWrapper, LoadingState
  pages/         # Home, AdminLogin, AdminDashboard
  hooks/         # useTheme
  lib/           # supabase client, utils, validations (Zod schemas), fallback data
  services/      # portfolioService (all API calls to Supabase)
  types/         # TypeScript interfaces for all database tables
  styles/        # globals.css (Tailwind directives + custom styles)
supabase/
  schema.sql     # Full database schema (12 tables, indexes, triggers)
  seed.sql       # Seed data extracted from existing website
  policies.sql   # RLS policies + admin_users table
```

## Supabase Setup

1. Create a new Supabase project at [supabase.com](https://supabase.com)
2. Go to **SQL Editor** and run these files in order:
   - `supabase/schema.sql` — creates all tables, indexes, triggers
   - `supabase/seed.sql` — populates your existing portfolio data
   - `supabase/policies.sql` — enables RLS, creates admin_users table
3. Go to **Authentication** → **Users** → **Add User** (your admin email/password)
4. Insert your email into the `admin_users` table:
   ```sql
   INSERT INTO admin_users (email) VALUES ('your-email@example.com');
   ```
5. Go to **Storage** → **New bucket** → name: `portfolio-media`, public: enabled
6. Get your **Project URL** and **anon key** from **Settings** → **API**

## Environment Variables

Copy `.env.example` to `.env`:

```
VITE_SUPABASE_URL=your_supabase_project_url
VITE_SUPABASE_ANON_KEY=your_supabase_anon_key
```

## Local Development

```bash
npm install
npm run dev
```

Open [http://localhost:5173](http://localhost:5173)

## Build

```bash
npm run build
```

Output goes to `dist/`.

## Netlify Deployment

1. Push code to GitHub
2. Create Supabase project and run SQL schemas + seed data
3. In Netlify: **Add new site** → **Import from Git**
4. Connect your GitHub repo
5. Under **Site Settings** → **Environment Variables**, add:
   - `VITE_SUPABASE_URL`
   - `VITE_SUPABASE_ANON_KEY`
6. Deploy settings are auto-configured via `netlify.toml`:
   - Build command: `npm run build`
   - Publish directory: `dist`
   - SPA redirect: `/*` → `/index.html` (200)
7. Deploy
8. Test public site and `/admin` dashboard

## Admin Dashboard

- **URL:** `https://your-site.netlify.app/admin`
- Login with the Supabase Auth credentials you created
- Manage all portfolio content from the sidebar (Skills, Projects, Experience, Education, Services, Social Links, Certifications, Media)
- View and manage contact messages
- Edit Hero, About, and Site Settings inline

## Manual Steps After Deployment

1. Upload profile/about images via **Media** section in admin
2. Update image URLs in Hero and About sections (use admin UI)
3. Replace placeholder project descriptions with real content
4. Add your resume PDF to `public/files/` and update URL in Settings

## Admin Users

Add admin emails to the `admin_users` table:

```sql
INSERT INTO admin_users (email) VALUES ('your-admin-email@example.com');
```

Only users with matching emails in this table can perform write operations (RLS enforced).

## Troubleshooting

| Problem | Solution |
|---|---|
| Blank page on Netlify | Verify `netlify.toml` redirect rule exists |
| Login fails | Check Supabase Auth is enabled and user exists in Auth → Users |
| "No data" shown | RLS may be blocking reads; check policies or set bucket/public to public |
| Images not loading | Verify storage bucket `portfolio-media` is public |
| Build fails | Run `npm install` and check Node >= 18 |

## License

GNU General Public License v3
