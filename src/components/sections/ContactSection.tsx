import { useState } from "react";
import { motion } from "framer-motion";
import { Send, Mail, Phone, MapPin, CheckCircle, AlertCircle } from "lucide-react";
import { SocialLink } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";
import { submitContactMessage } from "@/services/portfolioService";
import { contactFormSchema } from "@/lib/validations";
import { SocialIcon } from "@/components/ui/SocialIcon";

interface ContactSectionProps {
  email?: string | null;
  phone?: string | null;
  location?: string | null;
  socialLinks?: SocialLink[];
}

export function ContactSection({
  email = fallbackData.siteSettings.primary_email,
  phone = fallbackData.siteSettings.phone,
  location = fallbackData.siteSettings.location,
  socialLinks = fallbackData.socialLinks,
}: ContactSectionProps) {
  const [form, setForm] = useState({ name: "", email: "", subject: "", message: "", website: "" });
  const [errors, setErrors] = useState<Record<string, string>>({});
  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle");
  const [statusMsg, setStatusMsg] = useState("");

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setErrors({});
    setStatus("idle");

    const result = contactFormSchema.safeParse(form);
    if (!result.success) {
      const fieldErrors: Record<string, string> = {};
      result.error.issues.forEach((issue) => {
        if (issue.path[0]) fieldErrors[issue.path[0] as string] = issue.message;
      });
      setErrors(fieldErrors);
      return;
    }

    if (form.website) return;

    setStatus("loading");
    const res = await submitContactMessage({
      name: form.name,
      email: form.email,
      subject: form.subject,
      message: form.message,
    });

    if (res.success) {
      setStatus("success");
      setStatusMsg("Message sent successfully! I'll get back to you soon.");
      setForm({ name: "", email: "", subject: "", message: "", website: "" });
    } else {
      setStatus("error");
      setStatusMsg(res.error || "Failed to send message. Please try again.");
    }
  };

  return (
    <SectionWrapper id="contact" className="section-gradient-3">
      <SectionHeader title="Get In Touch" subtitle="Have a project in mind? Let's talk." />
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
        {/* Info */}
        <motion.div
          initial={{ opacity: 0, x: -20 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.5 }}
          className="space-y-6"
        >
          <div>
            <h3 className="text-2xl font-bold gradient-text-primary mb-2">Contact Information</h3>
            <p className="text-dark-500 dark:text-dark-400">Feel free to reach out for collaboration or inquiries.</p>
          </div>

          <div className="space-y-4">
            {email && (
              <a href={`mailto:${email}`} className="group flex items-center gap-4 p-4 rounded-xl glass-card hover:bg-gradient-to-r hover:from-primary-50 hover:to-accent-50 dark:hover:from-primary-900/20 dark:hover:to-accent-900/20 transition-all duration-300">
                <span className="w-10 h-10 rounded-lg bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                  <Mail size={18} className="text-primary-500" />
                </span>
                <span className="text-sm font-medium text-dark-700 dark:text-dark-200 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{email}</span>
              </a>
            )}
            {phone && (
              <a href={`tel:${phone}`} className="group flex items-center gap-4 p-4 rounded-xl glass-card hover:bg-gradient-to-r hover:from-accent-50 hover:to-highlight-50 dark:hover:from-accent-900/20 dark:hover:to-highlight-900/20 transition-all duration-300">
                <span className="w-10 h-10 rounded-lg bg-gradient-to-br from-accent-100 to-accent-200 dark:from-accent-900/30 dark:to-accent-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                  <Phone size={18} className="text-accent-500" />
                </span>
                <span className="text-sm font-medium text-dark-700 dark:text-dark-200 group-hover:text-accent-600 dark:group-hover:text-accent-400 transition-colors">{phone}</span>
              </a>
            )}
            {location && (
              <div className="flex items-center gap-4 p-4 rounded-xl glass-card">
                <span className="w-10 h-10 rounded-lg bg-gradient-to-br from-secondary-100 to-secondary-200 dark:from-secondary-900/30 dark:to-secondary-900/20 flex items-center justify-center">
                  <MapPin size={18} className="text-secondary-500" />
                </span>
                <span className="text-sm text-dark-700 dark:text-dark-200">{location}</span>
              </div>
            )}
          </div>

          <div className="flex items-center gap-3">
            {socialLinks.filter(s => s.is_visible).map((link) => (
              <a
                key={link.id}
                href={link.url}
                target="_blank"
                rel="noopener noreferrer"
                className="w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700 text-dark-500 dark:text-dark-400 hover:bg-gradient-to-br hover:from-primary-500 hover:to-accent-500 hover:text-white hover:border-transparent hover:shadow-lg hover:-translate-y-1 transition-all duration-300"
                title={link.platform}
              >
                <SocialIcon icon={link.icon} className="text-sm" />
              </a>
            ))}
          </div>
        </motion.div>

        {/* Form */}
        <motion.form
          onSubmit={handleSubmit}
          initial={{ opacity: 0, x: 20 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.5 }}
          className="space-y-5"
        >
          {/* Honeypot */}
          <div className="absolute opacity-0 pointer-events-none" aria-hidden="true">
            <input
              type="text"
              name="website"
              value={form.website}
              onChange={(e) => setForm({ ...form, website: e.target.value })}
              tabIndex={-1}
              autoComplete="off"
            />
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <input
                type="text"
                placeholder="Your Name"
                value={form.name}
                onChange={(e) => setForm({ ...form, name: e.target.value })}
                className="w-full px-4 py-3 rounded-xl border border-dark-200 dark:border-dark-700 bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400/50 focus:border-primary-400 outline-none transition-all text-sm"
              />
              {errors.name && <p className="mt-1.5 text-xs text-accent-500">{errors.name}</p>}
            </div>
            <div>
              <input
                type="email"
                placeholder="Your Email"
                value={form.email}
                onChange={(e) => setForm({ ...form, email: e.target.value })}
                className="w-full px-4 py-3 rounded-xl border border-dark-200 dark:border-dark-700 bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400/50 focus:border-primary-400 outline-none transition-all text-sm"
              />
              {errors.email && <p className="mt-1.5 text-xs text-accent-500">{errors.email}</p>}
            </div>
          </div>

          <div>
            <input
              type="text"
              placeholder="Subject"
              value={form.subject}
              onChange={(e) => setForm({ ...form, subject: e.target.value })}
              className="w-full px-4 py-3 rounded-xl border border-dark-200 dark:border-dark-700 bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400/50 focus:border-primary-400 outline-none transition-all text-sm"
            />
            {errors.subject && <p className="mt-1.5 text-xs text-accent-500">{errors.subject}</p>}
          </div>

          <div>
            <textarea
              rows={5}
              placeholder="Your Message"
              value={form.message}
              onChange={(e) => setForm({ ...form, message: e.target.value })}
              className="w-full px-4 py-3 rounded-xl border border-dark-200 dark:border-dark-700 bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400/50 focus:border-primary-400 outline-none transition-all text-sm resize-none"
            />
            {errors.message && <p className="mt-1.5 text-xs text-accent-500">{errors.message}</p>}
          </div>

          <button
            type="submit"
            disabled={status === "loading"}
            className="btn-gradient shadow-xl shadow-primary-500/20"
          >
            {status === "loading" ? (
              <>
                <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin" />
                Sending...
              </>
            ) : (
              <>
                <Send size={16} />
                Send Message
              </>
            )}
          </button>

          {status === "success" && (
            <div className="flex items-center gap-2 p-4 rounded-xl bg-gradient-to-r from-secondary-50 to-secondary-100 dark:from-secondary-900/20 dark:to-secondary-900/10 border border-secondary-200 dark:border-secondary-800/30 text-secondary-700 dark:text-secondary-400 text-sm">
              <CheckCircle size={16} className="shrink-0" />
              {statusMsg}
            </div>
          )}
          {status === "error" && (
            <div className="flex items-center gap-2 p-4 rounded-xl bg-gradient-to-r from-accent-50 to-accent-100 dark:from-accent-900/20 dark:to-accent-900/10 border border-accent-200 dark:border-accent-800/30 text-accent-700 dark:text-accent-400 text-sm">
              <AlertCircle size={16} className="shrink-0" />
              {statusMsg}
            </div>
          )}
        </motion.form>
      </div>
    </SectionWrapper>
  );
}
