<?php

namespace Give\Framework\Models;

use Give\Framework\Models\Contracts\ModelHasMeta;
use Give\Framework\Services\MetaAccessor;

/**
 * @unreleased
 */
abstract class ModelWithMeta extends Model implements ModelHasMeta
{
    /**
     * @var MetaAccessor
     */
    public $meta;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->meta = new MetaAccessor($this);
    }
}
