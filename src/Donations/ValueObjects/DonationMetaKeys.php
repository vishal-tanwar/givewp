<?php

namespace Give\Donations\ValueObjects;

use MyCLabs\Enum\Enum;

/**
 * @unreleased
 *
 * @method static AMOUNT()
 * @method static CURRENCY()
 * @method static GATEWAY()
 * @method static DONOR_ID()
 * @method static FIRST_NAME()
 * @method static LAST_NAME()
 * @method static DONOR_EMAIL()
 * @method static SUBSCRIPTION_ID()
 * @method static MODE()
 * @method static FORM_ID()
 * @method static FORM_TITLE()
 * @method static BILLING_COUNTRY()
 * @method static BILLING_ADDRESS1()
 * @method static BILLING_ADDRESS2()
 * @method static BILLING_CITY()
 * @method static BILLING_STATE()
 * @method static BILLING_ZIP()
 * @method static PURCHASE_KEY()
 * @method static DONOR_IP()
 * @method static ANONYMOUS()
 * @method static LEVEL_ID()
 * @method static COMPANY()
 * @method public getKeyAsCamelCase()
 */
class DonationMetaKeys extends Enum
{
    const AMOUNT = '_give_payment_total';
    const CURRENCY = '_give_payment_currency';
    const GATEWAY = '_give_payment_gateway';
    const DONOR_ID = '_give_payment_donor_id';
    const FIRST_NAME = '_give_donor_billing_first_name';
    const LAST_NAME = '_give_donor_billing_last_name';
    const DONOR_EMAIL = '_give_payment_donor_email';
    const SUBSCRIPTION_ID = 'subscription_id';
    const MODE = '_give_payment_mode';
    const FORM_ID = '_give_payment_form_id';
    const FORM_TITLE = '_give_payment_form_title';
    const BILLING_COUNTRY = '_give_donor_billing_country';
    const BILLING_ADDRESS2 = '_give_donor_billing_address2';
    const BILLING_CITY = '_give_donor_billing_city';
    const BILLING_ADDRESS1 = '_give_donor_billing_address1';
    const BILLING_STATE = '_give_donor_billing_state';
    const BILLING_ZIP = '_give_donor_billing_zip';
    const PURCHASE_KEY = '_give_payment_purchase_key';
    const DONOR_IP = '_give_payment_donor_ip';
    const ANONYMOUS = '_give_anonymous_donation';
    const LEVEL_ID = '_give_payment_price_id';
    const COMPANY = '_give_donation_company';

    /**
     * @unreleased
     *
     * @return array
     */
    public static function getAllKeys()
    {
        return array_values(static::toArray());
    }

    /**
     * @unreleased
     *
     * Returns array of meta aliases to be used with attachMeta
     *
     * [ ['_give_payment_total', 'amount'], etc. ]
     *
     * @return array
     */
    public static function getColumnsForQuery()
    {
        $columns = [];

        foreach (static::toArray() as $key => $value) {
            $keyFormatted = static::camelCaseConstant($key);

            $columns[] = [$value, $keyFormatted];
        }

        return $columns;
    }

    /**
     * @unreleased
     *
     * @param  string  $name
     * @return string
     */
    public static function camelCaseConstant($name)
    {
        return lcfirst(str_replace('_', '', ucwords(strtolower($name), '_')));;
    }

    /**
     * @return string
     */
    public function getKeyAsCamelCase()
    {
        return static::camelCaseConstant($this->getKey());
    }
}
