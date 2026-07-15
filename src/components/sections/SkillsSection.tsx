import { motion } from "framer-motion";
import { Skill } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";

interface SkillsSectionProps {
  skills?: Skill[];
}

export function SkillsSection({ skills = fallbackData.skills }: SkillsSectionProps) {
  const visibleSkills = skills.filter(s => s.is_visible).sort((a, b) => a.sort_order - b.sort_order);

  return (
    <SectionWrapper id="skills" className="bg-dark-50/50 dark:bg-dark-900/50">
      <SectionHeader title="Skills" subtitle="Technologies and tools I work with" />
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {visibleSkills.map((skill, index) => (
          <motion.div
            key={skill.id}
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: "-50px" }}
            transition={{ duration: 0.4, delay: index * 0.05 }}
            className="p-4 rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700"
          >
            <div className="flex items-center justify-between mb-2">
              <span className="font-medium text-dark-900 dark:text-white">{skill.name}</span>
              <span className="text-sm font-medium text-primary-500">{skill.level}%</span>
            </div>
            <div className="w-full h-2 bg-dark-100 dark:bg-dark-700 rounded-full overflow-hidden">
              <motion.div
                initial={{ width: 0 }}
                whileInView={{ width: `${skill.level}%` }}
                viewport={{ once: true }}
                transition={{ duration: 0.8, delay: 0.2 + index * 0.05 }}
                className="h-full bg-gradient-to-r from-primary-400 to-primary-500 rounded-full"
              />
            </div>
          </motion.div>
        ))}
      </div>
    </SectionWrapper>
  );
}
