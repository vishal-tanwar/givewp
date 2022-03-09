<?php

namespace Give\Framework\QueryBuilder\Concerns;

use Give\Framework\Database\DB;
use Give\Framework\QueryBuilder\JoinQueryBuilder;
use Give\Framework\QueryBuilder\Clauses\MetaTable;
use Give\Framework\QueryBuilder\Clauses\RawSQL;
use Give\Framework\QueryBuilder\QueryBuilder;

/**
 * @since 2.19.0
 */
trait MetaQuery
{

    /**
     * @var MetaTable[]
     */
    private $metaTablesConfigs = [];

    /**
     * @var string
     */
    private $defaultMetaKeyColumn = 'meta_key';

    /**
     * @var string
     */
    private $defaultMetaValueColumn = 'meta_value';

    /**
     * @param string|RawSQL $table
     * @param string $metaKeyColumn
     * @param string $metaValueColumn
     *
     * @return $this
     */
    public function configureMetaTable($table, $metaKeyColumn, $metaValueColumn)
    {
        $this->metaTablesConfigs[] = new MetaTable(
            $table,
            $metaKeyColumn,
            $metaValueColumn
        );

        return $this;
    }

    /**
     * @param string|RawSQL $table
     *
     * @return MetaTable
     */
    protected function getMetaTable($table)
    {
        $tableName = QueryBuilder::prefixTable($table);

        foreach ($this->metaTablesConfigs as $metaTable) {
            if ($metaTable->tableName === $tableName) {
                return $metaTable;
            }
        }

        return new MetaTable(
            $table,
            $this->defaultMetaKeyColumn,
            $this->defaultMetaValueColumn
        );
    }

    /**
     * Select meta columns
     *
     * @param string|RawSQL $table
     * @param string $foreignKey
     * @param string $primaryKey
     * @param array $columns
     *
     * @return $this
     */
    public function attachMeta($table, $foreignKey, $primaryKey, ...$columns)
    {
        $metaTable = $this->getMetaTable($table);

        foreach ($columns as $i => $entry) {
            if (is_array($entry)) {
                list ($column, $columnAlias) = $entry;
            } else {
                $column = $entry;
                $columnAlias = null;
            }

            // Set dynamic alias
            $tableAlias = sprintf('%s_%s_%d', ($table instanceof RawSQL) ? $table->sql : $table, 'attach_meta', $i);

            if (strpos($column, '*')) {
                // Set temporary alias
                $tempTableAlias = $tableAlias . '_temp';

                $query = sprintf(
                    'CREATE TEMPORARY TABLE IF NOT EXISTS %s AS (SELECT DISTINCT meta_key as name FROM %s WHERE meta_key LIKE "%s")',
                    $tempTableAlias,
                    $metaTable->tableName,
                    str_replace('*', '%', $column)
                );

                DB::query($query);

                if ($metaColumns = DB::table(DB::raw($tempTableAlias))->getAll()) {
                    foreach ($metaColumns as $j => $column) {

                        $tableAlias = sprintf('%s_%d', $tempTableAlias, $i + $j);

                        $this->select(["{$tableAlias}.{$metaTable->valueColumnName}", $column->name]);

                        $this->join(
                            function (JoinQueryBuilder $builder) use ($table, $foreignKey, $primaryKey, $tableAlias, $column, $metaTable) {
                                $builder
                                    ->leftJoin($table, $tableAlias)
                                    ->on($foreignKey, "{$tableAlias}.{$primaryKey}")
                                    ->andOn("{$tableAlias}.{$metaTable->keyColumnName}", $column->name, true);
                            }
                        );
                    }
                }

            } else {

                $this->select(["{$tableAlias}.{$metaTable->valueColumnName}", $columnAlias ?: $column]);

                $this->join(
                    function (JoinQueryBuilder $builder) use ($table, $foreignKey, $primaryKey, $tableAlias, $column, $metaTable) {
                        $builder
                            ->leftJoin($table, $tableAlias)
                            ->on($foreignKey, "{$tableAlias}.{$primaryKey}")
                            ->andOn("{$tableAlias}.{$metaTable->keyColumnName}", $column, true);
                    }
                );

            }
        }

        return $this;
    }
}
