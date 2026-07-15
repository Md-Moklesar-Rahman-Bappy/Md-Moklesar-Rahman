import { z } from "zod";

export const contactFormSchema = z.object({
  name: z.string().min(2, "Name must be at least 2 characters").max(100),
  email: z.string().email("Please enter a valid email address"),
  subject: z.string().min(1, "Subject is required").max(200),
  message: z.string().min(10, "Message must be at least 10 characters").max(5000),
  website: z.string().max(0, "Bot detected").optional().or(z.literal("")),
});

export type ContactFormData = z.infer<typeof contactFormSchema>;

export const loginSchema = z.object({
  email: z.string().email("Please enter a valid email address"),
  password: z.string().min(6, "Password must be at least 6 characters"),
});

export type LoginFormData = z.infer<typeof loginSchema>;

export const skillSchema = z.object({
  name: z.string().min(1, "Name is required").max(100),
  category: z.string().default("general"),
  level: z.number().min(0).max(100).default(0),
  icon_url: z.string().url().optional().or(z.literal("")).nullable(),
  sort_order: z.number().default(0),
  is_visible: z.boolean().default(true),
});

export const projectSchema = z.object({
  title: z.string().min(1, "Title is required").max(200),
  slug: z.string().min(1, "Slug is required").max(200),
  short_description: z.string().max(500).optional().nullable(),
  description: z.string().optional().nullable(),
  image_url: z.string().optional().nullable(),
  gallery_urls: z.array(z.string()).default([]),
  tech_stack: z.array(z.string()).default([]),
  live_url: z.string().url().optional().or(z.literal("")).nullable(),
  github_url: z.string().url().optional().or(z.literal("")).nullable(),
  category: z.string().default("web-development"),
  featured: z.boolean().default(false),
  is_visible: z.boolean().default(true),
  sort_order: z.number().default(0),
});

export const experienceSchema = z.object({
  company: z.string().min(1, "Company is required").max(200),
  position: z.string().min(1, "Position is required").max(200),
  start_date: z.string().optional().nullable(),
  end_date: z.string().optional().nullable(),
  is_current: z.boolean().default(false),
  description: z.string().optional().nullable(),
  location: z.string().max(300).optional().nullable(),
  sort_order: z.number().default(0),
  is_visible: z.boolean().default(true),
});

export const educationSchema = z.object({
  institution: z.string().min(1, "Institution is required").max(200),
  degree: z.string().min(1, "Degree is required").max(200),
  field: z.string().max(200).optional().nullable(),
  start_year: z.number().min(1900).max(2100).optional().nullable(),
  end_year: z.number().min(1900).max(2100).optional().nullable(),
  description: z.string().optional().nullable(),
  sort_order: z.number().default(0),
  is_visible: z.boolean().default(true),
});

export const serviceSchema = z.object({
  title: z.string().min(1, "Title is required").max(200),
  description: z.string().max(1000).optional().nullable(),
  icon: z.string().default("briefcase"),
  sort_order: z.number().default(0),
  is_visible: z.boolean().default(true),
});

export const socialLinkSchema = z.object({
  platform: z.string().min(1, "Platform is required").max(50),
  url: z.string().url("Please enter a valid URL"),
  icon: z.string().default("link"),
  sort_order: z.number().default(0),
  is_visible: z.boolean().default(true),
});

export const certificationSchema = z.object({
  title: z.string().min(1, "Title is required").max(200),
  issuer: z.string().max(200).optional().nullable(),
  issue_date: z.string().optional().nullable(),
  credential_url: z.string().url().optional().or(z.literal("")).nullable(),
  image_url: z.string().optional().nullable(),
  sort_order: z.number().default(0),
  is_visible: z.boolean().default(true),
});

export const heroSchema = z.object({
  title: z.string().min(1).max(200),
  subtitle: z.string().max(200).optional().nullable(),
  description: z.string().max(1000).optional().nullable(),
  profile_image_url: z.string().optional().nullable(),
  background_image_url: z.string().optional().nullable(),
  cta_primary_label: z.string().max(50).optional().nullable(),
  cta_primary_url: z.string().max(200).optional().nullable(),
  cta_secondary_label: z.string().max(50).optional().nullable(),
  cta_secondary_url: z.string().max(200).optional().nullable(),
  is_active: z.boolean().default(true),
});

export const aboutSchema = z.object({
  heading: z.string().max(200).default("About Me"),
  content: z.string().max(5000).optional().nullable(),
  image_url: z.string().optional().nullable(),
  years_experience: z.number().min(0).max(50).default(0),
});

export const siteSettingsSchema = z.object({
  site_name: z.string().max(200).default("Md Moklesar Rahman"),
  owner_name: z.string().max(200).default("Md Moklesar Rahman"),
  tagline: z.string().max(300).optional().nullable(),
  logo_url: z.string().optional().nullable(),
  resume_url: z.string().optional().nullable(),
  primary_email: z.string().email().optional().nullable(),
  phone: z.string().max(30).optional().nullable(),
  location: z.string().max(300).optional().nullable(),
});
