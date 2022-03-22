<?php

namespace Give\PaymentGateways\Gateways\Stripe\Traits\StripeApi;

use Exception;
use Give\PaymentGateways\Gateways\Stripe\Exceptions\StripeApiRequestException;
use Give\PaymentGateways\Stripe\ApplicationFee;
use Stripe\Source;

/**
 * @unreleased
 */
class CreateSource
{
    /**
     * @unreleased
     *
     * @param array $stripeSourceRequestArgs
     *
     * @return Source
     * @throws StripeApiRequestException
     */
    public function createCharge($stripeSourceRequestArgs)
    {
        give_stripe_set_app_info();

        try {
            // Charge application fee, only if the Stripe premium add-on is not active.
            if (ApplicationFee::canAddfee()) {
                $stripeSourceRequestArgs['application_fee_amount'] = give_stripe_get_application_fee_amount(
                    $stripeSourceRequestArgs['amount']
                );
            }

            return Source::create(
                $stripeSourceRequestArgs,
                give_stripe_get_connected_account_options()
            );
        } catch (Exception $e) {
            throw new StripeApiRequestException(
                sprintf(
                /* translators: 1: Exception Error Message */
                    esc_html__('Unable to create a successful source. Details: %1$s', 'give'),
                    $e->getMessage()
                )
            );
        }
    }
}
