<?php
namespace Give\DonationForms;
use Give\ServiceProviders\ServiceProvider as ServiceProviderInterface;

/**
 * @unreleased
 */
class ServiceProvider implements ServiceProviderInterface {

    /**
     * @inheritDoc
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
         // Load form template
        give()->templates->load();

        // Load routes.
        give()->routeForm->init();
    }
}
