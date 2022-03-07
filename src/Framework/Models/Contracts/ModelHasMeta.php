<?php

namespace Give\Framework\Models\Contracts;

use Give\Framework\DataTransferObjects\MetaTableData;

/**
 * @unreleased
 */
interface ModelHasMeta
{
    /**
     * @return MetaTableData
     */
    public static function metaTable();
}
