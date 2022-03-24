<?php

namespace Give\Forms\Models;

use Give\Forms\ValueObjects\FormStatus;
use Give\Framework\Models\Contracts\ModelCrud;
use Give\Framework\Models\Contracts\ModelHasFactory;
use Give\Framework\Models\Model;

class Form extends Model implements ModelCrud, ModelHasFactory
{
    protected $properties = [
        'id' => 'int',
        'status' => FormStatus::class,
    ];

    public static function find($id)
    {
        // TODO: Implement find() method.
    }

    public static function create(array $attributes)
    {
        // TODO: Implement create() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public static function query()
    {
        // TODO: Implement query() method.
    }

    public static function fromQueryBuilderObject($object)
    {
        // TODO: Implement fromQueryBuilderObject() method.
    }

    public static function factory()
    {
        // TODO: Implement factory() method.
    }
}
