import { motion } from "framer-motion";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { fab } from "@fortawesome/free-brands-svg-icons";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { Skill } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";

interface SkillsSectionProps {
  skills?: Skill[];
}

function getSkillGradient(index: number) {
  const gradients = [
    "from-primary-500 to-accent-500",
    "from-accent-500 to-highlight-500",
    "from-secondary-500 to-primary-500",
    "from-highlight-500 to-secondary-500",
    "from-primary-500 to-secondary-500",
    "from-accent-500 to-primary-500",
  ];
  return gradients[index % gradients.length];
}

function getSkillBg(index: number) {
  const colors = [
    "bg-primary-50 dark:bg-primary-900/20 border-primary-200/50 dark:border-primary-800/30 hover:shadow-primary-200/50 dark:hover:shadow-primary-900/30",
    "bg-accent-50 dark:bg-accent-900/20 border-accent-200/50 dark:border-accent-800/30 hover:shadow-accent-200/50 dark:hover:shadow-accent-900/30",
    "bg-secondary-50 dark:bg-secondary-900/20 border-secondary-200/50 dark:border-secondary-800/30 hover:shadow-secondary-200/50 dark:hover:shadow-secondary-900/30",
    "bg-highlight-50 dark:bg-highlight-900/20 border-highlight-200/50 dark:border-highlight-800/30 hover:shadow-highlight-200/50 dark:hover:shadow-highlight-900/30",
    "bg-primary-50 dark:bg-primary-900/20 border-primary-200/50 dark:border-primary-800/30 hover:shadow-primary-200/50 dark:hover:shadow-primary-900/30",
    "bg-accent-50 dark:bg-accent-900/20 border-accent-200/50 dark:border-accent-800/30 hover:shadow-accent-200/50 dark:hover:shadow-accent-900/30",
  ];
  return colors[index % colors.length];
}

function parseIcon(icon: string | null) {
  if (!icon) return null;
  const [prefix, name] = icon.split(" ");
  const iconName = name?.replace("fa-", "") || "";
  if (prefix === "fa-brands") {
    const iconKey = Object.keys(fab).find(k => k.toLowerCase() === `fa${iconName}` || k.toLowerCase() === iconName);
    return iconKey ? fab[iconKey as keyof typeof fab] : null;
  }
  const iconKey = Object.keys(fas).find(k => k.toLowerCase() === `fa${iconName}` || k.toLowerCase() === iconName);
  return iconKey ? fas[iconKey as keyof typeof fas] : null;
}

export function SkillsSection({ skills = fallbackData.skills }: SkillsSectionProps) {
  const visibleSkills = skills.filter(s => s.is_visible).sort((a, b) => a.sort_order - b.sort_order);

  return (
    <SectionWrapper id="skills" className="section-gradient-3">
      <SectionHeader title="Skills" subtitle="Technologies and tools I work with" />
      <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        {visibleSkills.map((skill, index) => {
          const iconDef = parseIcon(skill.icon);
          return (
            <motion.div
              key={skill.id}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true, margin: "-50px" }}
              transition={{ duration: 0.4, delay: index * 0.05 }}
              className={`group relative p-5 rounded-xl border ${getSkillBg(index)} hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-center`}
            >
              <div className={`w-14 h-14 mx-auto mb-3 rounded-xl bg-gradient-to-br ${getSkillGradient(index)} flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300`}>
                {iconDef ? (
                  <FontAwesomeIcon icon={iconDef} className="text-white text-xl" />
                ) : (
                  <span className="text-white text-lg font-bold">{skill.name.charAt(0)}</span>
                )}
              </div>
              <h3 className="font-semibold text-sm text-dark-900 dark:text-white group-hover:text-primary-500 dark:group-hover:text-primary-400 transition-colors">
                {skill.name}
              </h3>
              <div className="mt-2 w-full h-1.5 bg-dark-100 dark:bg-dark-700/50 rounded-full overflow-hidden">
                <motion.div
                  initial={{ width: 0 }}
                  whileInView={{ width: `${skill.level}%` }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.8, delay: 0.2 + index * 0.05, ease: "easeOut" }}
                  className={`h-full rounded-full bg-gradient-to-r ${getSkillGradient(index)}`}
                />
              </div>
              <span className="mt-1 block text-[10px] font-medium text-dark-400 dark:text-dark-500">{skill.level}%</span>
            </motion.div>
          );
        })}
      </div>
    </SectionWrapper>
  );
}
