<?php

namespace Give\Forms\Properties;

use Give\Forms\ValueObjects\PriceMode;

class DonationOptions
{
    /**
     * @var PriceMode
     */
    public $priceMode;

    /**
     * @var bool
     */
    public $allowCustomAmount;

    /**
     * @var int
     */
    public $maximumAmount;

    /**
     * @var int
     */
    public $minimumAmount;

    /**
     * @var string
     */
    public $customAmountLabel;

    /**
     * @var DonationLevel[]
     */
    public $donationLevels;

    /**
     * Returns the lowest amount for the donation levels.
     *
     * @unreleased
     *
     * @return int
     */
    public function minimumDonationLevelAmount()
    {
        return min(array_column($this->donationLevels, 'amount'));
    }

    /**
     * Returns the highest amount for the donation levels.
     *
     * @unreleased
     *
     * @return int
     */
    public function maximumDonationLevelAmount()
    {
        return max(array_column($this->donationLevels, 'amount'));
    }
}
