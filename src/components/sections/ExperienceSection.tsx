import { motion } from "framer-motion";
import { Calendar } from "lucide-react";
import { Experience } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";
import { formatDate } from "@/lib/utils";

interface ExperienceSectionProps {
  experience?: Experience[];
}

function getDotColor(index: number) {
  const colors = [
    "bg-gradient-to-br from-primary-400 to-primary-600 shadow-primary-300/30",
    "bg-gradient-to-br from-accent-400 to-accent-600 shadow-accent-300/30",
    "bg-gradient-to-br from-secondary-400 to-secondary-600 shadow-secondary-300/30",
    "bg-gradient-to-br from-highlight-400 to-highlight-600 shadow-highlight-300/30",
    "bg-gradient-to-br from-primary-400 to-accent-500 shadow-primary-300/30",
  ];
  return colors[index % colors.length];
}

function getCardBorder(index: number) {
  const colors = [
    "border-l-primary-400",
    "border-l-accent-400",
    "border-l-secondary-400",
    "border-l-highlight-400",
    "border-l-primary-400",
  ];
  return colors[index % colors.length];
}

export function ExperienceSection({ experience = fallbackData.experience }: ExperienceSectionProps) {
  const visible = experience.filter(e => e.is_visible).sort((a, b) => a.sort_order - b.sort_order);

  return (
    <SectionWrapper id="experience">
      <SectionHeader title="Experience" subtitle="My professional journey" />
      <div className="relative max-w-3xl mx-auto">
        <div className="absolute left-5 sm:left-7 top-0 bottom-0 w-px bg-gradient-to-b from-primary-200 via-accent-200 to-secondary-200 dark:from-primary-800 dark:via-accent-800 dark:to-secondary-800" />
        <div className="space-y-10">
          {visible.map((exp, index) => (
            <motion.div
              key={exp.id}
              initial={{ opacity: 0, x: -20 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true, margin: "-50px" }}
              transition={{ duration: 0.4, delay: index * 0.1 }}
              className="relative pl-14 sm:pl-16"
            >
              <div className={`absolute left-3 sm:left-4.5 top-1.5 w-4 h-4 rounded-full ${getDotColor(index)} border-2 border-white dark:border-dark-900 shadow-lg animate-pulse-slow`} />
              <div className={`p-6 rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 border-l-4 ${getCardBorder(index)}`}>
                <div className="flex flex-wrap items-center gap-2 mb-2">
                  <span className="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-primary-100 to-accent-100 dark:from-primary-900/30 dark:to-accent-900/30 text-primary-600 dark:text-primary-400">
                    {exp.position}
                  </span>
                  {exp.is_current && (
                    <span className="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-secondary-100 to-secondary-200 dark:from-secondary-900/30 dark:to-secondary-900/20 text-secondary-600 dark:text-secondary-400">
                      Current
                    </span>
                  )}
                </div>
                <h3 className="text-lg font-bold text-dark-900 dark:text-white">{exp.company}</h3>
                {exp.location && (
                  <p className="mt-1 text-sm text-dark-400 dark:text-dark-500">{exp.location}</p>
                )}
                <div className="flex items-center gap-2 mt-3 text-sm text-dark-500 dark:text-dark-400">
                  <Calendar size={14} className="text-primary-400" />
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
