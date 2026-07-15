import {
  SiteSettings,
  Hero,
  About,
  Skill,
  Project,
  Experience,
  Education,
  Service,
  Certification,
  SocialLink,
  ContactMessage,
  MediaAsset,
} from "@/types/database";
import { getSupabase, isSupabaseConfigured } from "@/lib/supabase";
import { fallbackData } from "@/lib/fallback";

type TableName =
  | "site_settings"
  | "hero"
  | "about"
  | "skills"
  | "projects"
  | "experience"
  | "education"
  | "services"
  | "certifications"
  | "social_links"
  | "contact_messages"
  | "media_assets";

const sb = () => getSupabase();

async function fetchTable<T>(table: TableName, fallback: T): Promise<T> {
  if (!isSupabaseConfigured) return fallback;
  const { data, error } = await sb().from(table).select("*");
  if (error) {
    console.error(`Error fetching ${table}:`, error);
    return fallback;
  }
  return (data as T) || fallback;
}

async function fetchSingle<T>(table: TableName, fallback: T): Promise<T> {
  if (!isSupabaseConfigured) return fallback;
  const { data, error } = await sb().from(table).select("*").limit(1).single();
  if (error) {
    console.error(`Error fetching ${table}:`, error);
    return fallback;
  }
  return (data as T) || fallback;
}

export async function getSiteSettings(): Promise<SiteSettings> {
  return fetchSingle("site_settings", fallbackData.siteSettings);
}

export async function getHero(): Promise<Hero> {
  return fetchSingle("hero", fallbackData.hero);
}

export async function getAbout(): Promise<About> {
  return fetchSingle("about", fallbackData.about);
}

export async function getSkills(): Promise<Skill[]> {
  return fetchTable("skills", fallbackData.skills);
}

export async function getProjects(): Promise<Project[]> {
  return fetchTable("projects", fallbackData.projects);
}

export async function getExperience(): Promise<Experience[]> {
  return fetchTable("experience", fallbackData.experience);
}

export async function getEducation(): Promise<Education[]> {
  return fetchTable("education", fallbackData.education);
}

export async function getServices(): Promise<Service[]> {
  return fetchTable("services", fallbackData.services);
}

export async function getCertifications(): Promise<Certification[]> {
  return fetchTable("certifications", fallbackData.certifications);
}

export async function getSocialLinks(): Promise<SocialLink[]> {
  return fetchTable("social_links", fallbackData.socialLinks);
}

export async function submitContactMessage(msg: {
  name: string;
  email: string;
  subject: string;
  message: string;
}): Promise<{ success: boolean; error?: string }> {
  if (!isSupabaseConfigured) {
    return { success: false, error: "Database not configured" };
  }
  const { error } = await sb().from("contact_messages").insert(msg as any);
  if (error) {
    return { success: false, error: error.message };
  }
  return { success: true };
}

export async function adminGetAll<T>(table: TableName): Promise<T[]> {
  const { data, error } = await sb().from(table).select("*").order("sort_order", { ascending: true });
  if (error) throw error;
  return (data as T[]) || [];
}

export async function adminGetMessages(): Promise<ContactMessage[]> {
  const { data, error } = await sb()
    .from("contact_messages")
    .select("*")
    .order("created_at", { ascending: false });
  if (error) throw error;
  return (data as ContactMessage[]) || [];
}

export async function adminInsert(table: TableName, record: any) {
  const { data, error } = await sb().from(table).insert(record).select().single();
  if (error) throw error;
  return data;
}

export async function adminUpdate(table: TableName, id: string, record: any) {
  const { data, error } = await sb().from(table).update(record).eq("id", id).select().single();
  if (error) throw error;
  return data;
}

export async function adminDelete(table: TableName, id: string) {
  const { error } = await sb().from(table).delete().eq("id", id);
  if (error) throw error;
}

export async function adminMarkMessageRead(id: string) {
  const { error } = await sb().from("contact_messages").update({ is_read: true } as any).eq("id", id);
  if (error) throw error;
}

export async function uploadMedia(file: File): Promise<MediaAsset> {
  const fileExt = file.name.split(".").pop();
  const fileName = `${Date.now()}-${Math.random().toString(36).slice(2, 8)}.${fileExt}`;
  const { error: uploadError } = await sb().storage
    .from("portfolio-media")
    .upload(fileName, file);
  if (uploadError) throw uploadError;

  const { data: urlData } = sb().storage.from("portfolio-media").getPublicUrl(fileName);

  const asset = {
    file_name: file.name,
    file_url: urlData.publicUrl,
    file_type: file.type,
    file_size: file.size,
    bucket: "portfolio-media",
  };

  const { data, error } = await sb().from("media_assets").insert(asset as any).select().single();
  if (error) throw error;
  return data as MediaAsset;
}

export async function deleteMedia(id: string, fileUrl: string) {
  const path = fileUrl.split("/").pop();
  if (path) {
    await sb().storage.from("portfolio-media").remove([path]);
  }
  const { error } = await sb().from("media_assets").delete().eq("id", id);
  if (error) throw error;
}
