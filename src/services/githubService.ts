import { Octokit } from "@octokit/rest";

function getConfig() {
  const token = import.meta.env.VITE_GITHUB_TOKEN;
  const owner = import.meta.env.VITE_GITHUB_OWNER;
  const repo = import.meta.env.VITE_GITHUB_REPO;
  return { token, owner, repo };
}

export function isGitHubConfigured(): boolean {
  const { token, owner, repo } = getConfig();
  return Boolean(token && owner && repo);
}

export interface CommitResult {
  success: boolean;
  error?: string;
}

export async function commitFile(
  filePath: string,
  content: string,
  commitMessage: string
): Promise<CommitResult> {
  const { token, owner, repo } = getConfig();

  if (!token || !owner || !repo) {
    return { success: false, error: "GitHub not configured (missing VITE_GITHUB_TOKEN, VITE_GITHUB_OWNER, or VITE_GITHUB_REPO)" };
  }

  const octokit = new Octokit({ auth: token });

  try {
    let sha: string | undefined;

    try {
      const { data: existing } = await octokit.repos.getContent({
        owner,
        repo,
        path: filePath,
      });
      if (!Array.isArray(existing)) {
        sha = existing.sha;
      }
    } catch {
      // File doesn't exist yet, will be created
    }

    await octokit.repos.createOrUpdateFileContents({
      owner,
      repo,
      path: filePath,
      message: commitMessage,
      content: btoa(unescape(encodeURIComponent(content))),
      sha,
    });

    return { success: true };
  } catch (err: unknown) {
    const message = err instanceof Error ? err.message : "Unknown error";
    return { success: false, error: message };
  }
}
