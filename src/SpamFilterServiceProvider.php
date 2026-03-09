<?php

namespace Edgebranding\StatamicSpamFilter;

use Edgebranding\StatamicSpamFilter\Listeners\CheckSubmissionForSpam;
use Statamic\Events\FormSubmitted;
use Statamic\Providers\AddonServiceProvider;

class SpamFilterServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        FormSubmitted::class => [
            CheckSubmissionForSpam::class,
        ],
    ];

    public function bootAddon(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/spam-filter.php', 'spam-filter');

        $this->publishes([
            __DIR__.'/../config/spam-filter.php' => config_path('spam-filter.php'),
        ], 'spam-filter-config');
    }
}
