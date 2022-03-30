<?php

namespace Give\Forms\Models;

use Give\Forms\Properties\DonationOptions;
use Give\Forms\ValueObjects\FormStatus;
use Give\Framework\Models\Contracts\ModelCrud;
use Give\Framework\Models\Contracts\ModelHasFactory;
use Give\Framework\Models\Model;

/**
 * @unreleased
 *
 * @property int $id
 * @property FormStatus $status
 * @property DonationOptions $donationOptions
 */
class Form extends Model implements ModelCrud, ModelHasFactory
{
    protected $properties = [
        'id' => 'int',
        'status' => FormStatus::class,
        'donationOptions' => DonationOptions::class,
    ];

    public static function find($id)
    {
        return give()->forms->getById($id);
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
