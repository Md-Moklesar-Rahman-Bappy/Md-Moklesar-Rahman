import { Sun, Moon } from "lucide-react";
import { useTheme } from "@/hooks/useTheme";
import { cn } from "@/lib/utils";

interface ThemeToggleProps {
  className?: string;
}

export function ThemeToggle({ className }: ThemeToggleProps) {
  const { theme, toggleTheme } = useTheme();

  return (
    <button
      onClick={toggleTheme}
      className={cn(
        "p-2 rounded-xl transition-all duration-300",
        "text-dark-600 dark:text-dark-400",
        "hover:bg-dark-100 dark:hover:bg-dark-700",
        "hover:text-primary-500 dark:hover:text-primary-400",
        "focus:outline-none focus:ring-2 focus:ring-primary-400/50",
        "bg-white/50 dark:bg-dark-800/50 backdrop-blur-sm",
        "border border-dark-200/50 dark:border-dark-700/50",
        "shadow-sm hover:shadow-md",
        className
      )}
      aria-label={`Switch to ${theme === "light" ? "dark" : "light"} mode`}
    >
      {theme === "light" ? (
        <Sun size={18} className="text-highlight-500" />
      ) : (
        <Moon size={18} className="text-primary-400" />
      )}
    </button>
  );
}
