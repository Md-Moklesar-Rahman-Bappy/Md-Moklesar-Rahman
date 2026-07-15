# Md Moklesar Rahman — Portfolio

A modern, dynamic portfolio web application built with React, TypeScript, Vite, and Tailwind CSS. Uses a file-based CMS — all content is stored in JSON files and committed to GitHub via the admin dashboard.

**Git Live:** [md-moklesar-rahman-bappy.github.io](https://md-moklesar-rahman-bappy.github.io/Md-Moklesar-Rahman/)

**Netlify:** [md-moklesar-rahman-bappy.github.io](https://moklesarrahman.netlify.app/)

## Tech Stack

- **Frontend:** React 19 + TypeScript + Vite
- **Styling:** Tailwind CSS 3 with dark/light mode
- **UI:** Framer Motion, Lucide React
- **CMS:** File-based (JSON files in `src/data/`) with GitHub API persistence
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
- Contact message inbox with read/unread status
- All changes committed to GitHub via the admin dashboard
- SEO-friendly metadata

## Folder Structure

```
src/
  components/
    layout/      # Navbar, Footer
    sections/    # HeroSection, AboutSection, SkillsSection, ServicesSection, ProjectsSection, ExperienceSection, EducationSection, ContactSection
    ui/          # ThemeToggle, SectionWrapper, LoadingState
  pages/         # Home, AdminLogin, AdminDashboard
  data/          # JSON files — all portfolio content (the "database")
  hooks/         # useTheme, usePortfolioData
  lib/           # data-utils, fallback data, validations (Zod schemas)
  services/      # portfolioService, githubService
  types/         # TypeScript interfaces
  styles/        # globals.css (Tailwind directives + custom styles)
```

## How It Works

All portfolio content lives in `src/data/` as JSON files:
- `site-settings.json`, `hero.json`, `about.json` — single objects
- `skills.json`, `projects.json`, `experience.json`, `education.json`, `services.json`, `social-links.json`, `certifications.json` — arrays
- `messages.json` — contact form submissions

The public site reads these files via static imports (bundled at build time, no database needed).

The admin dashboard (`/admin`) lets you edit all content. When you save changes, they are committed to your GitHub repository via the GitHub API. Pushing to `main` triggers a Netlify auto-redeploy.

## Environment Variables

Copy `.env.example` to `.env`:

```
VITE_ADMIN_PASSWORD=admin123
VITE_GITHUB_TOKEN=your_github_token
VITE_GITHUB_OWNER=your_github_username
VITE_GITHUB_REPO=your_repo_name
```

- `VITE_ADMIN_PASSWORD` — Password to access the admin dashboard
- `VITE_GITHUB_TOKEN` — GitHub personal access token with `repo` scope (create at https://github.com/settings/tokens)
- `VITE_GITHUB_OWNER` — Your GitHub username or organization
- `VITE_GITHUB_REPO` — Your repository name (e.g. `Md-Moklesar-Rahman`)

## Local Development

```bash
npm install
npm run dev
```

Open [http://localhost:5173](http://localhost:5173)

**Note:** The admin dashboard works locally, but changes are only saved in-memory if GitHub is not configured. Set the env vars above to persist changes via GitHub commits.

## Build

```bash
npm run build
```

Output goes to `dist/`.

## Netlify Deployment

1. Push code to GitHub
2. In Netlify: **Add new site** → **Import from Git**
3. Connect your GitHub repo
4. Under **Site Settings** → **Environment Variables**, add:
   - `VITE_ADMIN_PASSWORD`
   - `VITE_GITHUB_TOKEN`
   - `VITE_GITHUB_OWNER`
   - `VITE_GITHUB_REPO`
5. Deploy settings are auto-configured via `netlify.toml`:
   - Build command: `npm run build`
   - Publish directory: `dist`
   - SPA redirect: `/*` → `/index.html` (200)
6. Deploy
7. Test public site and `/admin` dashboard

## Admin Dashboard

- **URL:** `https://your-site.netlify.app/admin`
- Login with the admin password you configured
- Manage all portfolio content from the sidebar (Skills, Projects, Experience, Education, Services, Social Links, Certifications)
- View and manage contact messages
- Edit Hero, About, and Site Settings inline
- Changes are committed to GitHub automatically when saved

## Updating Content

**Option 1 — Admin Dashboard (recommended):**
1. Go to `/admin` and log in
2. Edit content in the dashboard
3. Changes are committed to GitHub immediately

**Option 2 — Direct file editing:**
1. Edit the JSON files in `src/data/`
2. Commit and push to GitHub
3. Netlify auto-redeploys

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Blank page on Netlify | Verify `netlify.toml` redirect rule exists |
| Login fails | Wrong `VITE_ADMIN_PASSWORD` — check your env vars |
| Git commits fail | Verify `VITE_GITHUB_TOKEN` has `repo` scope |
| Build fails | Run `npm install` and check Node >= 18 |

## License

GNU General Public License v3
