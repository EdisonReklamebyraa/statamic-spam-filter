# Statamic Spam Filter

A thin Statamic addon that checks form submissions against the [Edge Filter](../edge-filter) API and cancels spam before it is saved.

## How It Works

The addon listens for Statamic's `SubmissionCreating` event. For every submission it calls the Edge Filter API, and if the verdict is `spam: true` it returns `false` — which cancels the submission before it is stored.

**It fails open:** if the API is unreachable or times out, the submission is always allowed through.

## Requirements

- PHP 8.2+
- Statamic 4 or 5
- A running [Edge Filter](../edge-filter) instance

## Installation

```bash
composer require edgebranding/statamic-spam-filter
```

Then add to your `.env`:

```env
EDGE_FILTER_URL=https://spam.yourdomain.com
EDGE_FILTER_API_KEY=your-api-key
```

Optionally publish the config file if you need to customise the timeout:

```bash
php artisan vendor:publish --tag=spam-filter-config
```

## Configuration

| Variable | Default | Description |
|---|---|---|
| `EDGE_FILTER_URL` | — | Base URL of the Edge Filter service |
| `EDGE_FILTER_API_KEY` | — | Shared API key configured on the service |
| `EDGE_FILTER_TIMEOUT` | `3` | Seconds before the request times out |

## Logging

Blocked submissions are logged at the `info` level:

```
spam-filter blocked submission  form="Contact Form"  confidence=0.99  reason="..."
```
