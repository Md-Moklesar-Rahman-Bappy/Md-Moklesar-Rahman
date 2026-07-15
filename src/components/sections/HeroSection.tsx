import { useState, useEffect } from "react";
import { ArrowDown, Download } from "lucide-react";
import { motion } from "framer-motion";
import { Hero } from "@/types/database";
import { fallbackData } from "@/lib/fallback";

interface HeroSectionProps {
  hero?: Hero;
}

const roles = ["Web Designer", "Web Developer", "WordPress Developer", "Graphics Designer"];

export function HeroSection({ hero = fallbackData.hero }: HeroSectionProps) {
  const [roleIndex, setRoleIndex] = useState(0);
  const [displayText, setDisplayText] = useState("");
  const [isDeleting, setIsDeleting] = useState(false);

  useEffect(() => {
    const currentRole = roles[roleIndex];
    let timeout: ReturnType<typeof setTimeout>;

    if (!isDeleting && displayText === currentRole) {
      timeout = setTimeout(() => setIsDeleting(true), 1500);
    } else if (!isDeleting) {
      timeout = setTimeout(() => {
        setDisplayText(currentRole.slice(0, displayText.length + 1));
      }, 80);
    } else if (displayText === "") {
      setIsDeleting(false);
      setRoleIndex((i) => (i + 1) % roles.length);
    } else {
      timeout = setTimeout(() => {
        setDisplayText(displayText.slice(0, -1));
      }, 30);
    }

    return () => clearTimeout(timeout);
  }, [displayText, isDeleting, roleIndex]);

  return (
    <section
      id="home"
      className="relative min-h-screen flex items-center justify-center overflow-hidden"
    >
      <div className="absolute inset-0 bg-gradient-to-br from-primary-50 via-white to-accent-50 dark:from-dark-950 dark:via-dark-900 dark:to-dark-950" />

      {/* Decorative blobs */}
      <div className="blob-decoration w-[500px] h-[500px] bg-gradient-to-br from-primary-300/30 to-primary-500/10 -top-48 -right-48 animate-blob" />
      <div className="blob-decoration w-[400px] h-[400px] bg-gradient-to-br from-accent-300/20 to-accent-500/10 -bottom-32 -left-32 animate-blob" style={{ animationDelay: "3s" }} />
      <div className="blob-decoration w-[300px] h-[300px] bg-gradient-to-br from-highlight-300/20 to-highlight-500/10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-blob" style={{ animationDelay: "6s" }} />

      {/* Dot pattern overlay */}
      <div className="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style={{
        backgroundImage: `radial-gradient(circle at 20px 20px, currentColor 1px, transparent 0)`,
        backgroundSize: "40px 40px",
      }} />

      <div className="relative section-container text-center py-20">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
        >
          {hero.profile_image_url && (
            <motion.div
              initial={{ opacity: 0, scale: 0.8 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ delay: 0.1 }}
              className="mb-6 flex justify-center"
            >
              <div className="w-28 h-28 sm:w-36 sm:h-36 rounded-full overflow-hidden border-4 border-white/50 dark:border-dark-800/50 shadow-xl shadow-primary-500/20 ring-2 ring-primary-200 dark:ring-primary-800">
                <img src={hero.profile_image_url} alt={hero.title}
                  className="w-full h-full object-cover" />
              </div>
            </motion.div>
          )}

          <motion.p
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.2 }}
            className="text-lg font-medium mb-4"
          >
            <span className="inline-block px-4 py-1.5 rounded-full bg-gradient-to-r from-primary-100 to-accent-100 dark:from-primary-900/30 dark:to-accent-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold shadow-sm">
              Hello, I'm
            </span>
          </motion.p>

          <motion.h1
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.3 }}
            className="text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight mb-6"
          >
            <span className="gradient-text">{hero.title}</span>
          </motion.h1>

          <motion.h2
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-xl sm:text-2xl lg:text-3xl text-dark-600 dark:text-dark-300 font-light mb-2"
          >
            {displayText}
            <span className="inline-block w-[3px] h-7 bg-gradient-to-b from-primary-500 to-accent-500 ml-1 animate-pulse rounded-full" />
          </motion.h2>

          {hero.description && (
            <motion.p
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.5 }}
              className="mt-6 text-lg text-dark-500 dark:text-dark-400 max-w-2xl mx-auto leading-relaxed"
            >
              {hero.description}
            </motion.p>
          )}

          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.6 }}
            className="mt-10 flex flex-wrap items-center justify-center gap-4"
          >
            <a
              href="#contact"
              className="btn-gradient shadow-xl shadow-primary-500/20 dark:shadow-primary-500/10"
            >
              Hire Me
            </a>
            {hero.cta_secondary_url && (
              <a
                href={hero.cta_secondary_url}
                download
                className="group inline-flex items-center gap-2 px-6 py-3 font-medium rounded-full border-2 border-dark-300 dark:border-dark-600 text-dark-700 dark:text-dark-200 hover:border-primary-400 hover:text-primary-500 dark:hover:border-primary-400 dark:hover:text-primary-400 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
              >
                <Download size={16} className="group-hover:animate-bounce" />
                Download CV
              </a>
            )}
          </motion.div>
        </motion.div>
      </div>

      <a
        href="#about"
        onClick={(e) => {
          e.preventDefault();
          document.querySelector("#about")?.scrollIntoView({ behavior: "smooth" });
        }}
        className="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-dark-400 dark:text-dark-500 hover:text-primary-500 transition-colors group"
      >
        <span className="text-xs font-medium tracking-[0.2em] uppercase">Scroll</span>
        <ArrowDown size={16} className="animate-bounce group-hover:text-accent-500 transition-colors" />
      </a>
    </section>
  );
}
