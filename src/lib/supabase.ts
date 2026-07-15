import { createClient, SupabaseClient } from "@supabase/supabase-js";

const supabaseUrl = import.meta.env.VITE_SUPABASE_URL;
const supabaseAnonKey = import.meta.env.VITE_SUPABASE_ANON_KEY;

export const isSupabaseConfigured = Boolean(supabaseUrl && supabaseAnonKey);

let _supabase: SupabaseClient | null = null;

export function getSupabase(): SupabaseClient {
  if (!_supabase) {
    if (!isSupabaseConfigured) {
      _supabase = createClient("https://placeholder.supabase.co", "placeholder-key");
    } else {
      _supabase = createClient(supabaseUrl!, supabaseAnonKey!);
    }
  }
  return _supabase;
}
