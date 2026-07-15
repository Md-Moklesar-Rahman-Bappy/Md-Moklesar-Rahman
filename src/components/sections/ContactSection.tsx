import { useState } from "react";
import { motion } from "framer-motion";
import { Send, Mail, Phone, MapPin, CheckCircle, AlertCircle } from "lucide-react";
import { SocialLink } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";
import { submitContactMessage } from "@/services/portfolioService";
import { contactFormSchema, ContactFormData } from "@/lib/validations";

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
    <SectionWrapper id="contact">
      <SectionHeader title="Get In Touch" subtitle="Have a project in mind? Let's talk." />
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
        {/* Info */}
        <motion.div
          initial={{ opacity: 0, x: -20 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.5 }}
          className="space-y-6"
        >
          <div>
            <h3 className="text-xl font-semibold text-dark-900 dark:text-white mb-2">Contact Information</h3>
            <p className="text-dark-500 dark:text-dark-400">Feel free to reach out for collaboration or inquiries.</p>
          </div>

          <div className="space-y-4">
            {email && (
              <a href={`mailto:${email}`} className="flex items-center gap-3 p-3 rounded-lg bg-dark-50 dark:bg-dark-800 text-dark-700 dark:text-dark-200 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors group">
                <Mail size={18} className="text-primary-500 group-hover:scale-110 transition-transform" />
                <span className="text-sm">{email}</span>
              </a>
            )}
            {phone && (
              <a href={`tel:${phone}`} className="flex items-center gap-3 p-3 rounded-lg bg-dark-50 dark:bg-dark-800 text-dark-700 dark:text-dark-200 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors group">
                <Phone size={18} className="text-primary-500 group-hover:scale-110 transition-transform" />
                <span className="text-sm">{phone}</span>
              </a>
            )}
            {location && (
              <div className="flex items-center gap-3 p-3 rounded-lg bg-dark-50 dark:bg-dark-800 text-dark-700 dark:text-dark-200">
                <MapPin size={18} className="text-primary-500 shrink-0" />
                <span className="text-sm">{location}</span>
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
                className="w-10 h-10 flex items-center justify-center rounded-lg bg-dark-100 dark:bg-dark-800 text-dark-500 dark:text-dark-400 hover:bg-primary-500 hover:text-white transition-all"
                title={link.platform}
              >
                <span className="text-xs font-bold">{link.platform.slice(0, 2)}</span>
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
          className="space-y-4"
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

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <input
                type="text"
                placeholder="Your Name"
                value={form.name}
                onChange={(e) => setForm({ ...form, name: e.target.value })}
                className="w-full px-4 py-2.5 rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-800 text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none transition-all text-sm"
              />
              {errors.name && <p className="mt-1 text-xs text-red-500">{errors.name}</p>}
            </div>
            <div>
              <input
                type="email"
                placeholder="Your Email"
                value={form.email}
                onChange={(e) => setForm({ ...form, email: e.target.value })}
                className="w-full px-4 py-2.5 rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-800 text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none transition-all text-sm"
              />
              {errors.email && <p className="mt-1 text-xs text-red-500">{errors.email}</p>}
            </div>
          </div>

          <div>
            <input
              type="text"
              placeholder="Subject"
              value={form.subject}
              onChange={(e) => setForm({ ...form, subject: e.target.value })}
              className="w-full px-4 py-2.5 rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-800 text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none transition-all text-sm"
            />
            {errors.subject && <p className="mt-1 text-xs text-red-500">{errors.subject}</p>}
          </div>

          <div>
            <textarea
              rows={5}
              placeholder="Your Message"
              value={form.message}
              onChange={(e) => setForm({ ...form, message: e.target.value })}
              className="w-full px-4 py-2.5 rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-800 text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none transition-all text-sm resize-none"
            />
            {errors.message && <p className="mt-1 text-xs text-red-500">{errors.message}</p>}
          </div>

          <button
            type="submit"
            disabled={status === "loading"}
            className="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
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
            <div className="flex items-center gap-2 p-3 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-sm">
              <CheckCircle size={16} />
              {statusMsg}
            </div>
          )}
          {status === "error" && (
            <div className="flex items-center gap-2 p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-sm">
              <AlertCircle size={16} />
              {statusMsg}
            </div>
          )}
        </motion.form>
      </div>
    </SectionWrapper>
  );
}
