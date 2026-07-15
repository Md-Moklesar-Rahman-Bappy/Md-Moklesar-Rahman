-- ============================================
-- ROW LEVEL SECURITY POLICIES
-- Run after schema.sql and seed.sql
-- ============================================

-- Enable RLS on all tables
alter table site_settings enable row level security;
alter table hero enable row level security;
alter table about enable row level security;
alter table skills enable row level security;
alter table projects enable row level security;
alter table experience enable row level security;
alter table education enable row level security;
alter table services enable row level security;
alter table certifications enable row level security;
alter table social_links enable row level security;
alter table contact_messages enable row level security;
alter table media_assets enable row level security;

-- ============================================
-- HELPER: Check if user is admin
-- ============================================
-- This function checks if the current user's email is in the admin list
create or replace function is_admin()
returns boolean as $$
begin
  return exists (
    select 1 from auth.users
    where id = auth.uid()
    and email in (
      select email from admin_users
    )
  );
end;
$$ language plpgsql security definer;

-- Admin users table (simple allowlist)
create table if not exists admin_users (
  id uuid primary key default uuid_generate_v4(),
  email text unique not null,
  created_at timestamptz default now()
);

-- ============================================
-- PUBLIC READ POLICIES (anyone can read visible/published data)
-- ============================================

-- Site Settings: public read
create policy "Public can read site_settings"
  on site_settings for select
  using (true);

-- Hero: public read active hero
create policy "Public can read active hero"
  on hero for select
  using (is_active = true);

-- About: public read
create policy "Public can read about"
  on about for select
  using (true);

-- Skills: public read visible
create policy "Public can read visible skills"
  on skills for select
  using (is_visible = true);

-- Projects: public read visible
create policy "Public can read visible projects"
  on projects for select
  using (is_visible = true);

-- Experience: public read visible
create policy "Public can read visible experience"
  on experience for select
  using (is_visible = true);

-- Education: public read visible
create policy "Public can read visible education"
  on education for select
  using (is_visible = true);

-- Services: public read visible
create policy "Public can read visible services"
  on services for select
  using (is_visible = true);

-- Certifications: public read visible
create policy "Public can read visible certifications"
  on certifications for select
  using (is_visible = true);

-- Social Links: public read visible
create policy "Public can read visible social_links"
  on social_links for select
  using (is_visible = true);

-- Contact Messages: public can insert (contact form)
create policy "Anyone can submit contact messages"
  on contact_messages for insert
  with check (true);

-- ============================================
-- ADMIN POLICIES (full CRUD for authenticated admins)
-- ============================================

-- Site Settings: admin full access
create policy "Admin full access site_settings"
  on site_settings for all
  using (is_admin());

-- Hero: admin full access
create policy "Admin full access hero"
  on hero for all
  using (is_admin());

-- About: admin full access
create policy "Admin full access about"
  on about for all
  using (is_admin());

-- Skills: admin full access
create policy "Admin full access skills"
  on skills for all
  using (is_admin());

-- Projects: admin full access
create policy "Admin full access projects"
  on projects for all
  using (is_admin());

-- Experience: admin full access
create policy "Admin full access experience"
  on experience for all
  using (is_admin());

-- Education: admin full access
create policy "Admin full access education"
  on education for all
  using (is_admin());

-- Services: admin full access
create policy "Admin full access services"
  on services for all
  using (is_admin());

-- Certifications: admin full access
create policy "Admin full access certifications"
  on certifications for all
  using (is_admin());

-- Social Links: admin full access
create policy "Admin full access social_links"
  on social_links for all
  using (is_admin());

-- Contact Messages: admin full access
create policy "Admin full access contact_messages"
  on contact_messages for all
  using (is_admin());

-- Media Assets: admin full access, public read
create policy "Public can read media_assets"
  on media_assets for select
  using (true);

create policy "Admin full access media_assets"
  on media_assets for all
  using (is_admin());

-- ============================================
-- ADMIN READ-ALL POLICIES (admin can see all items regardless of visibility)
-- ============================================
-- Note: The admin "all" policies above already override the public select policies
-- When is_admin() returns true, the admin can see everything.

-- ============================================
-- STORAGE BUCKET POLICIES
-- ============================================
-- Run these after creating the 'portfolio-media' bucket in Supabase Dashboard

-- Public read access for storage objects
-- (Set this in Supabase Dashboard > Storage > portfolio-media > Policies)
-- Or run:
-- insert into storage.buckets (id, name, public) values ('portfolio-media', 'portfolio-media', true);

-- Create policy: authenticated users can upload
-- create policy "Admin can upload" on storage.objects
--   for insert with check (bucket_id = 'portfolio-media' and auth.role() = 'authenticated');

-- Create policy: authenticated users can update
-- create policy "Admin can update" on storage.objects
--   for update using (bucket_id = 'portfolio-media' and auth.role() = 'authenticated');

-- Create policy: authenticated users can delete
-- create policy "Admin can delete" on storage.objects
--   for delete using (bucket_id = 'portfolio-media' and auth.role() = 'authenticated');
