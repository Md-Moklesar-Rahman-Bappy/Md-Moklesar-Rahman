import { motion } from "framer-motion";
import { About } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper } from "@/components/ui/SectionWrapper";

interface AboutSectionProps {
  about?: About;
}

export function AboutSection({ about = fallbackData.about }: AboutSectionProps) {
  return (
    <SectionWrapper id="about">
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <motion.div
          initial={{ opacity: 0, x: -30 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.6 }}
        >
          <div className="aspect-[4/3] rounded-2xl bg-gradient-to-br from-primary-100 to-primary-50 dark:from-primary-900/20 dark:to-dark-800 flex items-center justify-center overflow-hidden">
            <div className="text-6xl sm:text-8xl text-primary-300 dark:text-primary-700">👨‍💻</div>
          </div>
        </motion.div>

        <motion.div
          initial={{ opacity: 0, x: 30 }}
          whileInView={{ opacity: 1, x: 0 }}
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.6, delay: 0.1 }}
        >
          <h2 className="text-3xl sm:text-4xl font-bold text-dark-900 dark:text-white tracking-tight">
            {about.heading}
          </h2>
          <div className="mt-2 w-16 h-1 bg-primary-400 rounded-full" />
          <p className="mt-6 text-lg text-dark-600 dark:text-dark-300 leading-relaxed">
            {about.content}
          </p>

          {about.years_experience > 0 && (
            <div className="mt-8 grid grid-cols-2 gap-4">
              <div className="p-4 rounded-xl bg-primary-50 dark:bg-primary-900/20 border border-primary-100 dark:border-primary-900/30">
                <div className="text-2xl font-bold text-primary-500">{about.years_experience}+</div>
                <div className="text-sm text-dark-500 dark:text-dark-400">Years Experience</div>
              </div>
              <div className="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900/30">
                <div className="text-2xl font-bold text-blue-500">50+</div>
                <div className="text-sm text-dark-500 dark:text-dark-400">Projects Done</div>
              </div>
            </div>
          )}
        </motion.div>
      </div>
    </SectionWrapper>
  );
}
