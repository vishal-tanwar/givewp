<?php

namespace Give\Forms\ValueObjects;

use Give\Framework\Support\ValueObjects\Enum;

class FieldSetting extends Enum
{
    const USE_GLOBAL = 'global';
    const REQUIRED = 'required';
    const OPTIONAL = 'optional';
    const DISABLED = 'disabled';
}
