<?php

namespace Give\Forms\ValueObjects;

use Give\Framework\Support\ValueObjects\Enum;

/**
 * @method static FormStatus OPEN()
 * @method static FormStatus CLOSED()
 * @method bool isOpen()
 * @method bool isClosed()
 */
class FormStatus extends Enum
{
    const OPEN = 'open';
    const CLOSED = 'closed';
}
