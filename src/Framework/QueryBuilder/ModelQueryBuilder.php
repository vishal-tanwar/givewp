<?php

namespace Give\Framework\QueryBuilder;

use Give\Framework\Exceptions\Primitives\InvalidArgumentException;
use Give\Framework\Models\Contracts\ModelCrud;
use Give\Framework\Models\Contracts\ModelHasMeta;
use Give\Framework\QueryBuilder\Types\Operator;

/**
 * @unreleased
 */
class ModelQueryBuilder extends QueryBuilder
{
    /**
     * @var string
     */
    private $model;

    /**
     * @var array
     */
    private $tableJoins = [];

    /**
     * @param string $model
     */
    public function __construct($model)
    {
        if (!is_subclass_of($model, ModelCrud::class)) {
            throw new InvalidArgumentException("$model must be an instance of " . ModelCrud::class);
        }

        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function where($column, $value = null, $comparisonOperator = '=')
    {
        return $this->setModelWhere(
            $column,
            $value,
            $comparisonOperator,
            Operator::_AND
        );
    }

    /**
     * @inheritDoc
     */
    public function orWhere($column, $value = null, $comparisonOperator = '=')
    {
        return $this->setModelWhere(
            $column,
            $value,
            $comparisonOperator,
            Operator::_OR
        );
    }

    /**
     * @inheritDoc
     *
     * @unreleased
     */
    public function get($output = OBJECT)
    {
        return ($row = parent::get($output))
            ? ($this->model)::fromQueryBuilderObject($row)
            : null;
    }

    /**
     * @inheritDoc
     *
     * @unreleased
     */
    public function getAll($output = OBJECT)
    {
        $model = $this->model;
        $results = parent::getAll($output);

        return $results ? array_map(static function ($object) use ($model) {
            return $model::fromQueryBuilderObject($object);
        }, $results) : null;
    }

    /**
     * @unreleased
     *
     * @param string $column
     * @param mixed $value
     * @param string $comparisonOperator
     * @param string $logicalOperator
     *
     * @return $this
     */
    private function setModelWhere($column, $value, $comparisonOperator, $logicalOperator)
    {
        // Handle meta properties
        if (is_subclass_of($this->model, ModelHasMeta::class)) {
            $metaTable = ($this->model)::metaTable();

            if (array_key_exists($column, $metaTable->columns)) {

                $tableAlias = 'meta_qb_' . strtolower($column);

                if ($logicalOperator === Operator::_AND) {
                    parent::where("{$tableAlias}.meta_key", $metaTable->columns[$column]);
                } else {
                    parent::orWhere("{$tableAlias}.meta_key", $metaTable->columns[$column]);
                }

                parent::where(
                    "{$tableAlias}.meta_value",
                    $value,
                    $comparisonOperator
                );

                // Only one join per column
                if (!in_array($tableAlias, $this->tableJoins, true)) {
                    $this->leftJoin(
                        $metaTable->name,
                        'id',
                        "{$tableAlias}.{$metaTable->primaryKey}",
                        $tableAlias
                    );

                    $this->tableJoins[] = $tableAlias;
                }

                return $this;
            }
        }

        // Todo: handle parent table properties

        return $this->setWhere(
            $column,
            $value,
            $comparisonOperator,
            $logicalOperator
        );
    }
}
