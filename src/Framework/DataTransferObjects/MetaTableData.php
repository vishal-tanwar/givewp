<?php

namespace Give\Framework\DataTransferObjects;

/**
 * @unreleased
 */
class MetaTableData
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $primaryKey;
    /**
     * @var array
     */
    public $columns;

    /**
     * @param string $name
     * @param string $type
     * @param string $primaryKey
     * @param array $columns List of column aliases ['firstName' => '_give_donor_billing_first_name']
     */
    public function __construct($name, $type, $primaryKey, $columns)
    {
        $this->name = $name;
        $this->type = $type;
        $this->primaryKey = $primaryKey;
        $this->columns = $columns;
    }
}
