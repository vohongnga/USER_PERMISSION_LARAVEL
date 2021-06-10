<?php

namespace App\Repositories;

/**
 * Interface RepositoryInterface
 *
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param  integer|string  $id
     * @param array $columns
     * @return mixed
     */
    public function findById($id, $columns = ['*']);

    /**
     * @param  array  $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param  array  $attributes
     * @param  integer|string  $id
     * @return mixed
     */
    public function update(array $attributes, $id);

    /**
     * @param  integer|string  $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Retrieve all data of repository, paginated
     *
     * @param integer $limit
     * @param array $columns
     * @return mixed
     */
    public function paginate($limit = 10, $columns = ['*']);

    /** Function get paginate value
     *
     * @param $parameters
     * @return mixed
     */
    public function handlePaginate($parameters);

    /**
     * Find data by field and value
     *
     * @param  string  $field
     * @param  string  $value
     * @return mixed
     */
    public function findByField($field, $value);

    /** Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = []);
}
