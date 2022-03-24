<?php

namespace Give\Forms\ValueObjects;

use Give\Framework\Support\ValueObjects\EnumInteractsWithQueryBuilder;

class FormMetaKeys
{
    use EnumInteractsWithQueryBuilder;

    const MINIMUM_AMOUNT = '_give_custom_amount_range_minimum';
    const MAXIMUM_AMOUNT = '_give_custom_amount_range_maximum';
    const TEMPLATE = '_give_form_template';
    const STATUS = '_give_form_status';
    const PRICING_MODE = '_give_price_option';
    const ALLOW_CUSTOM_AMOUNT = '_give_custom_amount';
    const CUSTOM_AMOUNT_LABEL = '_give_custom_amount_text';
    const DONATION_LEVELS = '_give_donation_levels';
}
