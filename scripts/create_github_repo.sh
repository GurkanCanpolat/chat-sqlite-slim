#!/usr/bin/env bash
# Helper: create a private GitHub repo and push current directory (requires gh CLI and authenticated user)
set -euo pipefail
REPO_NAME=${1:-$(basename "$PWD")}
DESCRIPTION=${2:-"Private repo created from local project"}

if ! command -v gh >/dev/null 2>&1; then
  echo "gh CLI not found. Install from https://cli.github.com/"
  exit 1
fi

# Create private repo
gh repo create "$REPO_NAME" --private --description "$DESCRIPTION" --source . --remote origin --push

echo "Repository created and pushed: $(gh repo view --json url -q .url)"
