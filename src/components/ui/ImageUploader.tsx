import { useState, useRef } from "react";
import { Upload, X, ImageIcon } from "lucide-react";
import { isGitHubConfigured, uploadImage } from "@/services/githubService";
import toast from "react-hot-toast";

interface ImageUploaderProps {
  value: string | null | undefined;
  onChange: (url: string) => void;
  folder?: string;
  previewSize?: "sm" | "md" | "lg" | "xl";
  label?: string;
}

export function ImageUploader({ value, onChange, folder = "general", previewSize = "md", label }: ImageUploaderProps) {
  const [uploading, setUploading] = useState(false);
  const fileRef = useRef<HTMLInputElement>(null);

  const sizeClass = previewSize === "sm" ? "w-16 h-16" : previewSize === "md" ? "w-24 h-24" : previewSize === "lg" ? "w-32 h-32" : "w-40 h-40";
  const githubOk = isGitHubConfigured();

  const handleFile = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    if (!file.type.startsWith("image/")) {
      toast.error("Please select an image file");
      return;
    }

    if (file.size > 5 * 1024 * 1024) {
      toast.error("Image must be under 5MB");
      return;
    }

    if (!githubOk) {
      toast.error("GitHub is not configured. Set VITE_GITHUB_TOKEN, VITE_GITHUB_OWNER, and VITE_GITHUB_REPO in your .env file.");
      return;
    }

    setUploading(true);
    try {
      const result = await uploadImage(file, folder);
      if (result.success && result.url) {
        onChange(result.url);
        toast.success("Image uploaded!");
      } else {
        toast.error(result.error || "Upload failed");
      }
    } catch {
      toast.error("Upload failed");
    } finally {
      setUploading(false);
      if (fileRef.current) fileRef.current.value = "";
    }
  };

  return (
    <div className="space-y-2">
      {label && <label className="block text-xs font-medium text-dark-500 dark:text-dark-400">{label}</label>}

      {value ? (
        <div className="relative inline-block">
          <img src={value} alt="Preview"
            className={`${sizeClass} rounded-lg object-cover border border-dark-200 dark:border-dark-700 bg-dark-50 dark:bg-dark-900`}
            onError={(e) => { (e.target as HTMLImageElement).style.display = "none"; }}
          />
          <button type="button" onClick={() => onChange("")}
            className="absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full shadow hover:bg-red-600 transition-colors"
            title="Remove image">
            <X size={12} />
          </button>
        </div>
      ) : (
        <div className="flex items-center gap-2">
          <div className={`${sizeClass} rounded-lg border-2 border-dashed border-dark-200 dark:border-dark-700 flex items-center justify-center bg-dark-50 dark:bg-dark-900/50`}>
            <ImageIcon size={previewSize === "sm" ? 20 : 28} className="text-dark-300 dark:text-dark-600" />
          </div>
        </div>
      )}

      <div className="flex flex-wrap items-center gap-2">
        <input ref={fileRef} type="file" accept="image/*" onChange={handleFile} className="hidden" />
        <button type="button" onClick={() => fileRef.current?.click()} disabled={uploading}
          className="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 border border-primary-200 dark:border-primary-800 hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors disabled:opacity-50">
          <Upload size={12} /> {uploading ? "Uploading..." : "Upload"}
        </button>
      </div>
    </div>
  );
}
