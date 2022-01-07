<?php

namespace Give\LegacySubscriptions;

use Closure;
use Give\ServiceProviders\ServiceProvider as ServiceProviderInterface;

/**
 * Class LegacyServiceProvider
 *
 * This handles the loading of all the legacy codebase included in the /includes directory.
 * DO NOT EXTEND THIS WITH NEW CODE as it is intended to shrink over time as we migrate over
 * to the new ways of doing things.
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->includeLegacyFiles();
        $this->bindClasses();
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
    }

    /**
     * Load all the legacy class files since they don't have autoloading
     *
     * @unreleased
     */
    private function includeLegacyFiles()
    {
        require_once __DIR__ . '/includes/give-subscriptions-db.php';
        require_once __DIR__ . '/includes/give-recurring-db-subscription-meta.php';
        require_once __DIR__ . '/includes/give-recurring-cache.php';
        require_once __DIR__ . '/includes/give-subscription.php';
        require_once __DIR__ . '/includes/give-subscriptions-api.php';
        require_once __DIR__ . '/includes/give-recurring-subscriber.php';
        require_once __DIR__ . '/includes/give-recurring-helpers.php';
        require_once __DIR__ . '/includes/give-recurring-emails.php';
        require_once __DIR__ . '/includes/give-recurring-renewals.php';
        require_once __DIR__ . '/includes/give-recurring-expirations.php';
        require_once __DIR__ . '/includes/give-recurring-cron.php';
        require_once __DIR__ . '/includes/give-recurring-gateway-factory.php';
        require_once __DIR__ . '/includes/give-recurring-ajax.php';
    }

    /**
     * Binds the legacy classes to the service provider
     *
     * @unreleased
     */
    private function bindClasses()
    {
        $this->bindInstance('subscription_meta', 'Give_Recurring_DB_Subscription_Meta', 'give-recurring-db-subscription-meta.php');
    }

    /**
     * A helper for loading legacy classes that do not use autoloading, then binding their instance
     * to the container.
     *
     * @unreleased
     *
     * @param string $alias
     * @param string|Closure $class
     * @param string $includesPath
     * @param bool $singleton
     */
    private function bindInstance($alias, $class, $includesPath, $singleton = false)
    {
        require_once __DIR__ . "/includes/$includesPath";

        if ($class instanceof Closure) {
            give()->instance($alias, $class());
        } elseif ($singleton) {
            give()->instance($alias, $class::get_instance());
        } else {
            give()->instance($alias, new $class());
        }
    }
}
