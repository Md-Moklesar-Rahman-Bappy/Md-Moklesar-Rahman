import { ExternalLink, Phone, Mail, MapPin } from "lucide-react";
import { SocialLink } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { getCategoryLabel } from "@/lib/utils";

interface FooterProps {
  socialLinks?: SocialLink[];
  email?: string | null;
  phone?: string | null;
  location?: string | null;
}

export function Footer({
  socialLinks = fallbackData.socialLinks,
  email = fallbackData.siteSettings.primary_email,
  phone = fallbackData.siteSettings.phone,
  location = fallbackData.siteSettings.location,
}: FooterProps) {
  const platformIcon = (icon: string) => {
    const icons: Record<string, string> = {
      instagram: "📸",
      youtube: "🎥",
      github: "🐙",
      linkedin: "💼",
    };
    return icons[icon] || "🔗";
  };

  return (
    <footer className="bg-dark-900 text-dark-300">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {/* Brand */}
          <div>
            <h3 className="text-xl font-bold text-white mb-4">
              Md<span className="text-primary-400">.</span>Rahman
            </h3>
            <p className="text-dark-400 text-sm leading-relaxed">
              Web Designer & Developer specializing in WordPress, Laravel, and modern web solutions.
            </p>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="text-sm font-semibold text-white uppercase tracking-wider mb-4">
              Quick Links
            </h4>
            <ul className="space-y-2">
              {["About", "Projects", "Experience", "Contact"].map((item) => (
                <li key={item}>
                  <a
                    href={`#${item.toLowerCase()}`}
                    className="text-sm text-dark-400 hover:text-primary-400 transition-colors"
                  >
                    {item}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact & Social */}
          <div>
            <h4 className="text-sm font-semibold text-white uppercase tracking-wider mb-4">
              Contact
            </h4>
            <ul className="space-y-3">
              {email && (
                <li className="flex items-center gap-2 text-sm text-dark-400">
                  <Mail size={14} />
                  <a href={`mailto:${email}`} className="hover:text-primary-400 transition-colors">
                    {email}
                  </a>
                </li>
              )}
              {phone && (
                <li className="flex items-center gap-2 text-sm text-dark-400">
                  <Phone size={14} />
                  <a href={`tel:${phone}`} className="hover:text-primary-400 transition-colors">
                    {phone}
                  </a>
                </li>
              )}
              {location && (
                <li className="flex items-center gap-2 text-sm text-dark-400">
                  <MapPin size={14} />
                  <span>{location}</span>
                </li>
              )}
            </ul>

            {/* Social Links */}
            <div className="flex items-center gap-3 mt-4">
              {socialLinks.filter(s => s.is_visible).map((link) => (
                <a
                  key={link.id}
                  href={link.url}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="flex items-center justify-center w-8 h-8 rounded-lg bg-dark-800 text-dark-400 hover:bg-primary-500 hover:text-white transition-all"
                  title={link.platform}
                >
                  <ExternalLink size={14} />
                </a>
              ))}
            </div>
          </div>
        </div>

        <div className="mt-10 pt-8 border-t border-dark-800 text-center text-sm text-dark-500">
          <p>&copy; {new Date().getFullYear()} Md Moklesar Rahman. All rights reserved.</p>
        </div>
      </div>
    </footer>
  );
}
