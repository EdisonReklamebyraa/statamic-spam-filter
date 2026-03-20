<?php

namespace Edgebranding\StatamicSpamFilter;

use Illuminate\Support\Facades\Http;

class EdgeFilterClient
{
    /**
     * Analyze a form submission for spam.
     *
     * Returns the verdict array on success, or null if the service is
     * unreachable — callers should fail open when null is returned.
     *
     * @return array{spam: bool, confidence: float, reason: string}|null
     */
    public function analyze(string $form, array $fields, array $fieldConfig = []): ?array
    {
        try {
            $response = Http::timeout(config('spam-filter.timeout', 15))
                ->retry(config('spam-filter.retries', 2), 500, throw: false)
                ->withHeader('X-API-Key', config('spam-filter.api_key'))
                ->post(rtrim(config('spam-filter.url'), '/').'/api/analyze', [
                    'form' => $form,
                    'domain' => parse_url(config('app.url'), PHP_URL_HOST),
                    'fields' => $fields,
                    'field_config' => $fieldConfig,
                ]);

            if ($response->failed()) {
                return null;
            }

            return $response->json();
        } catch (\Throwable) {
            return null;
        }
    }
}
