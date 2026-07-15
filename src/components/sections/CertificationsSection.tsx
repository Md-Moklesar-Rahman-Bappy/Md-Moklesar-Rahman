import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { ExternalLink, Award, X } from "lucide-react";
import { Certification } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";
import { EmptyState } from "@/components/ui/LoadingState";
import { getCategoryColor, getCategoryLabel, formatDate } from "@/lib/utils";

interface CertificationsSectionProps {
  certifications?: Certification[];
}

export function CertificationsSection({ certifications = fallbackData.certifications }: CertificationsSectionProps) {
  const [selected, setSelected] = useState<Certification | null>(null);
  const visible = certifications.filter(c => c.is_visible).sort((a, b) => a.sort_order - b.sort_order);

  if (visible.length === 0) {
    return (
      <SectionWrapper id="certifications">
        <SectionHeader title="Certifications" subtitle="Professional credentials and achievements" />
        <EmptyState message="No certifications to display yet. Check back soon!" />
      </SectionWrapper>
    );
  }

  return (
    <SectionWrapper id="certifications" className="section-gradient-3">
      <SectionHeader title="Certifications" subtitle="Professional credentials and achievements" />
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {visible.map((cert, index) => (
          <motion.div
            key={cert.id}
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: "-50px" }}
            transition={{ duration: 0.4, delay: index * 0.05 }}
            className="group cursor-pointer"
            onClick={() => setSelected(cert)}
          >
            <div className="rounded-xl overflow-hidden bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
              <div className="aspect-[3/2] bg-gradient-to-br from-primary-100 via-accent-50 to-secondary-100 dark:from-dark-700 dark:via-dark-800 dark:to-dark-700 flex items-center justify-center overflow-hidden relative">
                {cert.image_url ? (
                  <img
                    src={cert.image_url}
                    alt={cert.title}
                    className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                    loading="lazy"
                  />
                ) : (
                  <Award size={48} className="text-dark-300 dark:text-dark-500 opacity-50" />
                )}
                <div className="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
              </div>
              <div className="p-4">
                <h3 className="font-semibold text-dark-900 dark:text-white group-hover:text-primary-500 transition-colors duration-300 text-sm leading-snug">
                  {cert.title}
                </h3>
                <p className="mt-1 text-xs text-dark-500 dark:text-dark-400">{cert.issuer}</p>
                <div className="mt-3 flex items-center justify-between">
                  {cert.category && (
                    <span className={`inline-block px-2 py-0.5 text-[10px] font-semibold rounded-full ${getCategoryColor(cert.category)}`}>
                      {getCategoryLabel(cert.category)}
                    </span>
                  )}
                  {cert.issue_date && (
                    <span className="text-[10px] text-dark-400 dark:text-dark-500">{formatDate(cert.issue_date)}</span>
                  )}
                </div>
              </div>
            </div>
          </motion.div>
        ))}
      </div>

      <AnimatePresence>
        {selected && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
            onClick={() => setSelected(null)}
          >
            <motion.div
              initial={{ opacity: 0, scale: 0.95, y: 20 }}
              animate={{ opacity: 1, scale: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.95, y: 20 }}
              className="relative w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-2xl bg-white dark:bg-dark-800 p-6 sm:p-8 shadow-2xl border border-dark-100 dark:border-dark-700"
              onClick={(e) => e.stopPropagation()}
            >
              <button
                onClick={() => setSelected(null)}
                className="absolute top-4 right-4 p-2 rounded-xl text-dark-400 hover:text-dark-600 dark:hover:text-dark-200 hover:bg-dark-100 dark:hover:bg-dark-700 transition-colors"
              >
                <X size={20} />
              </button>

              <div className="aspect-[3/2] rounded-xl bg-gradient-to-br from-primary-100 via-accent-50 to-secondary-100 dark:from-dark-700 dark:via-dark-800 dark:to-dark-700 flex items-center justify-center overflow-hidden mb-6">
                {selected.image_url ? (
                  <img src={selected.image_url} alt={selected.title} className="w-full h-full object-cover" />
                ) : (
                  <Award size={64} className="text-dark-300 dark:text-dark-500 opacity-50" />
                )}
              </div>

              <h2 className="text-xl font-bold gradient-text-primary">{selected.title}</h2>
              <p className="mt-1 text-sm text-dark-500 dark:text-dark-400">{selected.issuer}</p>

              {selected.issue_date && (
                <p className="mt-2 text-xs text-dark-400 dark:text-dark-500">Issued: {formatDate(selected.issue_date)}</p>
              )}

              {selected.category && (
                <div className="mt-3">
                  <span className={`inline-block px-3 py-1 text-xs font-semibold rounded-full ${getCategoryColor(selected.category)}`}>
                    {getCategoryLabel(selected.category)}
                  </span>
                </div>
              )}

              {selected.credential_url && (
                <div className="mt-6">
                  <a
                    href={selected.credential_url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn-gradient"
                  >
                    <ExternalLink size={14} /> View Credential
                  </a>
                </div>
              )}
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>
    </SectionWrapper>
  );
}
