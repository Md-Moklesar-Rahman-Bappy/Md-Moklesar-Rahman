import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import {
  LayoutDashboard, FileText, Briefcase, GraduationCap, Code,
  Palette, Award, Link, MessageSquare, Image, LogOut, User,
  Settings, Menu, X, Plus, Pencil, Trash2, Star, ChevronUp,
} from "lucide-react";
import { supabase, isSupabaseConfigured } from "@/lib/supabase";
import {
  adminGetAll, adminGetMessages, adminInsert, adminUpdate,
  adminDelete, adminMarkMessageRead, uploadMedia, deleteMedia,
} from "@/services/portfolioService";
import type {
  Skill, Project, Experience, Education, Service,
  SocialLink, ContactMessage, MediaAsset, Certification,
  Hero, About, SiteSettings,
} from "@/types/database";
import toast from "react-hot-toast";

type SectionTab =
  | "overview" | "profile" | "hero" | "skills" | "projects"
  | "experience" | "education" | "services" | "certifications"
  | "social" | "messages" | "media" | "settings";

// eslint-disable-next-line @typescript-eslint/no-explicit-any
type EditableItem = Record<string, any>;

export function AdminDashboard() {
  const navigate = useNavigate();
  const [user, setUser] = useState<any>(null);
  const [loading, setLoading] = useState(true);
  const [tab, setTab] = useState<SectionTab>("overview");
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [editing, setEditing] = useState<{ table: string; item: EditableItem | null } | null>(null);
  const [showForm, setShowForm] = useState(false);

  // Data state
  const [skills, setSkills] = useState<Skill[]>([]);
  const [projects, setProjects] = useState<Project[]>([]);
  const [experience, setExperience] = useState<Experience[]>([]);
  const [education, setEducation] = useState<Education[]>([]);
  const [services, setServices] = useState<Service[]>([]);
  const [socialLinks, setSocialLinks] = useState<SocialLink[]>([]);
  const [messages, setMessages] = useState<ContactMessage[]>([]);
  const [media, setMedia] = useState<MediaAsset[]>([]);
  const [certifications, setCertifications] = useState<Certification[]>([]);
  const [hero, setHero] = useState<Hero | null>(null);
  const [about, setAbout] = useState<About | null>(null);
  const [siteSettings, setSiteSettings] = useState<SiteSettings | null>(null);

  useEffect(() => {
    supabase.auth.getSession().then(({ data: { session } }) => {
      if (!session) {
        navigate("/admin");
        return;
      }
      setUser(session.user);
      setLoading(false);
      loadAllData();
    });

    const { data: { subscription } } = supabase.auth.onAuthStateChange((_event, session) => {
      if (!session) navigate("/admin");
      else setUser(session.user);
    });

    return () => subscription.unsubscribe();
  }, []);

  const loadAllData = async () => {
    if (!isSupabaseConfigured) return;
    try {
      const [s, p, e, ed, sv, sl, m, med, cert] = await Promise.all([
        adminGetAll<Skill>("skills"),
        adminGetAll<Project>("projects"),
        adminGetAll<Experience>("experience"),
        adminGetAll<Education>("education"),
        adminGetAll<Service>("services"),
        adminGetAll<SocialLink>("social_links"),
        adminGetMessages(),
        adminGetAll<MediaAsset>("media_assets"),
        adminGetAll<Certification>("certifications"),
      ]);
      setSkills(s); setProjects(p); setExperience(e); setEducation(ed);
      setServices(sv); setSocialLinks(sl); setMessages(m); setMedia(med);
      setCertifications(cert);

      const { data: h } = await supabase.from("hero").select("*").limit(1).single();
      if (h) setHero(h as Hero);
      const { data: a } = await supabase.from("about").select("*").limit(1).single();
      if (a) setAbout(a as About);
      const { data: ss } = await supabase.from("site_settings").select("*").limit(1).single();
      if (ss) setSiteSettings(ss as SiteSettings);
    } catch (err) {
      console.error("Error loading data:", err);
    }
  };

  const handleLogout = async () => {
    await supabase.auth.signOut();
    navigate("/admin");
  };

  const handleDelete = async (table: string, id: string) => {
    if (!confirm("Are you sure you want to delete this item?")) return;
    try {
      await adminDelete(table as any, id);
      toast.success("Deleted successfully");
      loadAllData();
    } catch (err: any) {
      toast.error(err.message || "Delete failed");
    }
  };

  const handleSave = async (table: string, data: Record<string, unknown>) => {
    try {
      if (editing?.item) {
        await adminUpdate(table as any, editing.item.id, data);
        toast.success("Updated successfully");
      } else {
        await adminInsert(table as any, data);
        toast.success("Created successfully");
      }
      setEditing(null);
      setShowForm(false);
      loadAllData();
    } catch (err: any) {
      toast.error(err.message || "Save failed");
    }
  };

  const handleMediaUpload = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;
    try {
      await uploadMedia(file);
      toast.success("Uploaded successfully");
      loadAllData();
    } catch (err: any) {
      toast.error(err.message || "Upload failed");
    }
  };

  if (loading) return (
    <div className="min-h-screen flex items-center justify-center bg-dark-50 dark:bg-dark-950">
      <div className="w-8 h-8 border-4 border-primary-200 border-t-primary-500 rounded-full animate-spin" />
    </div>
  );

  const renderForm = (table: string, item: EditableItem | null) => {
    const data = item || {};
    const fields = Object.keys(data).filter(k => !["id", "created_at", "updated_at", "gallery_urls", "tech_stack"].includes(k));

    const handleFieldChange = (key: string, value: any) => {
      setEditing({ table, item: { ...(editing?.item || data as EditableItem), [key]: value } });
    };

    return (
      <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" onClick={() => { setEditing(null); setShowForm(false); }}>
        <div className="w-full max-w-lg max-h-[90vh] overflow-y-auto p-6 rounded-2xl bg-white dark:bg-dark-800" onClick={e => e.stopPropagation()}>
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-lg font-semibold text-dark-900 dark:text-white">
              {item ? "Edit" : "Add"} {table}
            </h3>
            <button onClick={() => { setEditing(null); setShowForm(false); }} className="p-1 text-dark-400 hover:text-dark-600">
              <X size={20} />
            </button>
          </div>
          <div className="space-y-3">
            {fields.map(f => {
              const val = (data as any)[f];
              if (typeof val === "boolean") {
                return (
                  <label key={f} className="flex items-center gap-2">
                    <input
                      type="checkbox"
                      checked={editing?.item?.[f] as boolean || false}
                      onChange={e => handleFieldChange(f, e.target.checked)}
                      className="rounded"
                    />
                    <span className="text-sm capitalize text-dark-700 dark:text-dark-200">{f.replace(/_/g, " ")}</span>
                  </label>
                );
              }
              const isTextarea = typeof val === "string" && val.length > 100;
              return (
                <div key={f}>
                  <label className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{f.replace(/_/g, " ")}</label>
                  {isTextarea ? (
                    <textarea
                      value={editing?.item?.[f] as string || ""}
                      onChange={e => handleFieldChange(f, e.target.value)}
                      rows={3}
                      className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none resize-none"
                    />
                  ) : (
                    <input
                      type={f.includes("date") ? "date" : f.includes("url") ? "url" : f.includes("email") ? "email" : f.includes("level") || f.includes("year") || f.includes("order") ? "number" : "text"}
                      value={editing?.item?.[f] as string || ""}
                      onChange={e => handleFieldChange(f, e.target.type === "number" ? Number(e.target.value) : e.target.value)}
                      className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none"
                    />
                  )}
                </div>
              );
            })}
          </div>
          <div className="mt-6 flex gap-3">
            <button onClick={() => { setEditing(null); setShowForm(false); }} className="px-4 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 text-dark-700 dark:text-dark-200 hover:bg-dark-50 dark:hover:bg-dark-700">Cancel</button>
            <button
              onClick={() => handleSave(table, editing?.item || data as Record<string, unknown>)}
              className="px-4 py-2 text-sm text-white bg-primary-500 rounded-lg hover:bg-primary-600"
            >
              {item ? "Update" : "Create"}
            </button>
          </div>
        </div>
      </div>
    );
  };

  const renderTable = (items: EditableItem[], tableName: string, columns: string[]) => (
    <div className="overflow-x-auto">
      <div className="flex items-center justify-between mb-4">
        <h3 className="text-lg font-semibold text-dark-900 dark:text-white capitalize">{tableName}</h3>
        <button
          onClick={() => {
            const emptyItem: EditableItem = { id: "" };
            columns.forEach(c => { emptyItem[c] = c.includes("visible") || c.includes("featured") || c.includes("current") ? false : c.includes("level") || c.includes("order") || c.includes("year") ? 0 : ""; });
            setEditing({ table: tableName, item: emptyItem });
            setShowForm(true);
          }}
          className="flex items-center gap-1 px-3 py-1.5 text-sm text-white bg-primary-500 rounded-lg hover:bg-primary-600"
        >
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
              <tr key={item.id} className="border-b border-dark-100 dark:border-dark-800 hover:bg-dark-50 dark:hover:bg-dark-800/50">
                {columns.map(c => (
                  <td key={c} className="py-3 px-2 text-dark-700 dark:text-dark-300 max-w-[200px] truncate">
                    {c === "level" ? (
                      <div className="flex items-center gap-2">
                        <div className="w-20 h-1.5 bg-dark-200 dark:bg-dark-700 rounded-full overflow-hidden">
                          <div className="h-full bg-primary-400 rounded-full" style={{ width: `${(item as any)[c]}%` }} />
                        </div>
                        <span className="text-xs text-dark-500">{(item as any)[c]}%</span>
                      </div>
                    ) : c === "is_visible" || c === "featured" || c === "is_current" ? (
                      (item as any)[c] ? <Star size={14} className="text-yellow-500" /> : <span className="text-dark-300">—</span>
                    ) : c === "image_url" ? (
                      (item as any)[c] ? "Yes" : "No"
                    ) : (
                      String((item as any)[c] || "—")
                    )}
                  </td>
                ))}
                <td className="py-3 px-2 text-right whitespace-nowrap">
                  <button
                    onClick={() => { setEditing({ table: tableName, item }); setShowForm(true); }}
                    className="p-1 text-blue-500 hover:text-blue-600"
                    title="Edit"
                  >
                    <Pencil size={14} />
                  </button>
                  <button
                    onClick={() => handleDelete(tableName, item.id)}
                    className="p-1 text-red-500 hover:text-red-600 ml-1"
                    title="Delete"
                  >
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
    { id: "media", label: "Media", icon: <Image size={16} /> },
    { id: "settings", label: "Settings", icon: <Settings size={16} /> },
  ];

  return (
    <div className="min-h-screen bg-dark-50 dark:bg-dark-950 flex">
      {/* Sidebar */}
      <aside className={`fixed inset-y-0 left-0 z-40 w-64 bg-white dark:bg-dark-900 border-r border-dark-200 dark:border-dark-800 transform transition-transform lg:translate-x-0 lg:static ${sidebarOpen ? "translate-x-0" : "-translate-x-full"}`}>
        <div className="flex items-center justify-between h-16 px-6 border-b border-dark-200 dark:border-dark-800">
          <span className="font-bold text-dark-900 dark:text-white">Admin Panel</span>
          <button onClick={() => setSidebarOpen(false)} className="lg:hidden p-1 text-dark-400">
            <X size={18} />
          </button>
        </div>
        <nav className="p-4 space-y-1 overflow-y-auto" style={{ height: "calc(100vh - 4rem)" }}>
          {tabs.map(t => (
            <button
              key={t.id}
              onClick={() => { setTab(t.id); setSidebarOpen(false); }}
              className={`w-full flex items-center gap-3 px-3 py-2 text-sm rounded-lg transition-colors ${
                tab === t.id
                  ? "bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 font-medium"
                  : "text-dark-600 dark:text-dark-400 hover:bg-dark-50 dark:hover:bg-dark-800"
              }`}
            >
              {t.icon} {t.label}
            </button>
          ))}
          <hr className="my-4 border-dark-200 dark:border-dark-700" />
          <button
            onClick={handleLogout}
            className="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
          >
            <LogOut size={16} /> Logout
          </button>
        </nav>
      </aside>

      {/* Overlay */}
      {sidebarOpen && (
        <div className="fixed inset-0 z-30 bg-black/50 lg:hidden" onClick={() => setSidebarOpen(false)} />
      )}

      {/* Main */}
      <div className="flex-1 min-w-0">
        <header className="h-16 flex items-center justify-between px-4 sm:px-6 bg-white dark:bg-dark-900 border-b border-dark-200 dark:border-dark-800">
          <button onClick={() => setSidebarOpen(true)} className="lg:hidden p-2 text-dark-600 dark:text-dark-400">
            <Menu size={20} />
          </button>
          <h2 className="text-lg font-semibold text-dark-900 dark:text-white capitalize">{tab}</h2>
          <div className="flex items-center gap-3">
            <a href="/" className="text-sm text-primary-500 hover:underline">View Site</a>
            <span className="text-xs text-dark-400">{user?.email}</span>
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
                  { label: "Media", count: media.length, color: "bg-red-500" },
                ].map(s => (
                  <div key={s.label} className="p-4 rounded-xl bg-white dark:bg-dark-800 border border-dark-200 dark:border-dark-700">
                    <div className={`w-2 h-2 rounded-full ${s.color} mb-2`} />
                    <div className="text-2xl font-bold text-dark-900 dark:text-white">{s.count}</div>
                    <div className="text-xs text-dark-500 dark:text-dark-400">{s.label}</div>
                  </div>
                ))}
              </div>
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
                  {["heading", "content", "years_experience"].map(f => (
                    <div key={f}>
                      <label className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{f.replace(/_/g, " ")}</label>
                      {f === "content" ? (
                        <textarea
                          value={(about as any)[f] || ""}
                          onChange={async (e) => {
                            await supabase.from("about").update({ [f]: e.target.value }).eq("id", about.id);
                            loadAllData();
                          }}
                          rows={4}
                          className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none resize-none"
                        />
                      ) : (
                        <input
                          type={f === "years_experience" ? "number" : "text"}
                          value={(about as any)[f] || ""}
                          onChange={async (e) => {
                            const val = f === "years_experience" ? Number(e.target.value) : e.target.value;
                            await supabase.from("about").update({ [f]: val }).eq("id", about.id);
                            loadAllData();
                          }}
                          className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none"
                        />
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
                {["title", "subtitle", "description", "cta_primary_label", "cta_secondary_label", "cta_secondary_url"].map(f => (
                  <div key={f}>
                    <label className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{f.replace(/_/g, " ")}</label>
                    {f === "description" ? (
                      <textarea
                        value={(hero as any)[f] || ""}
                        onChange={async (e) => {
                          await supabase.from("hero").update({ [f]: e.target.value }).eq("id", hero.id);
                          loadAllData();
                        }}
                        rows={3}
                        className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none resize-none"
                      />
                    ) : (
                      <input
                        type="text"
                        value={(hero as any)[f] || ""}
                        onChange={async (e) => {
                          await supabase.from("hero").update({ [f]: e.target.value }).eq("id", hero.id);
                          loadAllData();
                        }}
                        className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none"
                      />
                    )}
                  </div>
                ))}
              </div>
            </div>
          )}

          {tab === "skills" && renderTable(skills as unknown as EditableItem[], "skills", ["name", "category", "level", "sort_order", "is_visible"])}
          {tab === "projects" && renderTable(projects as unknown as EditableItem[], "projects", ["title", "category", "featured", "is_visible", "sort_order"])}
          {tab === "experience" && renderTable(experience as unknown as EditableItem[], "experience", ["company", "position", "is_current", "sort_order", "is_visible"])}
          {tab === "education" && renderTable(education as unknown as EditableItem[], "education", ["institution", "degree", "start_year", "end_year", "is_visible"])}
          {tab === "services" && renderTable(services as unknown as EditableItem[], "services", ["title", "sort_order", "is_visible"])}
          {tab === "certifications" && renderTable(certifications as unknown as EditableItem[], "certifications", ["title", "issuer", "is_visible"])}
          {tab === "social" && renderTable(socialLinks as unknown as EditableItem[], "social_links", ["platform", "url", "sort_order", "is_visible"])}

          {tab === "messages" && (
            <div>
              <h3 className="text-lg font-semibold text-dark-900 dark:text-white mb-4">Contact Messages</h3>
              {messages.length === 0 ? (
                <p className="text-dark-400 dark:text-dark-500">No messages yet.</p>
              ) : (
                <div className="space-y-3">
                  {messages.map(m => (
                    <div key={m.id} onClick={() => { if (!m.is_read) { adminMarkMessageRead(m.id); loadAllData(); } }} className={`p-4 rounded-xl border cursor-pointer transition-colors ${m.is_read ? "bg-white dark:bg-dark-800 border-dark-200 dark:border-dark-700" : "bg-primary-50 dark:bg-primary-900/20 border-primary-200 dark:border-primary-900/30"}`}>
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

          {tab === "media" && (
            <div>
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-semibold text-dark-900 dark:text-white">Media Assets</h3>
                <label className="flex items-center gap-1 px-3 py-1.5 text-sm text-white bg-primary-500 rounded-lg hover:bg-primary-600 cursor-pointer">
                  <Plus size={14} /> Upload
                  <input type="file" className="hidden" onChange={handleMediaUpload} accept="image/*" />
                </label>
              </div>
              {media.length === 0 ? (
                <p className="text-dark-400 dark:text-dark-500">No media uploaded yet.</p>
              ) : (
                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                  {media.map(m => (
                    <div key={m.id} className="group relative rounded-xl overflow-hidden bg-dark-100 dark:bg-dark-800 border border-dark-200 dark:border-dark-700">
                      <div className="aspect-square bg-gradient-to-br from-dark-100 to-dark-200 dark:from-dark-700 dark:to-dark-800 flex items-center justify-center">
                        <img src={m.file_url} alt={m.alt_text || m.file_name} className="w-full h-full object-cover" loading="lazy" />
                      </div>
                      <div className="p-2">
                        <p className="text-xs text-dark-500 dark:text-dark-400 truncate">{m.file_name}</p>
                      </div>
                      <button
                        onClick={() => { if (confirm("Delete this file?")) deleteMedia(m.id, m.file_url).then(() => loadAllData()); }}
                        className="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"
                      >
                        <Trash2 size={12} />
                      </button>
                    </div>
                  ))}
                </div>
              )}
            </div>
          )}

          {tab === "settings" && siteSettings && (
            <div>
              <h3 className="text-lg font-semibold text-dark-900 dark:text-white mb-4">Site Settings</h3>
              <div className="space-y-3 max-w-lg">
                {["site_name", "owner_name", "tagline", "primary_email", "phone", "location", "resume_url"].map(f => (
                  <div key={f}>
                    <label className="block text-xs font-medium text-dark-500 dark:text-dark-400 mb-1 capitalize">{f.replace(/_/g, " ")}</label>
                    <input
                      type={f === "primary_email" ? "email" : f === "resume_url" ? "url" : "text"}
                      value={(siteSettings as any)[f] || ""}
                      onChange={async (e) => {
                        await supabase.from("site_settings").update({ [f]: e.target.value }).eq("id", siteSettings.id);
                        loadAllData();
                      }}
                      className="w-full px-3 py-2 text-sm rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white focus:ring-2 focus:ring-primary-400 outline-none"
                    />
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>
      </div>

      {/* Form modal */}
      {showForm && editing && renderForm(editing.table, editing.item)}
    </div>
  );
}
