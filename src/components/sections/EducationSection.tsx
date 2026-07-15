import { motion } from "framer-motion";
import { GraduationCap, Calendar } from "lucide-react";
import { Education } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";

interface EducationSectionProps {
  education?: Education[];
}

function getDotColor(index: number) {
  const colors = [
    "bg-gradient-to-br from-secondary-400 to-secondary-600 shadow-secondary-300/30",
    "bg-gradient-to-br from-primary-400 to-primary-600 shadow-primary-300/30",
    "bg-gradient-to-br from-accent-400 to-accent-600 shadow-accent-300/30",
    "bg-gradient-to-br from-highlight-400 to-highlight-600 shadow-highlight-300/30",
    "bg-gradient-to-br from-secondary-400 to-primary-500 shadow-secondary-300/30",
  ];
  return colors[index % colors.length];
}

function getCardBorder(index: number) {
  const colors = [
    "border-l-secondary-400",
    "border-l-primary-400",
    "border-l-accent-400",
    "border-l-highlight-400",
    "border-l-secondary-400",
  ];
  return colors[index % colors.length];
}

function getSortYear(edu: Education): number {
  return edu.end_year ?? edu.start_year ?? 0;
}

export function EducationSection({ education = fallbackData.education }: EducationSectionProps) {
  const visible = education
    .filter(e => e.is_visible)
    .sort((a, b) => {
      const yearCmp = getSortYear(b) - getSortYear(a);
      if (yearCmp !== 0) return yearCmp;
      return (a.sort_order ?? 999) - (b.sort_order ?? 999);
    });

  return (
    <SectionWrapper id="education" className="section-gradient-2">
      <SectionHeader title="Education" subtitle="My academic background" />
      <div className="relative max-w-3xl mx-auto">
        <div className="absolute left-5 sm:left-7 top-0 bottom-0 w-px bg-gradient-to-b from-secondary-200 via-primary-200 to-accent-200 dark:from-secondary-800 dark:via-primary-800 dark:to-accent-800" />
        <div className="space-y-10">
          {visible.map((edu, index) => (
            <motion.div
              key={edu.id}
              initial={{ opacity: 0, x: -20 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true, margin: "-50px" }}
              transition={{ duration: 0.4, delay: index * 0.1 }}
              className="relative pl-14 sm:pl-16"
            >
              <div className={`absolute left-3 sm:left-4.5 top-1.5 w-4 h-4 rounded-full ${getDotColor(index)} border-2 border-white dark:border-dark-900 shadow-lg animate-pulse-slow`} />
              <div className={`p-6 rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 border-l-4 ${getCardBorder(index)}`}>
                <div className="flex items-center gap-2 mb-2">
                  <span className="w-8 h-8 rounded-lg bg-gradient-to-br from-secondary-100 to-secondary-200 dark:from-secondary-900/30 dark:to-secondary-900/20 flex items-center justify-center">
                    <GraduationCap size={16} className="text-secondary-500" />
                  </span>
                  <span className="text-sm font-semibold bg-gradient-to-r from-secondary-500 to-primary-500 bg-clip-text text-transparent">{edu.degree}</span>
                </div>
                <h3 className="text-lg font-bold text-dark-900 dark:text-white ml-10">{edu.institution}</h3>
                {edu.field && (
                  <p className="mt-1 text-sm text-dark-500 dark:text-dark-400 ml-10">{edu.field}</p>
                )}
                <div className="flex items-center gap-2 mt-3 text-sm text-dark-400 ml-10">
                  <Calendar size={14} className="text-secondary-400" />
                  <span>{edu.start_year || "?"} — {edu.end_year || "?"}</span>
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </SectionWrapper>
  );
}
