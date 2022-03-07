<?php

namespace Give\Framework\Support\ValueObjects;

trait EnumInteractsWithQueryBuilder
{
    /**
     * @unreleased
     *
     * Returns array of meta aliases to be used with attachMeta
     *
     * [ ['_give_payment_total', 'amount'], etc. ]
     *
     * @return array
     */
    public static function getColumnsForAttachMetaQuery()
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
     * Returns array of meta aliases with corresponding columns
     *
     * [ ['firstName' => '_give_donor_billing_first_name'], etc. ]
     *
     * @return array
     */
    public static function getColumnsAliases()
    {
        $properties = [];

        foreach (static::toArray() as $key => $value) {
            $keyFormatted = static::camelCaseConstant($key);

            $properties[$keyFormatted] = $value;
        }

        return $properties;
    }
}
