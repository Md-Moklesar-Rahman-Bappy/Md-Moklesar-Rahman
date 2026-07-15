import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import { Toaster } from "react-hot-toast";
import { ThemeProvider } from "@/hooks/useTheme";
import { HomePage } from "@/pages/Home";
import { AdminLogin } from "@/pages/AdminLogin";
import { AdminDashboard } from "@/pages/AdminDashboard";

export default function App() {
  return (
    <ThemeProvider>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/admin" element={<AdminLogin />} />
          <Route path="/admin/dashboard" element={<AdminDashboard />} />
          <Route path="*" element={<Navigate to="/" replace />} />
        </Routes>
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
