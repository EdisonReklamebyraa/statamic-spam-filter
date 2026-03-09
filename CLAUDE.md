# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A Statamic addon (PHP package) that checks form submissions against the Edge Filter AI API and cancels spam before it is saved. Not yet published to Packagist — installed via VCS in composer.json of the host Statamic site.

## Architecture

The addon has three components wired together by Laravel's service container:

- **`SpamFilterServiceProvider`** — entry point, merges config, publishes config file
- **`EdgeFilterClient`** — thin HTTP wrapper around the Edge Filter API's `/api/analyze` endpoint; returns `null` on any failure (fail-open design)
- **`CheckSubmissionForSpam`** (listener) — handles Statamic's `SubmissionCreating` event; calls the client, logs the verdict, and returns `false` to block or `null` to allow

Returning `false` from a `SubmissionCreating` listener cancels the submission in Statamic. Returning `null` allows it through.

## Key Behaviours

- **Fails open**: API errors or timeouts always allow submissions through (`null` return)
- **Shadow mode** (`EDGE_FILTER_SHADOW_MODE=true`, default): runs the AI and logs verdicts but never blocks
- **Logging** (`EDGE_FILTER_LOG=true`, default): writes JSON verdict to the Laravel app log

## Environment Variables

| Variable | Default | Purpose |
|---|---|---|
| `EDGE_GUARD_URL` | — | Base URL of the Edge Filter service |
| `EDGE_GUARD_API_KEY` | — | API key sent as `X-API-Key` header |
| `EDGE_FILTER_TIMEOUT` | `3` | HTTP timeout in seconds |
| `EDGE_FILTER_SHADOW_MODE` | `true` | Log without blocking |
| `EDGE_FILTER_LOG` | `true` | Enable verdict logging |

## Development Commands

There are no build steps. The package is loaded as a Composer dependency in a Statamic host project. To develop:

```bash
# Install PHP dependencies
composer install

# Publish config to the host Statamic site (run from the host project)
php artisan vendor:publish --tag=spam-filter-config
```

There is currently no test suite or linter configured.
