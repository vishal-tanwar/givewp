<?php

namespace Give\Forms\ValueObjects;

use Give\Framework\Support\ValueObjects\Enum;

/**
 * @method static GoalDisplayFormat TOTAL()
 * @method static GoalDisplayFormat PERCENTAGE()
 * @method bool isTotal()
 * @method bool isPercentage()
 */
class GoalDisplayFormat extends Enum
{
    const TOTAL = 'total';
    const PERCENTAGE = 'percentage';
}
