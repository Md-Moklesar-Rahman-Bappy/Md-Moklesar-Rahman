import type {
  SiteSettings, Hero, About, Skill, Project, Experience,
  Education, Service, Certification, SocialLink, ContactMessage,
  MediaAsset,
} from "@/types/database";
import { isSupabaseConfigured, getJsonFilename } from "@/lib/supabase";
import { generateId } from "@/lib/data-utils";
import { commitFile, isGitHubConfigured } from "./githubService";
import { fallbackData } from "@/lib/fallback";

import siteSettingsRaw from "@/data/site-settings.json";
import heroRaw from "@/data/hero.json";
import aboutRaw from "@/data/about.json";
import skillsRaw from "@/data/skills.json";
import projectsRaw from "@/data/projects.json";
import experienceRaw from "@/data/experience.json";
import educationRaw from "@/data/education.json";
import servicesRaw from "@/data/services.json";
import certificationsRaw from "@/data/certifications.json";
import socialLinksRaw from "@/data/social-links.json";
import messagesRaw from "@/data/messages.json";

// --- Read helpers ---

// eslint-disable-next-line @typescript-eslint/no-explicit-any
function fillMeta<T>(item: any, extra?: Record<string, string>): T {
  return { ...item, created_at: "", updated_at: "", ...extra } as T;
}

const _siteSettings: SiteSettings = fillMeta<SiteSettings>(siteSettingsRaw);
const _hero: Hero = fillMeta<Hero>(heroRaw);
const _about: About = fillMeta<About>(aboutRaw);
const _skills: Skill[] = (skillsRaw as unknown as Skill[]).map(s => fillMeta<Skill>(s));
const _projects: Project[] = (projectsRaw as unknown as Project[]).map(p => fillMeta<Project>(p));
const _experience: Experience[] = (experienceRaw as unknown as Experience[]).map(e => fillMeta<Experience>(e));
const _education: Education[] = (educationRaw as unknown as Education[]).map(e => fillMeta<Education>(e));
const _services: Service[] = (servicesRaw as unknown as Service[]).map(s => fillMeta<Service>(s));
const _certifications: Certification[] = (certificationsRaw as unknown as Certification[]).map(c => fillMeta<Certification>(c));
const _socialLinks: SocialLink[] = (socialLinksRaw as unknown as SocialLink[]).map(s => fillMeta<SocialLink>(s));
const _messagesRaw: ContactMessage[] = (messagesRaw as unknown as ContactMessage[]).map(m => fillMeta<ContactMessage>(m));
const _storedMessages = loadMessagesFromStorage();
const _messageIds = new Set(_messagesRaw.map(m => m.id));
const _extraStored = _storedMessages.filter(m => !_messageIds.has(m.id));
let _messages: ContactMessage[] = [..._messagesRaw, ..._extraStored];

// --- Public read functions ---

export function getSiteSettings(): SiteSettings {
  return _siteSettings;
}

export function getHero(): Hero {
  return _hero;
}

export function getAbout(): About {
  return _about;
}

export function getSkills(): Skill[] {
  return _skills;
}

export function getProjects(): Project[] {
  return _projects;
}

export function getExperience(): Experience[] {
  return _experience;
}

export function getEducation(): Education[] {
  return _education;
}

export function getServices(): Service[] {
  return _services;
}

export function getCertifications(): Certification[] {
  return _certifications;
}

export function getSocialLinks(): SocialLink[] {
  return _socialLinks;
}

function saveMessagesToStorage() {
  try {
    localStorage.setItem("portfolio_messages", JSON.stringify(_messages));
  } catch {
    // localStorage may be full or unavailable
  }
}

function loadMessagesFromStorage(): ContactMessage[] {
  try {
    const stored = localStorage.getItem("portfolio_messages");
    return stored ? JSON.parse(stored) : [];
  } catch {
    return [];
  }
}

export async function submitContactMessage(msg: {
  name: string;
  email: string;
  subject: string;
  message: string;
}): Promise<{ success: boolean; error?: string }> {
  const newMessage: ContactMessage = {
    id: generateId(),
    name: msg.name,
    email: msg.email,
    subject: msg.subject,
    message: msg.message,
    is_read: false,
    created_at: new Date().toISOString(),
  };
  _messages = [..._messages, newMessage];
  saveMessagesToStorage();

  if (isGitHubConfigured()) {
    const result = await commitFile(
      `src/data/${getJsonFilename("contact_messages")}`,
      JSON.stringify(_messages.map(({ created_at, ...rest }) => rest), null, 2),
      "Add contact message"
    );
    if (!result.success) {
      return { success: false, error: result.error };
    }
  }

  return { success: true };
}

// --- Admin read functions ---

export function adminGetAll<T>(table: string): T[] {
  switch (table) {
    case "skills": return [..._skills] as unknown as T[];
    case "projects": return [..._projects] as unknown as T[];
    case "experience": return [..._experience] as unknown as T[];
    case "education": return [..._education] as unknown as T[];
    case "services": return [..._services] as unknown as T[];
    case "social_links": return [..._socialLinks] as unknown as T[];
    case "certifications": return [..._certifications] as unknown as T[];
    case "contact_messages": return [..._messages] as unknown as T[];
    default: return [];
  }
}

export function adminGetSingle(table: string): Record<string, unknown> | null {
  switch (table) {
    case "site_settings": return { ..._siteSettings };
    case "hero": return { ..._hero };
    case "about": return { ..._about };
    default: return null;
  }
}

export async function adminInsert(table: string, record: Record<string, unknown>): Promise<Record<string, unknown>> {
  const item = { id: generateId(), ...record };

  switch (table) {
    case "skills": _skills.push(item as unknown as Skill); break;
    case "projects": _projects.push(item as unknown as Project); break;
    case "experience": _experience.push(item as unknown as Experience); break;
    case "education": _education.push(item as unknown as Education); break;
    case "services": _services.push(item as unknown as Service); break;
    case "social_links": _socialLinks.push(item as unknown as SocialLink); break;
    case "certifications": _certifications.push(item as unknown as Certification); break;
    default: throw new Error(`Unknown table: ${table}`);
  }

  await saveTableToGitHub(table);
  return item;
}

export async function adminUpdate(table: string, id: string, record: Record<string, unknown>): Promise<void> {
  const updateItem = <T extends { id: string }>(arr: T[]): void => {
    const idx = arr.findIndex(i => i.id === id);
    if (idx === -1) throw new Error(`Item with id ${id} not found in ${table}`);
    arr[idx] = { ...arr[idx], ...record } as T;
  };

  switch (table) {
    case "skills": updateItem<Skill>(_skills); break;
    case "projects": updateItem<Project>(_projects); break;
    case "experience": updateItem<Experience>(_experience); break;
    case "education": updateItem<Education>(_education); break;
    case "services": updateItem<Service>(_services); break;
    case "social_links": updateItem<SocialLink>(_socialLinks); break;
    case "certifications": updateItem<Certification>(_certifications); break;
    case "site_settings": Object.assign(_siteSettings, record); break;
    case "hero": Object.assign(_hero, record); break;
    case "about": Object.assign(_about, record); break;
    default: throw new Error(`Unknown table: ${table}`);
  }

  await saveTableToGitHub(table);
}

export async function adminDelete(table: string, id: string): Promise<void> {
  const removeItem = <T extends { id: string }>(arr: T[]): T[] => arr.filter(i => i.id !== id);

  switch (table) {
    case "skills": _skills.splice(0, _skills.length, ...removeItem<Skill>(_skills)); break;
    case "projects": _projects.splice(0, _projects.length, ...removeItem<Project>(_projects)); break;
    case "experience": _experience.splice(0, _experience.length, ...removeItem<Experience>(_experience)); break;
    case "education": _education.splice(0, _education.length, ...removeItem<Education>(_education)); break;
    case "services": _services.splice(0, _services.length, ...removeItem<Service>(_services)); break;
    case "social_links": _socialLinks.splice(0, _socialLinks.length, ...removeItem<SocialLink>(_socialLinks)); break;
    case "certifications": _certifications.splice(0, _certifications.length, ...removeItem<Certification>(_certifications)); break;
    default: throw new Error(`Unknown table: ${table}`);
  }

  await saveTableToGitHub(table);
}

export async function adminMarkMessageRead(id: string): Promise<void> {
  const msg = _messages.find(m => m.id === id);
  if (msg) {
    msg.is_read = true;
  }
}

// --- Helpers ---

// eslint-disable-next-line @typescript-eslint/no-explicit-any
function getTableData(table: string): any {
  switch (table) {
    case "site_settings": return _siteSettings;
    case "hero": return _hero;
    case "about": return _about;
    case "skills": return _skills;
    case "projects": return _projects;
    case "experience": return _experience;
    case "education": return _education;
    case "services": return _services;
    case "social_links": return _socialLinks;
    case "certifications": return _certifications;
    case "contact_messages": return _messages;
    default: throw new Error(`Unknown table: ${table}`);
  }
}

async function saveTableToGitHub(table: string): Promise<void> {
  if (!isGitHubConfigured()) return;

  const data = getTableData(table);
  const json = JSON.stringify(data, null, 2);

  const result = await commitFile(
    `src/data/${getJsonFilename(table)}`,
    json,
    `Update ${table} via admin dashboard`
  );

  if (!result.success) {
    console.error(`Failed to commit ${table}:`, result.error);
  }
}

// Legacy compatibility
export async function adminGetMessages(): Promise<ContactMessage[]> {
  return [..._messages].sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());
}

export async function uploadMedia(_file: File): Promise<MediaAsset> {
  throw new Error("Media upload requires GitHub LFS or external storage. Use a direct URL instead.");
}

export async function deleteMedia(_id: string, _fileUrl: string): Promise<void> {
  throw new Error("Media management via GitHub is not supported. Remove the URL from your data files instead.");
}
