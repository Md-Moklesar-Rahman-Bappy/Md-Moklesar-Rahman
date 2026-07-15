import { motion } from "framer-motion";
import { Paintbrush, Monitor, Code, Layout } from "lucide-react";
import { Service } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";
import { getCategoryColor, getCategoryLabel } from "@/lib/utils";

interface ServicesSectionProps {
  services?: Service[];
}

const iconMap: Record<string, React.ComponentType<{ size?: number; className?: string }>> = {
  palette: Paintbrush,
  monitor: Monitor,
  code: Code,
  layout: Layout,
};

function getServiceGradient(index: number) {
  const gradients = [
    "from-primary-100 to-primary-50 dark:from-primary-900/30 dark:to-primary-900/10 group-hover:from-primary-500 group-hover:to-primary-600",
    "from-accent-100 to-accent-50 dark:from-accent-900/30 dark:to-accent-900/10 group-hover:from-accent-500 group-hover:to-accent-600",
    "from-secondary-100 to-secondary-50 dark:from-secondary-900/30 dark:to-secondary-900/10 group-hover:from-secondary-500 group-hover:to-secondary-600",
    "from-highlight-100 to-highlight-50 dark:from-highlight-900/30 dark:to-highlight-900/10 group-hover:from-highlight-500 group-hover:to-highlight-600",
    "from-primary-100 to-accent-50 dark:from-primary-900/30 dark:to-accent-900/10 group-hover:from-primary-500 group-hover:to-accent-600",
  ];
  return gradients[index % gradients.length];
}

function getIconColor(index: number) {
  const colors = [
    "text-primary-500 group-hover:text-white",
    "text-accent-500 group-hover:text-white",
    "text-secondary-500 group-hover:text-white",
    "text-highlight-500 group-hover:text-white",
    "text-primary-500 group-hover:text-white",
  ];
  return colors[index % colors.length];
}

function getBorderColor(index: number) {
  const colors = [
    "border-primary-200/50 dark:border-primary-800/30 hover:border-primary-300 dark:hover:border-primary-700",
    "border-accent-200/50 dark:border-accent-800/30 hover:border-accent-300 dark:hover:border-accent-700",
    "border-secondary-200/50 dark:border-secondary-800/30 hover:border-secondary-300 dark:hover:border-secondary-700",
    "border-highlight-200/50 dark:border-highlight-800/30 hover:border-highlight-300 dark:hover:border-highlight-700",
    "border-primary-200/50 dark:border-primary-800/30 hover:border-accent-300 dark:hover:border-accent-700",
  ];
  return colors[index % colors.length];
}

function getCategoryTagColor(index: number) {
  const colors = [
    "bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400",
    "bg-accent-100 text-accent-700 dark:bg-accent-900/30 dark:text-accent-400",
    "bg-secondary-100 text-secondary-700 dark:bg-secondary-900/30 dark:text-secondary-400",
    "bg-highlight-100 text-highlight-700 dark:bg-highlight-900/30 dark:text-highlight-400",
  ];
  return colors[index % colors.length];
}

export function ServicesSection({ services = fallbackData.services }: ServicesSectionProps) {
  const visibleServices = services.filter(s => s.is_visible).sort((a, b) => a.title.localeCompare(b.title));

  return (
    <SectionWrapper id="services">
      <SectionHeader title="Services" subtitle="What I can do for you" />
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {visibleServices.map((service, index) => {
          const Icon = iconMap[service.icon] || Code;
          return (
            <motion.div
              key={service.id}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true, margin: "-50px" }}
              transition={{ duration: 0.4, delay: index * 0.1 }}
              className={`group p-6 rounded-xl bg-white dark:bg-dark-800 border ${getBorderColor(index)} transition-all duration-300 hover:shadow-xl hover:-translate-y-2 relative overflow-hidden`}
            >
              <div className={`absolute inset-0 bg-gradient-to-br opacity-0 group-hover:opacity-100 transition-opacity duration-300 ${getServiceGradient(index)}`} />
              <div className="relative z-10">
                <div className={`w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br ${getServiceGradient(index)} transition-all duration-300 mb-4 shadow-sm`}>
                  <Icon size={24} className={`transition-colors duration-300 ${getIconColor(index)}`} />
                </div>
                <h3 className="text-lg font-semibold text-dark-900 dark:text-white group-hover:text-white transition-colors duration-300 mb-2">
                  {service.title}
                </h3>
                {service.category && (
                  <span className={`inline-block px-2 py-0.5 text-[10px] font-semibold rounded-full ${getCategoryTagColor(index)} group-hover:bg-white/20 group-hover:text-white transition-colors duration-300 mb-2`}>
                    {getCategoryLabel(service.category)}
                  </span>
                )}
                <p className="text-sm text-dark-500 dark:text-dark-400 group-hover:text-white/80 leading-relaxed transition-colors duration-300">
                  {service.description}
                </p>
              </div>
            </motion.div>
          );
        })}
      </div>
    </SectionWrapper>
  );
}
