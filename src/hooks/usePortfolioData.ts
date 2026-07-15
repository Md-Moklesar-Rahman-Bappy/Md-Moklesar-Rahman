import { useState, useEffect } from "react";
import {
  getSiteSettings, getHero, getAbout, getSkills, getProjects,
  getExperience, getEducation, getServices, getSocialLinks,
} from "@/services/portfolioService";
import { fallbackData } from "@/lib/fallback";
import { isSupabaseConfigured } from "@/lib/supabase";
import type {
  SiteSettings, Hero, About, Skill, Project,
  Experience, Education, Service, SocialLink,
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
};

export function usePortfolioData() {
  const [data, setData] = useState<PortfolioData>(defaultData);
  const [loading, setLoading] = useState(isSupabaseConfigured);

  useEffect(() => {
    if (!isSupabaseConfigured) return;
    async function load() {
      try {
        const [siteSettings, hero, about, skills, projects, experience, education, services, socialLinks] =
          await Promise.all([
            getSiteSettings(),
            getHero(),
            getAbout(),
            getSkills(),
            getProjects(),
            getExperience(),
            getEducation(),
            getServices(),
            getSocialLinks(),
          ]);
        setData({ siteSettings, hero, about, skills, projects, experience, education, services, socialLinks });
      } catch (e) {
        console.error("Failed to load portfolio data:", e);
      } finally {
        setLoading(false);
      }
    }
    load();
  }, []);

  return { data, loading };
}
