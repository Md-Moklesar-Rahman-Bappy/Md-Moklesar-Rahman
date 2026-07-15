import { DATA_FILE_MAP } from "./data-utils";

export function isSupabaseConfigured(): boolean {
  return false;
}

export function getSupabase(): never {
  throw new Error("Supabase has been removed. All data is now stored in src/data/ JSON files.");
}

export function getJsonFilename(table: string): string {
  return DATA_FILE_MAP[table] || `${table}.json`;
}
