<?php

namespace Give\Forms\DataTransferObjects;

class FormQueryData
{
    /**
     * @var int
     */
    public $id;


    public static function fromQueryObject($queryObject)
    {
        $form = new static();

        $form->id = (int) $queryObject->ID;
    }
}
