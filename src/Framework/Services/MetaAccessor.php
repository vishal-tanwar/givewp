<?php

namespace Give\Framework\Services;

use Give\Framework\DataTransferObjects\MetaTableData;
use Give\Framework\Models\ModelWithMeta;

/**
 * @unreleased
 */
class MetaAccessor
{
    /**
     * @var int
     */
    private $model;

    /**
     * Model meta
     *
     * @var array
     */
    private $meta = [];

    /**
     * @var MetaTableData
     */
    private $metaTable;

    /**
     * @param ModelWithMeta $model
     */
    public function __construct(ModelWithMeta $model)
    {
        $this->model = $model;
        $this->metaTable = $model::metaTable();

        $this->registerMetaTable();
    }

    /**
     * @unreleased
     * @param $key
     * @return array|false|string|null
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @unreleased
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * @unreleased
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->meta[$key]);
    }

    /**
     * Get meta by key
     *
     * @unreleased
     * @param string $key
     * @param bool $single
     *
     * @return string|array|false|null
     */
    public function get($key, $single = true)
    {
        if (!isset($this->meta[$key])) {
            $this->meta[$key] = get_metadata(
                $this->metaTable->type,
                $this->model->id,
                $key,
                $single
            );
        }

        return $this->meta[$key];
    }

    /**
     * Set value for meta key
     *
     * @unreleased
     * @param string $key
     * @param mixed $value
     * @param bool $single
     *
     * @return $this
     */
    public function set($key, $value, $single = false)
    {
        if (isset($this->meta[$key]) && !$single) {
            $this->meta[$key] = array_merge(
                (array)$this->get($key),
                (array)$value
            );
        } else {
            $this->meta[$key] = $value;
        }

        return $this;
    }

    /**
     * Get all meta
     *
     * @unreleased
     * @return array
     */
    public function getAll()
    {
        return array_merge(['todo: current model meta'], $this->meta);
    }

    /**
     * Register table
     */
    protected function registerMetaTable()
    {
        global $wpdb;
    }
}
