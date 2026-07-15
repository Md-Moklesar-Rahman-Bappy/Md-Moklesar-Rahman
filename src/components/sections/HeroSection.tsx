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
      <div className="absolute inset-0 bg-gradient-to-br from-primary-50 via-white to-yellow-50 dark:from-dark-950 dark:via-dark-900 dark:to-dark-800" />
      <div className="absolute inset-0 opacity-5 dark:opacity-10" style={{
        backgroundImage: `radial-gradient(circle at 25px 25px, currentColor 1px, transparent 0)`,
        backgroundSize: "50px 50px",
      }} />

      <div className="relative section-container text-center py-20">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
        >
          <p className="text-lg text-primary-500 font-medium mb-3">Hello, I'm</p>
          <h1 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-dark-900 dark:text-white tracking-tight mb-4">
            {hero.title}
          </h1>
          <h2 className="text-xl sm:text-2xl text-dark-600 dark:text-dark-300 mb-2">
            {displayText}
            <span className="inline-block w-[2px] h-6 bg-primary-500 ml-1 animate-pulse" />
          </h2>
          {hero.description && (
            <p className="mt-6 text-lg text-dark-500 dark:text-dark-400 max-w-2xl mx-auto leading-relaxed">
              {hero.description}
            </p>
          )}

          <div className="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a
              href="#contact"
              className="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-full hover:bg-primary-600 transition-colors shadow-lg shadow-primary-500/25"
            >
              Hire Me
            </a>
            {hero.cta_secondary_url && (
              <a
                href={hero.cta_secondary_url}
                download
                className="inline-flex items-center gap-2 px-6 py-3 border-2 border-dark-300 dark:border-dark-600 text-dark-700 dark:text-dark-200 font-medium rounded-full hover:bg-dark-50 dark:hover:bg-dark-800 transition-colors"
              >
                <Download size={16} />
                Download CV
              </a>
            )}
          </div>
        </motion.div>
      </div>

      <a
        href="#about"
        onClick={(e) => {
          e.preventDefault();
          document.querySelector("#about")?.scrollIntoView({ behavior: "smooth" });
        }}
        className="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-dark-400 dark:text-dark-500 hover:text-primary-500 transition-colors"
      >
        <span className="text-xs font-medium tracking-wider uppercase">Scroll</span>
        <ArrowDown size={16} className="animate-bounce" />
      </a>
    </section>
  );
}
