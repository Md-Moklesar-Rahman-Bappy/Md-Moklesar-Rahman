import { Navbar } from "@/components/layout/Navbar";
import { Footer } from "@/components/layout/Footer";
import { HeroSection } from "@/components/sections/HeroSection";
import { AboutSection } from "@/components/sections/AboutSection";
import { SkillsSection } from "@/components/sections/SkillsSection";
import { ServicesSection } from "@/components/sections/ServicesSection";
import { ProjectsSection } from "@/components/sections/ProjectsSection";
import { ExperienceSection } from "@/components/sections/ExperienceSection";
import { EducationSection } from "@/components/sections/EducationSection";
import { CertificationsSection } from "@/components/sections/CertificationsSection";
import { ContactSection } from "@/components/sections/ContactSection";
import { usePortfolioData } from "@/hooks/usePortfolioData";
import { LoadingSpinner } from "@/components/ui/LoadingState";

export function HomePage() {
  const { data, loading } = usePortfolioData();

  if (loading) return <LoadingSpinner />;

  return (
    <main>
      <Navbar />
      <HeroSection hero={data.hero} />
      <AboutSection about={data.about} />
      <SkillsSection skills={data.skills} />
      <ServicesSection services={data.services} />
      <ProjectsSection projects={data.projects} />
      <ExperienceSection experience={data.experience} />
      <EducationSection education={data.education} />
      <CertificationsSection certifications={data.certifications} />
      <ContactSection
        email={data.siteSettings.primary_email}
        phone={data.siteSettings.phone}
        location={data.siteSettings.location}
        socialLinks={data.socialLinks}
      />
      <Footer
        socialLinks={data.socialLinks}
        email={data.siteSettings.primary_email}
        phone={data.siteSettings.phone}
        location={data.siteSettings.location}
      />
    </main>
  );
}
