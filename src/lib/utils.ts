import { clsx, type ClassValue } from "clsx";

export function cn(...inputs: ClassValue[]) {
  return clsx(inputs);
}

export function slugify(text: string) {
  return text
    .toLowerCase()
    .replace(/[^\w\s-]/g, "")
    .replace(/\s+/g, "-")
    .trim();
}

export function formatDate(date: string | null | undefined) {
  if (!date) return "";
  return new Date(date).toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
  });
}

export function getCategoryColor(category: string) {
  const colors: Record<string, string> = {
    "graphics-design": "bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400",
    "web-design": "bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400",
    "web-development": "bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400",
    wordpress: "bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400",
  };
  return colors[category] || "bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400";
}

export function getCategoryLabel(category: string) {
  const labels: Record<string, string> = {
    "graphics-design": "Graphics Design",
    "web-design": "Web Design",
    "web-development": "Web Development",
    wordpress: "WordPress",
  };
  return labels[category] || category;
}

export function getServiceIcon(icon: string) {
  const icons: Record<string, string> = {
    palette: "🎨",
    monitor: "🖥️",
    code: "⚡",
    layout: "📐",
    briefcase: "💼",
    "pen-tool": "🖊️",
    camera: "📷",
    server: "🖧",
    database: "🗄️",
    "smartphone": "📱",
  };
  return icons[icon] || "⭐";
}
