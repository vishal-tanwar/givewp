<?php

namespace Give\Forms;

use Give\Forms\Repositories\FormRepository;

class ServiceProvider implements \Give\ServiceProviders\ServiceProvider
{

    /**
     * @inheritDoc
     */
    public function register()
    {
        give()->singleton('forms', FormRepository::class);
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }
}
