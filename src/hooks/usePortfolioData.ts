import {
  getSiteSettings, getHero, getAbout, getSkills, getProjects,
  getExperience, getEducation, getServices, getSocialLinks,
  getCertifications,
} from "@/services/portfolioService";
import { fallbackData } from "@/lib/fallback";
import type {
  SiteSettings, Hero, About, Skill, Project,
  Experience, Education, Service, SocialLink, Certification,
} from "@/types/database";

interface PortfolioData {
  siteSettings: SiteSettings;
  hero: Hero;
  about: About;
  skills: Skill[];
  projects: Project[];
  experience: Experience[];
  education: Education[];
  services: Service[];
  socialLinks: SocialLink[];
  certifications: Certification[];
}

const defaultData: PortfolioData = {
  siteSettings: fallbackData.siteSettings,
  hero: fallbackData.hero,
  about: fallbackData.about,
  skills: fallbackData.skills,
  projects: fallbackData.projects,
  experience: fallbackData.experience,
  education: fallbackData.education,
  services: fallbackData.services,
  socialLinks: fallbackData.socialLinks,
  certifications: fallbackData.certifications,
};

function loadData(): PortfolioData {
  try {
    return {
      siteSettings: getSiteSettings(),
      hero: getHero(),
      about: getAbout(),
      skills: getSkills(),
      projects: getProjects(),
      experience: getExperience(),
      education: getEducation(),
      services: getServices(),
      socialLinks: getSocialLinks(),
      certifications: getCertifications(),
    };
  } catch {
    return defaultData;
  }
}

export function usePortfolioData() {
  return { data: loadData(), loading: false };
}
