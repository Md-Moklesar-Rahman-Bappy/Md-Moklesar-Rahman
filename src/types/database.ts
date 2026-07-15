export interface SiteSettings {
  id: string;
  site_name: string;
  owner_name: string;
  tagline: string;
  logo_url: string | null;
  resume_url: string | null;
  primary_email: string | null;
  phone: string | null;
  location: string | null;
  created_at: string;
  updated_at: string;
}

export interface Hero {
  id: string;
  title: string;
  subtitle: string;
  description: string | null;
  profile_image_url: string | null;
  background_image_url: string | null;
  cta_primary_label: string;
  cta_primary_url: string;
  cta_secondary_label: string;
  cta_secondary_url: string;
  is_active: boolean;
  updated_at: string;
}

export interface About {
  id: string;
  heading: string;
  content: string | null;
  image_url: string | null;
  years_experience: number;
  updated_at: string;
}

export interface Skill {
  id: string;
  name: string;
  category: string;
  level: number;
  icon: string | null;
  icon_url: string | null;
  sort_order: number;
  is_visible: boolean;
  created_at: string;
  updated_at: string;
}

export interface Project {
  id: string;
  title: string;
  slug: string;
  short_description: string | null;
  description: string | null;
  image_url: string | null;
  gallery_urls: string[];
  tech_stack: string[];
  live_url: string | null;
  github_url: string | null;
  category: string;
  featured: boolean;
  is_visible: boolean;
  sort_order: number;
  created_at: string;
  updated_at: string;
}

export interface Experience {
  id: string;
  company: string;
  position: string;
  start_date: string | null;
  end_date: string | null;
  is_current: boolean;
  description: string | null;
  location: string | null;
  sort_order: number;
  is_visible: boolean;
  created_at: string;
  updated_at: string;
}

export interface Education {
  id: string;
  institution: string;
  degree: string;
  field: string | null;
  start_year: number | null;
  end_year: number | null;
  description: string | null;
  sort_order: number;
  is_visible: boolean;
  created_at: string;
  updated_at: string;
}

export interface Service {
  id: string;
  title: string;
  description: string | null;
  icon: string;
  category: string | null;
  sort_order: number;
  is_visible: boolean;
  created_at: string;
  updated_at: string;
}

export interface Certification {
  id: string;
  title: string;
  issuer: string | null;
  issue_date: string | null;
  credential_url: string | null;
  image_url: string | null;
  category: string | null;
  sort_order: number;
  is_visible: boolean;
  created_at: string;
  updated_at: string;
}

export interface SocialLink {
  id: string;
  platform: string;
  url: string;
  icon: string;
  sort_order: number;
  is_visible: boolean;
  created_at: string;
  updated_at: string;
}

export interface ContactMessage {
  id: string;
  name: string;
  email: string;
  subject: string | null;
  message: string;
  is_read: boolean;
  created_at: string;
}

export interface MediaAsset {
  id: string;
  file_name: string;
  file_url: string;
  file_type: string | null;
  file_size: number | null;
  alt_text: string | null;
  bucket: string;
  created_at: string;
}

export interface AdminUser {
  id: string;
  email: string;
  created_at: string;
}
