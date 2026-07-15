import { cn } from "@/lib/utils";

export function LoadingSpinner({ className }: { className?: string }) {
  return (
    <div className={cn("flex items-center justify-center py-20", className)}>
      <div className="relative w-10 h-10">
        <div className="absolute inset-0 rounded-full border-4 border-primary-200 dark:border-primary-900" />
        <div className="absolute inset-0 rounded-full border-4 border-transparent border-t-accent-500 animate-spin" />
        <div className="absolute inset-1 rounded-full border-4 border-transparent border-b-primary-500 animate-spin" style={{ animationDirection: "reverse", animationDuration: "0.6s" }} />
      </div>
    </div>
  );
}

export function ErrorState({
  message,
  onRetry,
}: {
  message: string;
  onRetry?: () => void;
}) {
  return (
    <div className="flex flex-col items-center justify-center py-20 text-center">
      <div className="w-16 h-16 rounded-full bg-accent-50 dark:bg-accent-900/20 flex items-center justify-center mb-4">
        <span className="text-2xl">⚠️</span>
      </div>
      <p className="text-dark-500 dark:text-dark-400 mb-4">{message}</p>
      {onRetry && (
        <button
          onClick={onRetry}
          className="btn-gradient"
        >
          Try Again
        </button>
      )}
    </div>
  );
}

export function EmptyState({ message }: { message: string }) {
  return (
    <div className="flex items-center justify-center py-20 text-center">
      <div className="p-8 rounded-2xl glass-card">
        <p className="text-dark-400 dark:text-dark-500 italic">{message}</p>
      </div>
    </div>
  );
}
