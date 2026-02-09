<?php

namespace App\Repositories;

use App\Models\Catalog;

class CatalogRepository extends BaseRepository
{
    public function __construct(Catalog $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Catalog|null
     */
    public function update(int $id, array $data): ?Catalog
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->name = $data['name'];
            $model->save();

            return $model;
        }
        return null;
    }
}
