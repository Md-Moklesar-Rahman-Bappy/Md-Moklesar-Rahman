import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Eye, EyeOff, LogIn } from "lucide-react";
import toast from "react-hot-toast";

const ADMIN_PASSWORD = import.meta.env.VITE_ADMIN_PASSWORD || "admin123";

export function AdminLogin() {
  const navigate = useNavigate();
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const [error, setError] = useState("");

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");

    if (!password) {
      setError("Password is required");
      return;
    }

    setLoading(true);

    // Simulate a brief delay for UX
    await new Promise((r) => setTimeout(r, 400));

    if (password !== ADMIN_PASSWORD) {
      setError("Invalid password");
      setLoading(false);
      return;
    }

    sessionStorage.setItem("admin_authenticated", "true");
    toast.success("Welcome back!");
    navigate("/admin/dashboard");
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-dark-50 to-primary-50 dark:from-dark-950 dark:to-dark-900 p-4">
      <div className="w-full max-w-md">
        <div className="text-center mb-8">
          <h1 className="text-2xl font-bold text-dark-900 dark:text-white">Admin Login</h1>
          <p className="mt-2 text-dark-500 dark:text-dark-400">Enter the admin password to manage your portfolio</p>
        </div>

        <form onSubmit={handleSubmit} className="p-6 sm:p-8 rounded-2xl bg-white dark:bg-dark-800 shadow-xl border border-dark-200 dark:border-dark-700 space-y-4">
          <div>
            <label className="block text-sm font-medium text-dark-700 dark:text-dark-200 mb-1">Password</label>
            <div className="relative">
              <input
                type={showPassword ? "text" : "password"}
                value={password}
                onChange={(e) => { setPassword(e.target.value); setError(""); }}
                placeholder="Enter admin password"
                className="w-full px-4 py-2.5 pr-10 rounded-lg border border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-900 text-dark-900 dark:text-white placeholder-dark-400 focus:ring-2 focus:ring-primary-400 focus:border-transparent outline-none transition-all text-sm"
              />
              <button
                type="button"
                onClick={() => setShowPassword(!showPassword)}
                className="absolute right-3 top-1/2 -translate-y-1/2 text-dark-400 hover:text-dark-600"
              >
                {showPassword ? <EyeOff size={16} /> : <Eye size={16} />}
              </button>
            </div>
            {error && <p className="mt-1 text-xs text-red-500">{error}</p>}
          </div>

          <button
            type="submit"
            disabled={loading}
            className="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            {loading ? (
              <>
                <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin" />
                Signing in...
              </>
            ) : (
              <>
                <LogIn size={16} />
                Sign In
              </>
            )}
          </button>
        </form>

        <p className="mt-4 text-center text-sm text-dark-400">
          <a href="/" className="text-primary-500 hover:text-primary-600">← Back to portfolio</a>
        </p>
      </div>
    </div>
  );
}
