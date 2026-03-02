<?php

namespace Edgebranding\StatamicSpamFilter;

use Edgebranding\StatamicSpamFilter\Listeners\CheckSubmissionForSpam;
use Illuminate\Support\Facades\Event;
use Statamic\Events\SubmissionCreating;
use Statamic\Providers\AddonServiceProvider;

class SpamFilterServiceProvider extends AddonServiceProvider
{
    public function bootAddon(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/spam-filter.php', 'spam-filter');

        $this->publishes([
            __DIR__.'/../config/spam-filter.php' => config_path('spam-filter.php'),
        ], 'spam-filter-config');

        Event::listen(SubmissionCreating::class, CheckSubmissionForSpam::class);
    }
}
