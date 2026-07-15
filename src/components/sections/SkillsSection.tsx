import { motion } from "framer-motion";
import { Skill } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";

interface SkillsSectionProps {
  skills?: Skill[];
}

function getSkillColor(index: number) {
  const colors = [
    "from-primary-400 to-primary-600",
    "from-accent-400 to-accent-600",
    "from-secondary-400 to-secondary-600",
    "from-highlight-400 to-highlight-600",
    "from-primary-500 to-accent-500",
    "from-secondary-500 to-highlight-500",
    "from-accent-500 to-highlight-500",
    "from-primary-400 to-secondary-400",
  ];
  return colors[index % colors.length];
}

function getSkillBg(index: number) {
  const colors = [
    "bg-primary-50 dark:bg-primary-900/20 border-primary-200/50 dark:border-primary-800/30",
    "bg-accent-50 dark:bg-accent-900/20 border-accent-200/50 dark:border-accent-800/30",
    "bg-secondary-50 dark:bg-secondary-900/20 border-secondary-200/50 dark:border-secondary-800/30",
    "bg-highlight-50 dark:bg-highlight-900/20 border-highlight-200/50 dark:border-highlight-800/30",
    "bg-primary-50 dark:bg-primary-900/20 border-primary-200/50 dark:border-primary-800/30",
    "bg-secondary-50 dark:bg-secondary-900/20 border-secondary-200/50 dark:border-secondary-800/30",
    "bg-accent-50 dark:bg-accent-900/20 border-accent-200/50 dark:border-accent-800/30",
    "bg-primary-50 dark:bg-primary-900/20 border-primary-200/50 dark:border-primary-800/30",
  ];
  return colors[index % colors.length];
}

export function SkillsSection({ skills = fallbackData.skills }: SkillsSectionProps) {
  const visibleSkills = skills.filter(s => s.is_visible).sort((a, b) => a.sort_order - b.sort_order);

  return (
    <SectionWrapper id="skills" className="section-gradient-3">
      <SectionHeader title="Skills" subtitle="Technologies and tools I work with" />
      <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
        {visibleSkills.map((skill, index) => (
          <motion.div
            key={skill.id}
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: "-50px" }}
            transition={{ duration: 0.4, delay: index * 0.05 }}
            className={`p-5 rounded-xl border ${getSkillBg(index)} hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5`}
          >
            <div className="flex items-center justify-between mb-3">
              <span className="font-semibold text-dark-900 dark:text-white">{skill.name}</span>
              <span className={`text-sm font-bold bg-gradient-to-r ${getSkillColor(index)} bg-clip-text text-transparent`}>{skill.level}%</span>
            </div>
            <div className="w-full h-2.5 bg-dark-100 dark:bg-dark-700/50 rounded-full overflow-hidden">
              <motion.div
                initial={{ width: 0 }}
                whileInView={{ width: `${skill.level}%` }}
                viewport={{ once: true }}
                transition={{ duration: 0.8, delay: 0.2 + index * 0.05, ease: "easeOut" }}
                className={`h-full rounded-full bg-gradient-to-r ${getSkillColor(index)} relative overflow-hidden`}
              >
                <div className="absolute inset-0 bg-white/20 animate-shimmer" />
              </motion.div>
            </div>
          </motion.div>
        ))}
      </div>
    </SectionWrapper>
  );
}
