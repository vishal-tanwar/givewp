<?php

namespace Give\Forms\ValueObjects;

use Give\Framework\Support\ValueObjects\Enum;

/**
 * @unreleased
 *
 * @method static MULTI_LEVEL()
 * @method static SET_AMOUNT()
 * @property-read bool $isMultiLevel
 * @property-read bool $isSetAmount
 */
class PriceMode extends Enum
{
    const MULTI_LEVEL = 'multi';
    const SET_AMOUNT = 'set';
}
