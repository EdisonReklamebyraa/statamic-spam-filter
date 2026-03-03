# Statamic Spam Filter

> **Work in progress.** This package is not ready for public use. It is published for internal development purposes only.

A thin Statamic addon that checks form submissions against the [Edge Filter](../edge-filter) API and cancels spam before it is saved.

## How It Works

The addon listens for Statamic's `SubmissionCreating` event. For every submission it calls the Edge Filter API, and if the verdict is `spam: true` it returns `false` — which cancels the submission before it is stored.

**It fails open:** if the API is unreachable or times out, the submission is always allowed through.

## Requirements

- PHP 8.2+
- Statamic 4 or 5
- A running [Edge Filter](../edge-filter) instance

## Installation

Since this package is not yet on Packagist, add the GitHub repository to your Statamic site's `composer.json` first:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/EdisonReklamebyraa/statamic-spam-filter"
    }
]
```

Then install:

```bash
composer require edgebranding/statamic-spam-filter
```

Then add to your `.env`:

```env
EDGE_GUARD_URL=https://spam.yourdomain.com
EDGE_GUARD_API_KEY=your-api-key
```

Optionally publish the config file if you need to customise the timeout:

```bash
php artisan vendor:publish --tag=spam-filter-config
```

## Configuration

| Variable | Default | Description |
|---|---|---|
| `EDGE_GUARD_URL` | — | Base URL of the Edge Guard service |
| `EDGE_GUARD_API_KEY` | — | Shared API key configured on the service |
| `EDGE_FILTER_TIMEOUT` | `3` | Seconds before the request times out |
| `EDGE_FILTER_SHADOW_MODE` | `true` | Log verdicts but never block submissions |
| `EDGE_FILTER_LOG` | `true` | Write all verdicts to the application log |

## Shadow Mode

The package ships with `EDGE_FILTER_SHADOW_MODE=true`. In this mode the AI runs on every submission and logs its findings, but nothing is ever blocked. This lets you verify the filter is accurate before enabling it for real.

Once you're confident, set `EDGE_FILTER_SHADOW_MODE=false` on any site where you want actual blocking.

## Logging

When `EDGE_FILTER_LOG=true`, every verdict is written to the application log:

```
spam-filter verdict  form="Contact Form"  spam=true  confidence=0.99  reason="..."  shadow_mode=true  acted_on=false
```
