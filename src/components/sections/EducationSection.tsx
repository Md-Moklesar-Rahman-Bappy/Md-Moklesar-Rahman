import { motion } from "framer-motion";
import { GraduationCap, Calendar } from "lucide-react";
import { Education } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";

interface EducationSectionProps {
  education?: Education[];
}

export function EducationSection({ education = fallbackData.education }: EducationSectionProps) {
  const visible = education.filter(e => e.is_visible).sort((a, b) => a.sort_order - b.sort_order);

  return (
    <SectionWrapper id="education" className="bg-dark-50/50 dark:bg-dark-900/50">
      <SectionHeader title="Education" subtitle="My academic background" />
      <div className="relative max-w-3xl mx-auto">
        <div className="absolute left-4 sm:left-6 top-0 bottom-0 w-px bg-dark-200 dark:bg-dark-700" />
        <div className="space-y-8">
          {visible.map((edu, index) => (
            <motion.div
              key={edu.id}
              initial={{ opacity: 0, x: -20 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true, margin: "-50px" }}
              transition={{ duration: 0.4, delay: index * 0.1 }}
              className="relative pl-10 sm:pl-14"
            >
              <div className="absolute left-2 sm:left-3.5 top-1 w-3 h-3 rounded-full bg-blue-400 border-2 border-white dark:border-dark-900 shadow" />
              <div className="p-5 rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700 hover:shadow-md transition-shadow">
                <div className="flex items-center gap-2 mb-1">
                  <GraduationCap size={16} className="text-blue-500" />
                  <span className="text-sm font-medium text-blue-500">{edu.degree}</span>
                </div>
                <h3 className="text-lg font-semibold text-dark-900 dark:text-white">{edu.institution}</h3>
                {edu.field && (
                  <p className="mt-1 text-sm text-dark-500 dark:text-dark-400">{edu.field}</p>
                )}
                <div className="flex items-center gap-2 mt-2 text-sm text-dark-400">
                  <Calendar size={14} />
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
