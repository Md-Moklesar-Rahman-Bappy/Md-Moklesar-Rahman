import { Phone, Mail, MapPin } from "lucide-react";
import { SocialLink, SiteSettings } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SocialIcon } from "@/components/ui/SocialIcon";

interface FooterProps {
  socialLinks?: SocialLink[];
  email?: string | null;
  phone?: string | null;
  location?: string | null;
  siteSettings?: SiteSettings;
}

export function Footer({
  socialLinks = fallbackData.socialLinks,
  email = fallbackData.siteSettings.primary_email,
  phone = fallbackData.siteSettings.phone,
  location = fallbackData.siteSettings.location,
  siteSettings = fallbackData.siteSettings,
}: FooterProps) {
  return (
    <footer className="bg-dark-950 text-dark-300 relative overflow-hidden">
      <div className="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-500 via-accent-500 to-highlight-500" />
      <div className="blob-decoration w-64 h-64 bg-primary-600/10 -top-32 -right-32 animate-blob" />
      <div className="blob-decoration w-80 h-80 bg-accent-600/10 -bottom-40 -left-40 animate-blob" style={{ animationDelay: "3s" }} />

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-10">
          <div>
            <h3 className="text-2xl font-bold mb-4">
              <span className="gradient-text">{siteSettings.site_name || siteSettings.owner_name}</span>
            </h3>
            <p className="text-dark-400 text-sm leading-relaxed">
              {siteSettings.tagline || "Web Designer & Developer"}
            </p>
          </div>

          <div>
            <h4 className="text-sm font-semibold text-white uppercase tracking-widest mb-5">
              Quick Links
            </h4>
            <ul className="space-y-3">
              {["About", "Projects", "Experience", "Contact"].map((item) => (
                <li key={item}>
                  <a
                    href={`#${item.toLowerCase()}`}
                    className="text-sm text-dark-400 hover:text-primary-400 transition-colors duration-300 hover:translate-x-1 inline-block"
                  >
                    {item}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h4 className="text-sm font-semibold text-white uppercase tracking-widest mb-5">
              Contact
            </h4>
            <ul className="space-y-4">
              {email && (
                <li className="flex items-center gap-3 text-sm text-dark-400">
                  <span className="w-8 h-8 rounded-lg bg-dark-800 flex items-center justify-center shrink-0">
                    <Mail size={14} className="text-primary-400" />
                  </span>
                  <a href={`mailto:${email}`} className="hover:text-primary-400 transition-colors">
                    {email}
                  </a>
                </li>
              )}
              {phone && (
                <li className="flex items-center gap-3 text-sm text-dark-400">
                  <span className="w-8 h-8 rounded-lg bg-dark-800 flex items-center justify-center shrink-0">
                    <Phone size={14} className="text-accent-400" />
                  </span>
                  <a href={`tel:${phone}`} className="hover:text-primary-400 transition-colors">
                    {phone}
                  </a>
                </li>
              )}
              {location && (
                <li className="flex items-center gap-3 text-sm text-dark-400">
                  <span className="w-8 h-8 rounded-lg bg-dark-800 flex items-center justify-center shrink-0">
                    <MapPin size={14} className="text-secondary-400" />
                  </span>
                  <span>{location}</span>
                </li>
              )}
            </ul>

            <div className="flex items-center gap-3 mt-6">
              {socialLinks.filter(s => s.is_visible).map((link) => (
                <a
                  key={link.id}
                  href={link.url}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="flex items-center justify-center w-9 h-9 rounded-xl bg-dark-800 text-dark-400 hover:scale-110 hover:-translate-y-0.5 hover:text-primary-400 transition-all duration-300 group"
                  title={link.platform}
                >
                  <SocialIcon icon={link.icon} className="text-sm" />
                </a>
              ))}
            </div>
          </div>
        </div>

        <div className="mt-12 pt-8 border-t border-dark-800/50 text-center">
          <p className="text-sm text-dark-500">&copy; {new Date().getFullYear()} Md Moklesar Rahman. Crafted with <span className="text-accent-400">&#9829;</span></p>
        </div>
      </div>
    </footer>
  );
}
