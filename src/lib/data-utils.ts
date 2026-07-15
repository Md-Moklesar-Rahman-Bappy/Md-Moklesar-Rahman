export const DATA_FILE_MAP: Record<string, string> = {
  site_settings: "site-settings.json",
  hero: "hero.json",
  about: "about.json",
  skills: "skills.json",
  projects: "projects.json",
  experience: "experience.json",
  education: "education.json",
  services: "services.json",
  certifications: "certifications.json",
  social_links: "social-links.json",
  contact_messages: "messages.json",
};

export function generateId(): string {
  return `${Date.now().toString(36)}-${Math.random().toString(36).slice(2, 8)}`;
}
