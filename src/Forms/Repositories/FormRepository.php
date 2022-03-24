<?php

namespace Give\Forms\Repositories;

use Give\Forms\Models\Form;
use Give\Framework\Models\ModelQueryBuilder;

class FormRepository
{
    /**
     * @param int $formId
     *
     * @return Form|null
     */
    public function getById($formId)
    {
        return $this->prepareQuery()
            ->where('ID', $formId)
            ->get();
    }

    /**
     * @return ModelQueryBuilder<Form>
     */
    protected function prepareQuery()
    {
        $builder = new ModelQueryBuilder(Form::class);

        return $builder->from('posts')
            ->select(
                ['ID', 'id'],
                ['post_date', 'createdAt'],
                ['post_modified', 'updatedAt'],
                ['post_status', 'status'],
                ['post_parent', 'parentId']
            );
    }
}
