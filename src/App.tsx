import { lazy, Suspense } from "react";
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import { Toaster } from "react-hot-toast";
import { ThemeProvider } from "@/hooks/useTheme";
import { HomePage } from "@/pages/Home";
import { LoadingSpinner } from "@/components/ui/LoadingState";

const AdminLogin = lazy(() => import("@/pages/AdminLogin").then(m => ({ default: m.AdminLogin })));
const AdminDashboard = lazy(() => import("@/pages/AdminDashboard").then(m => ({ default: m.AdminDashboard })));

export default function App() {
  return (
    <ThemeProvider>
      <BrowserRouter>
        <Suspense fallback={<LoadingSpinner />}>
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/admin" element={<AdminLogin />} />
            <Route path="/admin/dashboard" element={<AdminDashboard />} />
            <Route path="*" element={<Navigate to="/" replace />} />
          </Routes>
        </Suspense>
        <Toaster
          position="bottom-right"
          toastOptions={{
            className: "!text-sm",
            style: {
              borderRadius: "12px",
              padding: "12px 16px",
            },
          }}
        />
      </BrowserRouter>
    </ThemeProvider>
  );
}
