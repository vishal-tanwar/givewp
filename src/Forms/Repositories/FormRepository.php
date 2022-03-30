<?php

namespace Give\Forms\Repositories;

use Give\Forms\Models\Form;
use Give\Framework\Database\DB;
use Give\Framework\Models\ModelQueryBuilder;
use Give\Helpers\Hooks;

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

    public function insert(Form $form)
    {
    }

    public function update(Form $form)
    {
    }

    public function delete(Form $form)
    {
        Hooks::doAction('give_form_deleting', $form);

        DB::transaction(static function() use($form) {
            DB::table('posts')
                ->where('id', $form->id)
                ->delete();

            DB::table('give_formmeta')
                ->where('form_id', $form->id)
                ->delete();
        });

        Hooks::doAction('give_form_deleted', $form);
    }

    /**
     * @return ModelQueryBuilder<Form>
     */
    public function prepareQuery()
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
