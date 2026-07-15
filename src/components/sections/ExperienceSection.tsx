import { motion } from "framer-motion";
import { Briefcase, Calendar } from "lucide-react";
import { Experience } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";
import { formatDate, cn } from "@/lib/utils";

interface ExperienceSectionProps {
  experience?: Experience[];
}

export function ExperienceSection({ experience = fallbackData.experience }: ExperienceSectionProps) {
  const visible = experience.filter(e => e.is_visible).sort((a, b) => a.sort_order - b.sort_order);

  return (
    <SectionWrapper id="experience">
      <SectionHeader title="Experience" subtitle="My professional journey" />
      <div className="relative max-w-3xl mx-auto">
        <div className="absolute left-4 sm:left-6 top-0 bottom-0 w-px bg-dark-200 dark:bg-dark-700" />
        <div className="space-y-8">
          {visible.map((exp, index) => (
            <motion.div
              key={exp.id}
              initial={{ opacity: 0, x: -20 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true, margin: "-50px" }}
              transition={{ duration: 0.4, delay: index * 0.1 }}
              className="relative pl-10 sm:pl-14"
            >
              <div className="absolute left-2 sm:left-3.5 top-1 w-3 h-3 rounded-full bg-primary-400 border-2 border-white dark:border-dark-900 shadow" />
              <div className="p-5 rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700 hover:shadow-md transition-shadow">
                <div className="flex flex-wrap items-center gap-2 mb-2">
                  <span className="text-xs font-medium text-primary-500 bg-primary-50 dark:bg-primary-900/20 px-2 py-0.5 rounded-full">
                    {exp.position}
                  </span>
                  {exp.is_current && (
                    <span className="text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 dark:text-green-400 px-2 py-0.5 rounded-full">
                      Current
                    </span>
                  )}
                </div>
                <h3 className="text-lg font-semibold text-dark-900 dark:text-white">{exp.company}</h3>
                {exp.location && (
                  <p className="mt-1 text-sm text-dark-400 dark:text-dark-500">{exp.location}</p>
                )}
                <div className="flex items-center gap-2 mt-2 text-sm text-dark-500 dark:text-dark-400">
                  <Calendar size={14} />
                  <span>
                    {exp.start_date ? formatDate(exp.start_date) : "Start"} — {exp.is_current ? "Present" : exp.end_date ? formatDate(exp.end_date) : "End"}
                  </span>
                </div>
                {exp.description && (
                  <p className="mt-3 text-sm text-dark-600 dark:text-dark-300 leading-relaxed">{exp.description}</p>
                )}
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </SectionWrapper>
  );
}
