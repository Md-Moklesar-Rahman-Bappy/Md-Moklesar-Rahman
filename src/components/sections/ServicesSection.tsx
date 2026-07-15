import { motion } from "framer-motion";
import { Paintbrush, Monitor, Code, Layout } from "lucide-react";
import { Service } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";

interface ServicesSectionProps {
  services?: Service[];
}

const iconMap: Record<string, React.ComponentType<{ size?: number; className?: string }>> = {
  palette: Paintbrush,
  monitor: Monitor,
  code: Code,
  layout: Layout,
};

export function ServicesSection({ services = fallbackData.services }: ServicesSectionProps) {
  const visibleServices = services.filter(s => s.is_visible).sort((a, b) => a.sort_order - b.sort_order);

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
              className="group p-6 rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700 hover:border-primary-300 dark:hover:border-primary-700 transition-all hover:shadow-lg hover:-translate-y-1"
            >
              <div className="w-12 h-12 flex items-center justify-center rounded-lg bg-primary-50 dark:bg-primary-900/20 text-primary-500 group-hover:bg-primary-500 group-hover:text-white transition-all mb-4">
                <Icon size={24} />
              </div>
              <h3 className="text-lg font-semibold text-dark-900 dark:text-white mb-2">
                {service.title}
              </h3>
              <p className="text-sm text-dark-500 dark:text-dark-400 leading-relaxed">
                {service.description}
              </p>
            </motion.div>
          );
        })}
      </div>
    </SectionWrapper>
  );
}
