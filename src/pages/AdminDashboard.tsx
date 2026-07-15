import { useEffect, useState, useCallback } from "react";
import { useNavigate } from "react-router-dom";
import {
  LayoutDashboard, FileText, Briefcase, GraduationCap, Code,
  Palette, Award, Link, MessageSquare, LogOut, User,
  Settings, Menu, X, Plus, Pencil, Trash2, Star,
} from "lucide-react";
import {
  adminGetAll, adminGetSingle, adminInsert, adminUpdate,
  adminDelete, adminMarkMessageRead,
} from "@/services/portfolioService";
import { isGitHubConfigured } from "@/services/githubService";
import type {
  Skill, Project, Experience, Education, Service,
  SocialLink, ContactMessage, Certification,
  Hero, About, SiteSettings,
} from "@/types/database";
import toast from "react-hot-toast";

type SectionTab =
  | "overview" | "profile" | "hero" | "skills" | "projects"
  | "experience" | "education" | "services" | "certifications"
  | "social" | "messages" | "settings";

type EditableItem = Record<string, unknown>;

const FIELD_EXCLUDE = ["created_at", "updated_at"];

const FA_ICON_OPTIONS = [
  "fa-brands fa-wordpress", "fa-brands fa-html5", "fa-brands fa-css3-alt",
  "fa-brands fa-js", "fa-brands fa-php", "fa-brands fa-laravel",
  "fa-brands fa-python", "fa-brands fa-react", "fa-brands fa-vuejs",
  "fa-brands fa-node", "fa-brands fa-git-alt", "fa-brands fa-docker",
  "fa-brands fa-figma", "fa-brands fa-bootstrap", "fa-brands fa-tailwind-css",
  "fa-solid fa-code", "fa-solid fa-globe", "fa-solid fa-palette",
  "fa-solid fa-pen-ruler", "fa-solid fa-wand-magic-sparkles",
  "fa-solid fa-puzzle-piece", "fa-solid fa-database", "fa-solid fa-server",
  "fa-solid fa-cloud", "fa-solid fa-mobile-screen", "fa-solid fa-paintbrush",
  "fa-solid fa-camera", "fa-solid fa-video", "fa-solid fa-chart-line",
];

const SOCIAL_ICON_OPTIONS = [
  "github", "linkedin", "twitter", "facebook", "instagram",
  "youtube", "dribbble", "behance", "codepen", "stackoverflow",
  "medium", "dev", "hashnode", "link",
];

function getProjectCategories(projects: Project[]): string[] {
  return ["all", ...new Set(projects.map(p => p.category))].filter(c => c !== "all");
}

interface FormFieldConfig {
  key: string;
  label?: string;
  type: "text" | "textarea" | "number" | "checkbox" | "date" | "url" | "email" | "icon-select" | "social-icon-select" | "category-select" | "image-url" | "comma-list" | "readonly";
  options?: { value: string; label: string }[];
}

type TableFieldConfig = FormFieldConfig[];

const FIELD_CONFIGS: Record<string, TableFieldConfig> = {
  skills: [
    { key: "name", type: "text" },
    { key: "category", type: "text" },
    { key: "level", type: "number" },
    { key: "icon", label: "Icon (Font Awesome)", type: "icon-select", options: FA_ICON_OPTIONS.map(i => ({ value: i, label: i.replace("fa-", "").replace("fa-brands ", "").replace("fa-solid ", "").replace(/-/g, " ") })) },
    { key: "icon_url", type: "url" },
    { key: "sort_order", type: "number" },
    { key: "is_visible", type: "checkbox" },
  ],
  projects: [
    { key: "title", type: "text" },
    { key: "slug", type: "text" },
    { key: "short_description", type: "textarea" },
    { key: "description", type: "textarea" },
    { key: "image_url", type: "image-url" },
    { key: "gallery_urls", label: "Gallery URLs (comma separated)", type: "comma-list" },
    { key: "tech_stack", label: "Tech Stack (comma separated)", type: "comma-list" },
    { key: "live_url", type: "url" },
    { key: "github_url", type: "url" },
    { key: "category", type: "text" },
    { key: "featured", type: "checkbox" },
    { key: "is_visible", type: "checkbox" },
    { key: "sort_order", type: "number" },
  ],
  experience: [
    { key: "company", type: "text" },
    { key: "position", type: "text" },
    { key: "start_date", type: "date" },
    { key: "end_date", type: "date" },
    { key: "is_current", type: "checkbox" },
    { key: "description", type: "textarea" },
    { key: "location", type: "text" },
    { key: "sort_order", type: "number" },
    { key: "is_visible", type: "checkbox" },
  ],
  education: [
    { key: "institution", type: "text" },
    { key: "degree", type: "text" },
    { key: "field", type: "text" },
    { key: "start_year", type: "number" },
    { key: "end_year", type: "number" },
    { key: "description", type: "textarea" },
    { key: "sort_order", type: "number" },
    { key: "is_visible", type: "checkbox" },
  ],
  services: [
    { key: "title", type: "text" },
    { key: "description", type: "textarea" },
    { key: "icon", type: "text" },
    { key: "category", type: "category-select" },
    { key: "sort_order", type: "number" },
    { key: "is_visible", type: "checkbox" },
  ],
  certifications: [
    { key: "title", type: "text" },
    { key: "issuer", type: "text" },
    { key: "issue_date", type: "date" },
    { key: "credential_url", type: "url" },
    { key: "image_url", type: "image-url" },
    { key: "category", type: "category-select" },
    { key: "sort_order", type: "number" },
    { key: "is_visible", type: "checkbox" },
  ],
  social_links: [
    { key: "platform", type: "text" },
    { key: "url", type: "url" },
    { key: "icon", label: "Icon", type: "social-icon-select", options: SOCIAL_ICON_OPTIONS.map(i => ({ value: i, label: i })) },
    { key: "sort_order", type: "number" },
    { key: "is_visible", type: "checkbox" },
  ],
};

const TABLE_COLUMNS: Record<string, string[]> = {
  skills: ["name", "category", "level", "icon", "sort_order", "is_visible"],
  projects: ["title", "category", "featured", "is_visible", "sort_order"],
  experience: ["company", "position", "start_date", "end_date", "is_current", "is_visible"],
  education: ["institution", "degree", "field", "start_year", "end_year", "is_visible"],
  services: ["title", "icon", "category", "sort_order", "is_visible"],
  certifications: ["title", "issuer", "category", "image_url", "is_visible"],
  social_links: ["platform", "url", "icon", "sort_order", "is_visible"],
};

function defaultValueForType(type: FormFieldConfig["type"]): unknown {
  switch (type) {
    case "checkbox": return false;
    case "number": return 0;
    default: return "";
  }
}

function computeEmptyItem(fields: FormFieldConfig[]): EditableItem {
  const item: EditableItem = {};
  fields.forEach(f => { item[f.key] = defaultValueForType(f.type); });
  return item;
}

export function AdminDashboard() {
  const navigate = useNavigate();
  const [tab, setTab] = useState<SectionTab>("overview");
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [editing, setEditing] = useState<{ table: string; item: EditableItem | null; raw: EditableItem | null } | null>(null);
  const [showForm, setShowForm] = useState(false);

  const [skills, setSkills] = useState<Skill[]>([]);
  const [projects, setProjects] = useState<Project[]>([]);
  const [experience, setExperience] = useState<Experience[]>([]);
  const [education, setEducation] = useState<Education[]>([]);
  const [services, setServices] = useState<Service[]>([]);
  const [socialLinks, setSocialLinks] = useState<SocialLink[]>([]);
  const [messages, setMessages] = useState<ContactMessage[]>([]);
  const [certifications, setCertifications] = useState<Certification[]>([]);
  const [hero, setHero] = useState<Hero | null>(null);
  const [about, setAbout] = useState<About | null>(null);
  const [siteSettings, setSiteSettings] = useState<SiteSettings | null>(null);

  useEffect(() => {
    const authed = sessionStorage.getItem("admin_authenticated");
    if (!authed) { navigate("/admin"); return; }
    loadAllData();
  }, [navigate]);

  const loadAllData = useCallback(() => {
    try {
      const s = adminGetAll<Skill>("skills");
      const p = adminGetAll<Project>("projects");
      const e = adminGetAll<Experience>("experience");
      const ed = adminGetAll<Education>("education");
      const sv = adminGetAll<Service>("services");
      const sl = adminGetAll<SocialLink>("social_links");
      const m = adminGetAll<ContactMessage>("contact_messages")
        .sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());
      const cert = adminGetAll<Certification>("certifications");
      const h = adminGetSingle("hero") as Hero | null;
      const a = adminGetSingle("about") as About | null;
      const ss = adminGetSingle("site_settings") as SiteSettings | null;

      setSkills(s); setProjects(p); setExperience(e); setEducation(ed);
      setServices(sv); setSocialLinks(sl); setMessages(m); setCertifications(cert);
      setHero(h); setAbout(a); setSiteSettings(ss);
    } catch (err) {
      console.error("Error loading data:", err);
      toast.error("Failed to load data");
    }
  }, []);

  const handleLogout = () => {
    sessionStorage.removeItem("admin_authenticated");
    navigate("/admin");
  };

  const handleDelete = async (table: string, id: string) => {
    if (!confirm("Are you sure you want to delete this item?")) return;
    try {
      await adminDelete(table, id);
      toast.success("Deleted successfully");
      loadAllData();
    } catch (err: unknown) {
      toast.error(err instanceof Error ? err.message : "Delete failed");
    }
  };

  const handleSave = async (table: string, data: Record<string, unknown>) => {
    try {
      if (editing?.raw?.id) {
        await adminUpdate(table, editing.raw.id as string, data);
        toast.success("Updated successfully");
      } else {
        await adminInsert(table, data);
        toast.success("Created successfully");
      }
      setEditing(null);
      setShowForm(false);
      loadAllData();
    } catch (err: unknown) {
      toast.error(err instanceof Error ? err.message : "Save failed");
    }
  };

  function renderFormField(field: FormFieldConfig, value: unknown, onChange: (v: unknown) => void) {
    const label = field.label || field.key.replace(/_/g, " ");
    const id = `field-${field.key}`;

    switch (field.type) {
      case "checkbox":
        return (
          <label key={field.key} className="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" checked={!!value} onChange={e => onChange(e.target.checked)} className="rounded border-dark-300 dark:border-dark-600 text-primary-500 focus:ring-primary-400" />
            <span className="text-sm capitalize text-dark-700 dark:text-dark-200">{label}</span>
          </label>
        );

      case "number":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <input id={id} type="number" value={value as number ?? 0} onChange={e => onChange(Number(e.target.value))}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
          </div>
        );

      case "date":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <input id={id} type="date" value={value as string ?? ""} onChange={e => onChange(e.target.value)}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
          </div>
        );

      case "url":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <input id={id} type="url" value={value as string ?? ""} onChange={e => onChange(e.target.value)} placeholder="https://"
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
          </div>
        );

      case "email":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <input id={id} type="email" value={value as string ?? ""} onChange={e => onChange(e.target.value)}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
          </div>
        );

      case "icon-select":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <select id={id} value={value as string ?? ""} onChange={e => onChange(e.target.value)}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none">
              <option value="">Select icon...</option>
              {field.options?.map(o => (
                <option key={o.value} value={o.value}>{o.label}</option>
              ))}
            </select>
          </div>
        );

      case "social-icon-select":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <select id={id} value={value as string ?? ""} onChange={e => onChange(e.target.value)}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none">
              <option value="">Select icon...</option>
              {field.options?.map(o => (
                <option key={o.value} value={o.value}>{o.label}</option>
              ))}
            </select>
          </div>
        );

      case "category-select":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <select id={id} value={value as string ?? ""} onChange={e => onChange(e.target.value)}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none">
              <option value="">Select category...</option>
              {getProjectCategories(projects).map(c => (
                <option key={c} value={c}>{c.replace(/-/g, " ").replace(/\b\w/g, l => l.toUpperCase())}</option>
              ))}
            </select>
          </div>
        );

      case "image-url":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <div className="flex gap-2">
              <input id={id} type="url" value={value as string ?? ""} onChange={e => onChange(e.target.value)} placeholder="https://"
                className="flex-1 px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
              {!!value && <img src={String(value)} alt="" className="w-10 h-10 rounded object-cover border border-dark-200 dark:border-dark-700" />}
            </div>
          </div>
        );

      case "comma-list":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <input id={id} type="text" value={Array.isArray(value) ? (value as string[]).join(", ") : (value as string ?? "")}
              onChange={e => onChange(e.target.value.split(",").map(s => s.trim()).filter(Boolean))}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
          </div>
        );

      case "textarea":
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <textarea id={id} value={value as string ?? ""} onChange={e => onChange(e.target.value)} rows={3}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none resize-none" />
          </div>
        );

      default:
        return (
          <div key={field.key}>
            <label htmlFor={id} className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{label}</label>
            <input id={id} type="text" value={value as string ?? ""} onChange={e => onChange(e.target.value)}
              className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
          </div>
        );
    }
  }

  const renderForm = (table: string, item: EditableItem | null) => {
    const data = item || {};
    const fields = FIELD_CONFIGS[table] || [];

    const handleFieldChange = (key: string, value: unknown) => {
      setEditing(prev => ({ table, raw: prev?.raw ?? null, item: { ...(prev?.item || { ...data }), [key]: value } }));
    };

    return (
      <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" onClick={() => { setEditing(null); setShowForm(false); }}>
        <div className="w-full max-w-lg max-h-[90vh] overflow-y-auto p-6 rounded-2xl bg-white dark:bg-dark-800" onClick={e => e.stopPropagation()}>
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-lg font-semibold text-dark-900 dark:text-white">
              {item?.id ? "Edit" : "Add"} {table.replace(/_/g, " ")}
            </h3>
            <button onClick={() => { setEditing(null); setShowForm(false); }} className="p-1 text-dark-400 hover:text-dark-600">
              <X size={20} />
            </button>
          </div>
          <div className="space-y-3">
            {fields.map(f => renderFormField(f, editing?.item?.[f.key] ?? data[f.key], (v) => handleFieldChange(f.key, v)))}
          </div>
          <div className="mt-6 flex gap-3">
            <button onClick={() => { setEditing(null); setShowForm(false); }} className="px-4 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 text-dark-700 dark:text-dark-200 hover:bg-dark-50 dark:hover:bg-dark-700">Cancel</button>
            <button onClick={() => handleSave(table, editing?.item || data as Record<string, unknown>)}
              className="px-4 py-2 text-sm text-white bg-primary-500 rounded-lg hover:bg-primary-600">
              {item?.id ? "Update" : "Create"}
            </button>
          </div>
        </div>
      </div>
    );
  };

  const renderTable = (items: EditableItem[], tableName: string) => {
    const columns = TABLE_COLUMNS[tableName] || [];
    const config = FIELD_CONFIGS[tableName] || [];

    return (
      <div className="overflow-x-auto">
        <div className="flex items-center justify-between mb-4">
          <h3 className="text-lg font-semibold text-dark-900 dark:text-white capitalize">{tableName.replace(/_/g, " ")}</h3>
          <button onClick={() => {
            const emptyItem = computeEmptyItem(config);
            setEditing({ table: tableName, item: { ...emptyItem }, raw: null });
            setShowForm(true);
          }} className="flex items-center gap-1 px-3 py-1.5 text-sm text-white bg-primary-500 rounded-lg hover:bg-primary-600">
            <Plus size={14} /> Add
          </button>
        </div>
        {items.length === 0 ? (
          <p className="text-dark-400 dark:text-dark-500 py-8 text-center">No items yet. Add one!</p>
        ) : (
          <table className="w-full text-sm">
            <thead>
              <tr className="border-b border-dark-200 dark:border-dark-700">
                {columns.map(c => (
                  <th key={c} className="text-left py-3 px-2 font-medium text-dark-500 dark:text-dark-400 capitalize whitespace-nowrap">{c.replace(/_/g, " ")}</th>
                ))}
                <th className="text-right py-3 px-2 font-medium text-dark-500 dark:text-dark-400">Actions</th>
              </tr>
            </thead>
            <tbody>
              {items.map((item) => (
                <tr key={item.id as string} className="border-b border-dark-100 dark:border-dark-800 hover:bg-dark-50 dark:hover:bg-dark-800/50">
                  {columns.map(c => {
                    const val = (item as Record<string, unknown>)[c];
                    return (
                      <td key={c} className="py-3 px-2 text-dark-700 dark:text-dark-300 max-w-[200px] truncate">
                        {c === "level" ? (
                          <div className="flex items-center gap-2">
                            <div className="w-20 h-1.5 bg-dark-200 dark:bg-dark-700 rounded-full overflow-hidden">
                              <div className="h-full bg-primary-400 rounded-full" style={{ width: `${val}%` }} />
                            </div>
                            <span className="text-xs text-dark-500">{String(val)}%</span>
                          </div>
                        ) : c === "is_visible" || c === "featured" || c === "is_current" ? (
                          val ? <Star size={14} className="text-yellow-500" /> : <span className="text-dark-300">—</span>
                        ) : c === "image_url" ? (
                          !!val ? <img src={String(val)} alt="" className="w-8 h-8 rounded object-cover border border-dark-200" /> : "—"
                        ) : c === "icon" && tableName === "skills" ? (
                          !!val ? <span className="text-xs font-mono text-primary-500 bg-primary-50 dark:bg-primary-900/20 px-1.5 py-0.5 rounded truncate block max-w-[120px]">{String(val)}</span> : "—"
                        ) : c === "icon" && tableName === "social_links" ? (
                          !!val ? <span className="text-xs font-mono text-accent-500 bg-accent-50 dark:bg-accent-900/20 px-1.5 py-0.5 rounded">{String(val)}</span> : "—"
                        ) : (
                          String(val || "—")
                        )}
                      </td>
                    );
                  })}
                  <td className="py-3 px-2 text-right whitespace-nowrap">
                    <button onClick={() => { setEditing({ table: tableName, item: { ...item }, raw: { ...item } }); setShowForm(true); }}
                      className="p-1 text-blue-500 hover:text-blue-600" title="Edit">
                      <Pencil size={14} />
                    </button>
                    <button onClick={() => handleDelete(tableName, item.id as string)}
                      className="p-1 text-red-500 hover:text-red-600 ml-1" title="Delete">
                      <Trash2 size={14} />
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        )}
      </div>
    );
  };

  const tabs: { id: SectionTab; label: string; icon: React.ReactNode }[] = [
    { id: "overview", label: "Overview", icon: <LayoutDashboard size={16} /> },
    { id: "profile", label: "Profile", icon: <User size={16} /> },
    { id: "hero", label: "Hero", icon: <Star size={16} /> },
    { id: "skills", label: "Skills", icon: <Code size={16} /> },
    { id: "projects", label: "Projects", icon: <FileText size={16} /> },
    { id: "experience", label: "Experience", icon: <Briefcase size={16} /> },
    { id: "education", label: "Education", icon: <GraduationCap size={16} /> },
    { id: "services", label: "Services", icon: <Palette size={16} /> },
    { id: "certifications", label: "Certs", icon: <Award size={16} /> },
    { id: "social", label: "Social", icon: <Link size={16} /> },
    { id: "messages", label: "Messages", icon: <MessageSquare size={16} /> },
    { id: "settings", label: "Settings", icon: <Settings size={16} /> },
  ];

  return (
    <div className="min-h-screen bg-dark-50 dark:bg-dark-950 flex">
      <aside className={`fixed inset-y-0 left-0 z-40 w-64 bg-white dark:bg-dark-900 border-r border-dark-200 dark:border-dark-800 transform transition-transform lg:translate-x-0 lg:static ${sidebarOpen ? "translate-x-0" : "-translate-x-full"}`}>
        <div className="flex items-center justify-between h-16 px-6 border-b border-dark-200 dark:border-dark-800">
          <span className="font-bold text-dark-900 dark:text-white">Admin Panel</span>
          <button onClick={() => setSidebarOpen(false)} className="lg:hidden p-1 text-dark-400"><X size={18} /></button>
        </div>
        <nav className="p-4 space-y-1 overflow-y-auto" style={{ height: "calc(100vh - 4rem)" }}>
          {tabs.map(t => (
            <button key={t.id} onClick={() => { setTab(t.id); setSidebarOpen(false); }}
              className={`w-full flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition-colors ${
                tab === t.id ? "bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 font-medium"
                  : "text-dark-600 dark:text-dark-400 hover:bg-dark-50 dark:hover:bg-dark-800"
              }`}>
              {t.icon} {t.label}
            </button>
          ))}
          <hr className="my-4 border-dark-200 dark:border-dark-700" />
          <button onClick={handleLogout}
            className="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
            <LogOut size={16} /> Logout
          </button>
        </nav>
      </aside>

      {sidebarOpen && <div className="fixed inset-0 z-30 bg-black/50 lg:hidden" onClick={() => setSidebarOpen(false)} />}

      <div className="flex-1 min-w-0">
        <header className="h-16 flex items-center justify-between px-4 sm:px-6 bg-white dark:bg-dark-900 border-b border-dark-200 dark:border-dark-800">
          <button onClick={() => setSidebarOpen(true)} className="lg:hidden p-2 text-dark-600 dark:text-dark-400"><Menu size={20} /></button>
          <h2 className="text-lg font-semibold text-dark-900 dark:text-white capitalize">{tab}</h2>
          <div className="flex items-center gap-3">
            {!isGitHubConfigured() && <span className="text-xs text-yellow-500 font-medium">GitHub not configured</span>}
            <a href="/" className="text-sm text-primary-500 hover:underline">View Site</a>
          </div>
        </header>

        <div className="p-4 sm:p-6 lg:p-8">
          {tab === "overview" && (
            <div>
              <h2 className="text-2xl font-bold text-dark-900 dark:text-white mb-6">Dashboard Overview</h2>
              <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                {[
                  { label: "Skills", count: skills.length, color: "bg-blue-500" },
                  { label: "Projects", count: projects.length, color: "bg-green-500" },
                  { label: "Experience", count: experience.length, color: "bg-purple-500" },
                  { label: "Education", count: education.length, color: "bg-orange-500" },
                  { label: "Services", count: services.length, color: "bg-pink-500" },
                  { label: "Social Links", count: socialLinks.length, color: "bg-indigo-500" },
                  { label: "Messages", count: messages.length, color: "bg-teal-500" },
                  { label: "Certifications", count: certifications.length, color: "bg-red-500" },
                ].map(s => (
                  <div key={s.label} className="p-4 rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700">
                    <div className={`w-2 h-2 rounded-full ${s.color} mb-2`} />
                    <div className="text-2xl font-bold text-dark-900 dark:text-white">{s.count}</div>
                    <div className="text-xs text-dark-500 dark:text-dark-400">{s.label}</div>
                  </div>
                ))}
              </div>
              {!isGitHubConfigured() && (
                <div className="p-4 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-sm mb-4">
                  GitHub API not configured. Changes will be saved in-memory only and lost on refresh. Set <strong>VITE_GITHUB_TOKEN</strong>, <strong>VITE_GITHUB_OWNER</strong>, and <strong>VITE_GITHUB_REPO</strong> to enable persistence.
                </div>
              )}
              {messages.filter(m => !m.is_read).length > 0 && (
                <div className="p-4 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-sm">
                  {messages.filter(m => !m.is_read).length} unread message(s). <button onClick={() => setTab("messages")} className="underline font-medium">View</button>
                </div>
              )}
            </div>
          )}

          {tab === "profile" && (
            <div>
              <h3 className="text-lg font-semibold text-dark-900 dark:text-white mb-4">About Section</h3>
              {about && (
                <div className="space-y-3 max-w-lg">
                  {["heading", "content", "years_experience", "image_url"].map(f => (
                    <div key={f}>
                      <label className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{f.replace(/_/g, " ")}</label>
                      {f === "content" ? (
                        <textarea value={(about as unknown as Record<string, unknown>)[f] as string || ""}
                          onChange={async (e) => { await adminUpdate("about", about.id, { [f]: e.target.value }); loadAllData(); }}
                          rows={4}
                          className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none resize-none" />
                      ) : f === "image_url" ? (
                        <div className="flex gap-2">
                          <input type="url" value={(about as unknown as Record<string, unknown>)[f] as string || ""}
                            onChange={async (e) => { await adminUpdate("about", about.id, { [f]: e.target.value }); loadAllData(); }}
                            className="flex-1 px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
                          {!!(about as unknown as Record<string, unknown>)[f] && (
                            <img src={String((about as unknown as Record<string, unknown>)[f])} alt="" className="w-12 h-12 rounded object-cover border border-dark-200" />
                          )}
                        </div>
                      ) : (
                        <input type={f === "years_experience" ? "number" : "text"}
                          value={(about as unknown as Record<string, unknown>)[f] as string || ""}
                          onChange={async (e) => { const val = f === "years_experience" ? Number(e.target.value) : e.target.value; await adminUpdate("about", about.id, { [f]: val }); loadAllData(); }}
                          className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
                      )}
                    </div>
                  ))}
                </div>
              )}
            </div>
          )}

          {tab === "hero" && hero && (
            <div>
              <h3 className="text-lg font-semibold text-dark-900 dark:text-white mb-4">Hero Section</h3>
              <div className="space-y-3 max-w-lg">
                {["title", "subtitle", "description", "profile_image_url", "background_image_url", "cta_primary_label", "cta_secondary_label", "cta_secondary_url"].map(f => (
                  <div key={f}>
                    <label className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{f.replace(/_/g, " ")}</label>
                    {f === "description" ? (
                      <textarea value={(hero as unknown as Record<string, unknown>)[f] as string || ""}
                        onChange={async (e) => { await adminUpdate("hero", hero.id, { [f]: e.target.value }); loadAllData(); }}
                        rows={3}
                        className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none resize-none" />
                    ) : f.includes("image_url") ? (
                      <div className="flex gap-2">
                        <input type="url" value={(hero as unknown as Record<string, unknown>)[f] as string || ""}
                          onChange={async (e) => { await adminUpdate("hero", hero.id, { [f]: e.target.value }); loadAllData(); }}
                          className="flex-1 px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
                        {!!(hero as unknown as Record<string, unknown>)[f] && (
                          <img src={String((hero as unknown as Record<string, unknown>)[f])} alt="" className="w-12 h-12 rounded object-cover border border-dark-200" />
                        )}
                      </div>
                    ) : (
                      <input type="text" value={(hero as unknown as Record<string, unknown>)[f] as string || ""}
                        onChange={async (e) => { await adminUpdate("hero", hero.id, { [f]: e.target.value }); loadAllData(); }}
                        className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
                    )}
                  </div>
                ))}
              </div>
            </div>
          )}

          {tab === "skills" && renderTable(skills as unknown as EditableItem[], "skills")}
          {tab === "projects" && renderTable(projects as unknown as EditableItem[], "projects")}
          {tab === "experience" && renderTable(experience as unknown as EditableItem[], "experience")}
          {tab === "education" && renderTable(education as unknown as EditableItem[], "education")}
          {tab === "services" && renderTable(services as unknown as EditableItem[], "services")}
          {tab === "certifications" && renderTable(certifications as unknown as EditableItem[], "certifications")}
          {tab === "social" && renderTable(socialLinks as unknown as EditableItem[], "social_links")}

          {tab === "messages" && (
            <div>
              <h3 className="text-lg font-semibold text-dark-900 dark:text-white mb-4">Contact Messages</h3>
              {messages.length === 0 ? (
                <p className="text-dark-400 dark:text-dark-500">No messages yet.</p>
              ) : (
                <div className="space-y-3">
                  {messages.map(m => (
                    <div key={m.id} onClick={() => { if (!m.is_read) { adminMarkMessageRead(m.id); loadAllData(); } }}
                      className={`p-4 rounded-xl border cursor-pointer transition-colors ${m.is_read ? "bg-white dark:bg-dark-800 border-dark-200 dark:border-dark-700" : "bg-primary-50 dark:bg-primary-900/20 border-primary-200 dark:border-primary-900/30"}`}>
                      <div className="flex items-start justify-between">
                        <div>
                          <span className="font-medium text-dark-900 dark:text-white">{m.name}</span>
                          <span className="text-sm text-dark-400 ml-2">{m.email}</span>
                        </div>
                        <span className="text-xs text-dark-400">{new Date(m.created_at).toLocaleDateString()}</span>
                      </div>
                      {m.subject && <p className="mt-1 text-sm font-medium text-dark-600 dark:text-dark-300">{m.subject}</p>}
                      <p className="mt-2 text-sm text-dark-500 dark:text-dark-400">{m.message}</p>
                    </div>
                  ))}
                </div>
              )}
            </div>
          )}

          {tab === "settings" && siteSettings && (
            <SettingsForm siteSettings={siteSettings} onSaved={loadAllData} />
          )}
        </div>
      </div>

      {showForm && editing && renderForm(editing.table, editing.item)}
    </div>
  );
}

const SETTINGS_FIELDS = [
  { key: "site_name", type: "text" },
  { key: "owner_name", type: "text" },
  { key: "tagline", type: "text" },
  { key: "primary_email", type: "email" },
  { key: "phone", type: "text" },
  { key: "location", type: "text" },
  { key: "logo_url", type: "url" },
  { key: "resume_url", type: "url" },
];

function SettingsForm({ siteSettings, onSaved }: { siteSettings: SiteSettings; onSaved: () => void }) {
  const [form, setForm] = useState<Record<string, string>>({});
  const [saving, setSaving] = useState(false);
  const [dirty, setDirty] = useState(false);

  const record = siteSettings as unknown as Record<string, string>;

  useEffect(() => {
    const initial: Record<string, string> = {};
    SETTINGS_FIELDS.forEach(f => { initial[f.key] = record[f.key] ?? ""; });
    setForm(initial);
    setDirty(false);
  }, [siteSettings]);

  const handleChange = (key: string, value: string) => {
    setForm(prev => ({ ...prev, [key]: value }));
    setDirty(true);
  };

  const handleSave = async () => {
    setSaving(true);
    try {
      const updates: Record<string, unknown> = {};
      SETTINGS_FIELDS.forEach(f => {
        if (form[f.key] !== (record[f.key] ?? "")) {
          updates[f.key] = form[f.key];
        }
      });
      if (Object.keys(updates).length > 0) {
        await adminUpdate("site_settings", siteSettings.id, updates);
        toast.success("Settings saved!");
      }
      setDirty(false);
      onSaved();
    } catch (err: unknown) {
      toast.error(err instanceof Error ? err.message : "Save failed");
    } finally {
      setSaving(false);
    }
  };

  const handleReset = () => {
    const initial: Record<string, string> = {};
    SETTINGS_FIELDS.forEach(f => { initial[f.key] = record[f.key] ?? ""; });
    setForm(initial);
    setDirty(false);
  };

  return (
    <div>
      <h3 className="text-lg font-semibold text-dark-900 dark:text-white mb-4">Site Settings</h3>
      <div className="space-y-3 max-w-lg">
        {SETTINGS_FIELDS.map(f => (
          <div key={f.key}>
            <label className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{f.key.replace(/_/g, " ")}</label>
            {f.key === "logo_url" ? (
              <div className="flex gap-2">
                <input type="url" value={form[f.key] ?? ""} onChange={e => handleChange(f.key, e.target.value)}
                  className="flex-1 px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
                {!!form[f.key] && <img src={form[f.key]} alt="" className="w-10 h-10 rounded object-cover border border-dark-200" />}
              </div>
            ) : (
              <input type={f.type}
                value={form[f.key] ?? ""} onChange={e => handleChange(f.key, e.target.value)}
                className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none" />
            )}
          </div>
        ))}
      </div>
      <div className="mt-6 flex gap-3">
        <button onClick={handleReset} disabled={!dirty || saving}
          className="px-4 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 text-dark-700 dark:text-dark-200 hover:bg-dark-50 dark:hover:bg-dark-700 disabled:opacity-50">
          Cancel
        </button>
        <button onClick={handleSave} disabled={!dirty || saving}
          className="px-6 py-2 text-sm text-white bg-primary-500 rounded-lg hover:bg-primary-600 disabled:opacity-50">
          {saving ? "Saving..." : "Save Settings"}
        </button>
      </div>
    </div>
  );
}
