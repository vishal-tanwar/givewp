<?php

namespace Give\Forms\ValueObjects;

use Give\Framework\Support\ValueObjects\Enum;

/**
 * @method static GoalType AMOUNT_RAISED()
 * @method static GoalType TOTAL_DONORS()
 * @method static GoalType TOTAL_DONATIONS()
 * @method bool isAmountRaised()
 * @method bool isTotalDonors()
 * @method bool isTotalDonations()
 */
class GoalType extends Enum
{
    const AMOUNT_RAISED = 'amount';
    const TOTAL_DONATIONS = 'donations';
    const TOTAL_DONORS = 'donors';
}
