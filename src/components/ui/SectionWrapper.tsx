import { ReactNode } from "react";
import { cn } from "@/lib/utils";

interface SectionWrapperProps {
  id?: string;
  className?: string;
  children: ReactNode;
}

export function SectionWrapper({ id, className, children }: SectionWrapperProps) {
  const isAlternate = className?.includes("bg-");
  return (
    <section id={id} className={cn("section-padding relative overflow-hidden", className || "section-gradient-1")}>
      {!isAlternate && (
        <>
          <div className="blob-decoration w-72 h-72 bg-primary-300 dark:bg-primary-700 -top-32 -right-32 animate-blob" />
          <div className="blob-decoration w-96 h-96 bg-accent-300 dark:bg-accent-700 -bottom-48 -left-48 animate-blob" style={{ animationDelay: "2s" }} />
        </>
      )}
      <div className="section-container relative z-10">{children}</div>
    </section>
  );
}

interface SectionHeaderProps {
  title: string;
  subtitle?: string;
}

export function SectionHeader({ title, subtitle }: SectionHeaderProps) {
  return (
    <div className="text-center mb-12 sm:mb-16">
      <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight gradient-text">
        {title}
      </h2>
      {subtitle && (
        <p className="mt-4 text-lg text-dark-500 dark:text-dark-400 max-w-2xl mx-auto leading-relaxed">
          {subtitle}
        </p>
      )}
      <div className="mt-5 mx-auto flex items-center justify-center gap-2">
        <span className="w-12 h-1 rounded-full bg-gradient-to-r from-primary-400 to-accent-400" />
        <span className="w-3 h-1 rounded-full bg-highlight-400" />
        <span className="w-12 h-1 rounded-full bg-gradient-to-r from-accent-400 to-primary-400" />
      </div>
    </div>
  );
}
