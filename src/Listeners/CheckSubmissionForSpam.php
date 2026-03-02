<?php

namespace Edgebranding\StatamicSpamFilter\Listeners;

use Edgebranding\StatamicSpamFilter\EdgeFilterClient;
use Illuminate\Support\Facades\Log;
use Statamic\Events\SubmissionCreating;

class CheckSubmissionForSpam
{
    public function __construct(public readonly EdgeFilterClient $client) {}

    public function handle(SubmissionCreating $event): bool|null
    {
        $submission = $event->submission;

        $verdict = $this->client->analyze(
            form: $submission->form()->title(),
            fields: $submission->data()->all(),
        );

        if ($verdict === null) {
            // Service unreachable — fail open, allow submission through.
            return null;
        }

        if ($verdict['spam']) {
            Log::info('spam-filter blocked submission', [
                'form' => $submission->form()->title(),
                'confidence' => $verdict['confidence'],
                'reason' => $verdict['reason'],
            ]);

            return false;
        }

        return null;
    }
}
