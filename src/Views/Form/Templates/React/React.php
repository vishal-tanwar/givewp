<?php

namespace Give\Views\Form\Templates\React;

use Give\Form\Template;

/**
 * @unreleased
 */
class React extends Template
{
    /**
     * @inheritDoc
     */
    public function getID()
    {
        return 'react';
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return __('React Form', 'give');
    }

    /**
     * @inheritDoc
     */
    public function getImage()
    {
        return GIVE_PLUGIN_URL . 'assets/dist/images/admin/template-preview-legacy.png';
    }

    /**
     * @inheritDoc
     */
    public function getOptionsConfig()
    {
        return null;
    }
}
