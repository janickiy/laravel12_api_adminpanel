<?php

namespace App\Repositories;

use App\Models\Notes;

class NoteRepository extends BaseRepository
{
    public function __construct(Notes $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Notes|null
     */
    public function update(int $id, array $data): ?Notes
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->content = $data['content'];
            $model->save();

            return $model;
        }
        return null;
    }
}
