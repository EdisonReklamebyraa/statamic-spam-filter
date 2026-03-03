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
        $form = $submission->form()->title();

        $fieldConfig = $submission->form()->blueprint()->fields()->all()
            ->mapWithKeys(fn ($field) => [$field->handle() => ['required' => $field->isRequired()]])
            ->all();

        $verdict = $this->client->analyze(
            form: $form,
            fields: $submission->data()->all(),
            fieldConfig: $fieldConfig,
        );

        if ($verdict === null) {
            // Service unreachable — fail open, allow submission through.
            return null;
        }

        $shadowMode = config('spam-filter.shadow_mode');

        if (config('spam-filter.log')) {
            Log::info('spam-filter verdict', [
                'form' => $form,
                'fields' => $submission->data()->all(),
                'spam' => $verdict['spam'],
                'confidence' => $verdict['confidence'],
                'reason' => $verdict['reason'],
                'shadow_mode' => $shadowMode,
                'acted_on' => ! $shadowMode && $verdict['spam'],
            ]);
        }

        if ($verdict['spam'] && ! $shadowMode) {
            return false;
        }

        return null;
    }
}
