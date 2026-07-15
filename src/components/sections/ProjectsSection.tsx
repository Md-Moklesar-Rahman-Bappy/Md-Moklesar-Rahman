import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { ExternalLink, Github, X } from "lucide-react";
import { Project } from "@/types/database";
import { fallbackData } from "@/lib/fallback";
import { SectionWrapper, SectionHeader } from "@/components/ui/SectionWrapper";
import { EmptyState } from "@/components/ui/LoadingState";
import { getCategoryColor, getCategoryLabel } from "@/lib/utils";

interface ProjectsSectionProps {
  projects?: Project[];
}

export function ProjectsSection({ projects = fallbackData.projects }: ProjectsSectionProps) {
  const [activeFilter, setActiveFilter] = useState("all");
  const [selected, setSelected] = useState<Project | null>(null);

  const visibleProjects = projects.filter(p => p.is_visible).sort((a, b) => a.sort_order - b.sort_order);
  const categories = ["all", ...new Set(visibleProjects.map(p => p.category))];

  const filtered = activeFilter === "all"
    ? visibleProjects
    : visibleProjects.filter(p => p.category === activeFilter);

  if (visibleProjects.length === 0) {
    return (
      <SectionWrapper id="projects">
        <SectionHeader title="Projects" subtitle="Some of my recent work" />
        <EmptyState message="No projects to display yet. Check back soon!" />
      </SectionWrapper>
    );
  }

  return (
    <SectionWrapper id="projects" className="section-gradient-2">
      <SectionHeader title="Projects" subtitle="Some of my recent work" />

      {/* Filters */}
      <div className="flex flex-wrap items-center justify-center gap-2 mb-10">
        {categories.map((cat) => (
          <button
            key={cat}
            onClick={() => setActiveFilter(cat)}
            className={`px-5 py-2 text-sm font-medium rounded-full transition-all duration-300 ${
              activeFilter === cat
                ? "bg-gradient-to-r from-primary-500 to-accent-500 text-white shadow-lg shadow-primary-500/25"
                : "bg-white dark:bg-dark-800 text-dark-600 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-700 border border-dark-200 dark:border-dark-700 hover:border-primary-300 dark:hover:border-primary-700"
            }`}
          >
            {cat === "all" ? "All" : getCategoryLabel(cat)}
          </button>
        ))}
      </div>

      {/* Grid */}
      <motion.div layout className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <AnimatePresence mode="popLayout">
          {filtered.map((project, index) => (
            <motion.div
              key={project.id}
              layout
              initial={{ opacity: 0, scale: 0.9 }}
              animate={{ opacity: 1, scale: 1 }}
              exit={{ opacity: 0, scale: 0.9 }}
              transition={{ duration: 0.3, delay: index * 0.05 }}
              className="group cursor-pointer"
              onClick={() => setSelected(project)}
            >
              <div className="rounded-xl overflow-hidden bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div className="aspect-video bg-gradient-to-br from-primary-100 via-accent-50 to-secondary-100 dark:from-dark-700 dark:via-dark-800 dark:to-dark-700 flex items-center justify-center overflow-hidden relative">
                  {project.image_url ? (
                    <img
                      src={project.image_url}
                      alt={project.title}
                      className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                      loading="lazy"
                    />
                  ) : (
                    <span className="text-5xl opacity-30 animate-float">📁</span>
                  )}
                  <div className="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                </div>
                <div className="p-5">
                  <span className={`inline-block px-3 py-1 text-xs font-semibold rounded-full ${getCategoryColor(project.category)}`}>
                    {getCategoryLabel(project.category)}
                  </span>
                  <h3 className="mt-3 font-semibold text-dark-900 dark:text-white group-hover:text-primary-500 transition-colors duration-300">
                    {project.title}
                  </h3>
                  {project.short_description && (
                    <p className="mt-2 text-sm text-dark-500 dark:text-dark-400 line-clamp-2 leading-relaxed">
                      {project.short_description}
                    </p>
                  )}
                </div>
              </div>
            </motion.div>
          ))}
        </AnimatePresence>
      </motion.div>

      {/* Modal */}
      <AnimatePresence>
        {selected && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
            onClick={() => setSelected(null)}
          >
            <motion.div
              initial={{ opacity: 0, scale: 0.95, y: 20 }}
              animate={{ opacity: 1, scale: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.95, y: 20 }}
              className="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white dark:bg-dark-800 p-6 sm:p-8 shadow-2xl border border-dark-100 dark:border-dark-700"
              onClick={(e) => e.stopPropagation()}
            >
              <button
                onClick={() => setSelected(null)}
                className="absolute top-4 right-4 p-2 rounded-xl text-dark-400 hover:text-dark-600 dark:hover:text-dark-200 hover:bg-dark-100 dark:hover:bg-dark-700 transition-colors"
              >
                <X size={20} />
              </button>

              <div className="aspect-video rounded-xl bg-gradient-to-br from-primary-100 via-accent-50 to-secondary-100 dark:from-dark-700 dark:via-dark-800 dark:to-dark-700 flex items-center justify-center overflow-hidden mb-6">
                {selected.image_url ? (
                  <img src={selected.image_url} alt={selected.title} className="w-full h-full object-cover" />
                ) : (
                  <span className="text-6xl opacity-30">📁</span>
                )}
              </div>

              <span className={`inline-block px-3 py-1 text-xs font-semibold rounded-full ${getCategoryColor(selected.category)}`}>
                {getCategoryLabel(selected.category)}
              </span>

              <h2 className="mt-4 text-2xl font-bold gradient-text-primary">{selected.title}</h2>

              {selected.description && (
                <p className="mt-4 text-dark-600 dark:text-dark-300 leading-relaxed">{selected.description}</p>
              )}

              {selected.tech_stack && selected.tech_stack.length > 0 && (
                <div className="mt-6">
                  <h4 className="text-sm font-semibold text-dark-900 dark:text-white mb-3">Tech Stack</h4>
                  <div className="flex flex-wrap gap-2">
                    {selected.tech_stack.map((tech) => (
                      <span key={tech} className="px-3 py-1.5 text-xs font-medium rounded-full bg-gradient-to-r from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 text-primary-700 dark:text-primary-300 border border-primary-200/50 dark:border-primary-800/30">
                        {tech}
                      </span>
                    ))}
                  </div>
                </div>
              )}

              <div className="mt-8 flex flex-wrap gap-3">
                {selected.live_url && (
                  <a
                    href={selected.live_url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn-gradient"
                  >
                    <ExternalLink size={14} /> Live Preview
                  </a>
                )}
                {selected.github_url && (
                  <a
                    href={selected.github_url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-2 px-6 py-3 font-medium rounded-full bg-dark-100 dark:bg-dark-700 text-dark-700 dark:text-dark-200 hover:bg-dark-200 dark:hover:bg-dark-600 transition-all duration-300 hover:shadow-lg border border-dark-200 dark:border-dark-600"
                  >
                    <Github size={14} /> View Code
                  </a>
                )}
              </div>
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>
    </SectionWrapper>
  );
}
