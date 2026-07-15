-- ============================================
-- PORTFOLIO DATABASE SCHEMA
-- Run this in Supabase SQL Editor
-- ============================================

-- Enable UUID extension
create extension if not exists "uuid-ossp";

-- ============================================
-- 1. SITE SETTINGS
-- ============================================
create table if not exists site_settings (
  id uuid primary key default uuid_generate_v4(),
  site_name text not null default 'Md Moklesar Rahman',
  owner_name text not null default 'Md Moklesar Rahman',
  tagline text default 'Web Designer & Developer',
  logo_url text,
  resume_url text,
  primary_email text,
  phone text,
  location text,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- ============================================
-- 2. HERO
-- ============================================
create table if not exists hero (
  id uuid primary key default uuid_generate_v4(),
  title text not null default 'Md Moklesar Rahman',
  subtitle text default 'Web Designer & Developer',
  description text,
  profile_image_url text,
  background_image_url text,
  cta_primary_label text default 'Hire Me',
  cta_primary_url text default '#contact',
  cta_secondary_label text default 'Download CV',
  cta_secondary_url text,
  is_active boolean default true,
  updated_at timestamptz default now()
);

-- ============================================
-- 3. ABOUT
-- ============================================
create table if not exists about (
  id uuid primary key default uuid_generate_v4(),
  heading text default 'About Me',
  content text,
  image_url text,
  years_experience integer default 0,
  updated_at timestamptz default now()
);

-- ============================================
-- 4. SKILLS
-- ============================================
create table if not exists skills (
  id uuid primary key default uuid_generate_v4(),
  name text not null,
  category text default 'general',
  level integer default 0 check (level >= 0 and level <= 100),
  icon_url text,
  sort_order integer default 0,
  is_visible boolean default true,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- ============================================
-- 5. PROJECTS
-- ============================================
create table if not exists projects (
  id uuid primary key default uuid_generate_v4(),
  title text not null,
  slug text unique not null,
  short_description text,
  description text,
  image_url text,
  gallery_urls text[] default '{}',
  tech_stack text[] default '{}',
  live_url text,
  github_url text,
  category text default 'web-development',
  featured boolean default false,
  is_visible boolean default true,
  sort_order integer default 0,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- ============================================
-- 6. EXPERIENCE
-- ============================================
create table if not exists experience (
  id uuid primary key default uuid_generate_v4(),
  company text not null,
  position text not null,
  start_date date,
  end_date date,
  is_current boolean default false,
  description text,
  location text,
  sort_order integer default 0,
  is_visible boolean default true,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- ============================================
-- 7. EDUCATION
-- ============================================
create table if not exists education (
  id uuid primary key default uuid_generate_v4(),
  institution text not null,
  degree text not null,
  field text,
  start_year integer,
  end_year integer,
  description text,
  sort_order integer default 0,
  is_visible boolean default true,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- ============================================
-- 8. SERVICES
-- ============================================
create table if not exists services (
  id uuid primary key default uuid_generate_v4(),
  title text not null,
  description text,
  icon text default 'briefcase',
  sort_order integer default 0,
  is_visible boolean default true,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- ============================================
-- 9. CERTIFICATIONS
-- ============================================
create table if not exists certifications (
  id uuid primary key default uuid_generate_v4(),
  title text not null,
  issuer text,
  issue_date date,
  credential_url text,
  image_url text,
  sort_order integer default 0,
  is_visible boolean default true,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- ============================================
-- 10. SOCIAL LINKS
-- ============================================
create table if not exists social_links (
  id uuid primary key default uuid_generate_v4(),
  platform text not null,
  url text not null,
  icon text default 'link',
  sort_order integer default 0,
  is_visible boolean default true,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- ============================================
-- 11. CONTACT MESSAGES
-- ============================================
create table if not exists contact_messages (
  id uuid primary key default uuid_generate_v4(),
  name text not null,
  email text not null,
  subject text,
  message text not null,
  is_read boolean default false,
  created_at timestamptz default now()
);

-- ============================================
-- 12. MEDIA ASSETS
-- ============================================
create table if not exists media_assets (
  id uuid primary key default uuid_generate_v4(),
  file_name text not null,
  file_url text not null,
  file_type text,
  file_size bigint,
  alt_text text,
  bucket text default 'portfolio-media',
  created_at timestamptz default now()
);

-- ============================================
-- INDEXES
-- ============================================
create index if not exists idx_skills_sort on skills(sort_order);
create index if not exists idx_skills_visible on skills(is_visible);
create index if not exists idx_projects_slug on projects(slug);
create index if not exists idx_projects_sort on projects(sort_order);
create index if not exists idx_projects_featured on projects(featured);
create index if not exists idx_projects_visible on projects(is_visible);
create index if not exists idx_projects_category on projects(category);
create index if not exists idx_experience_sort on experience(sort_order);
create index if not exists idx_education_sort on education(sort_order);
create index if not exists idx_services_sort on services(sort_order);
create index if not exists idx_certifications_sort on certifications(sort_order);
create index if not exists idx_social_links_sort on social_links(sort_order);
create index if not exists idx_contact_messages_read on contact_messages(is_read);
create index if not exists idx_contact_messages_created on contact_messages(created_at desc);

-- ============================================
-- UPDATED_AT TRIGGER FUNCTION
-- ============================================
create or replace function update_updated_at_column()
returns trigger as $$
begin
  new.updated_at = now();
  return new;
end;
$$ language plpgsql;

-- Apply trigger to all tables with updated_at
create trigger update_site_settings_updated_at before update on site_settings
  for each row execute function update_updated_at_column();
create trigger update_hero_updated_at before update on hero
  for each row execute function update_updated_at_column();
create trigger update_about_updated_at before update on about
  for each row execute function update_updated_at_column();
create trigger update_skills_updated_at before update on skills
  for each row execute function update_updated_at_column();
create trigger update_projects_updated_at before update on projects
  for each row execute function update_updated_at_column();
create trigger update_experience_updated_at before update on experience
  for each row execute function update_updated_at_column();
create trigger update_education_updated_at before update on education
  for each row execute function update_updated_at_column();
create trigger update_services_updated_at before update on services
  for each row execute function update_updated_at_column();
create trigger update_certifications_updated_at before update on certifications
  for each row execute function update_updated_at_column();
create trigger update_social_links_updated_at before update on social_links
  for each row execute function update_updated_at_column();
