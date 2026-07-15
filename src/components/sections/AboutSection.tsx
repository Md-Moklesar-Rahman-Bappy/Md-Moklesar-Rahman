import { motion } from "framer-motion";
import { About } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper } from "@/components/ui/SectionWrapper";

interface AboutSectionProps {
  about?: About;
}

export function AboutSection({ about = fallbackData.about }: AboutSectionProps) {
  return (
    <SectionWrapper id="about" className="section-gradient-2">
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <motion.div
          initial={{ opacity: 0, x: -30 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.6 }}
        >
          <div className="relative">
            <div className="aspect-[4/3] rounded-2xl bg-gradient-to-br from-primary-100 via-accent-50 to-secondary-100 dark:from-primary-900/20 dark:via-accent-900/10 dark:to-secondary-900/20 flex items-center justify-center overflow-hidden relative">
              <div className="absolute inset-0 bg-gradient-to-br from-primary-400/10 to-accent-400/10" />
              <div className="text-7xl sm:text-8xl relative z-10 animate-float">👨‍💻</div>
            </div>
            <div className="absolute -bottom-4 -right-4 w-24 h-24 rounded-2xl bg-gradient-to-br from-accent-400 to-highlight-400 opacity-20 -z-10" />
            <div className="absolute -top-4 -left-4 w-20 h-20 rounded-2xl bg-gradient-to-br from-primary-400 to-secondary-400 opacity-20 -z-10" />
          </div>
        </motion.div>

        <motion.div
          initial={{ opacity: 0, x: 30 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.6, delay: 0.1 }}
        >
          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight gradient-text-primary">
            {about.heading}
          </h2>
          <div className="mt-3 flex gap-2">
            <span className="w-12 h-1 rounded-full bg-gradient-to-r from-primary-400 to-accent-400" />
            <span className="w-3 h-1 rounded-full bg-highlight-400" />
          </div>
          <p className="mt-6 text-lg text-dark-600 dark:text-dark-300 leading-relaxed">
            {about.content}
          </p>

          {about.years_experience > 0 && (
            <div className="mt-8 grid grid-cols-2 gap-4">
              <div className="p-5 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100/50 dark:from-primary-900/20 dark:to-primary-900/10 border border-primary-200/50 dark:border-primary-800/30 hover:shadow-lg hover:shadow-primary-200/20 dark:hover:shadow-primary-900/20 transition-all duration-300">
                <div className="text-3xl font-bold bg-gradient-to-r from-primary-500 to-primary-700 bg-clip-text text-transparent">{about.years_experience}+</div>
                <div className="text-sm text-dark-500 dark:text-dark-400 mt-1">Years Experience</div>
              </div>
              <div className="p-5 rounded-xl bg-gradient-to-br from-accent-50 to-accent-100/50 dark:from-accent-900/20 dark:to-accent-900/10 border border-accent-200/50 dark:border-accent-800/30 hover:shadow-lg hover:shadow-accent-200/20 dark:hover:shadow-accent-900/20 transition-all duration-300">
                <div className="text-3xl font-bold bg-gradient-to-r from-accent-500 to-highlight-500 bg-clip-text text-transparent">50+</div>
                <div className="text-sm text-dark-500 dark:text-dark-400 mt-1">Projects Done</div>
              </div>
            </div>
          )}
        </motion.div>
      </div>
    </SectionWrapper>
  );
}
