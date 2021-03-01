<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractService
{
    protected $model;

    public function loadAll() {
        $class = get_class($this->model);
        $obj = new $class;

        return $obj->get();
    }

    public function loadByName(string $name = null, bool $like = false): ?Collection {
        $query = $this->model->orderBy('name');
        if (!empty($name)) {
            if ($like) {
                $query->where('name', 'like', '%' . $name . '%');
            } else {
                $query->whereName($name);
            }
        }

        return $query->get();
    }

    public function loadNameAndIdOnly(): ?Collection {
        if (in_array('name', $this->model->getFillable())) {
            return $this->model->orderBy('name')->pluck('name', 'id');
        }

        return null;
    }

    public function find(string $uuid): Model {
        if (!$record = $this->model->find($uuid)) {
            throw new ModelNotFoundException(get_class($this->model) . " with uuid $uuid doesn't exists!" );
        }

        return $record;
    }

    public function save(Request $request, Model $model = null): Model {

        $class = get_class($this->model);

        if (!is_null($model) && !empty($model->id)) {

            if (!$model->update($request->all())) {
                throw new \Exception("Fail on update " . $class .
                    " with values: " . collect($request->all())->toJson());
            }

        } else {
            if (!$model = $class::create($request->all())) {
                throw new \Exception("Fail on create " . $class . " with values: "
                    . collect($request->all())->toJson());
            }

        }

        return $model;
    }

    public function delete(string $uuid): Model {
        $class = get_class($this->model);

        if (!$this->model = $this->model->find($uuid)) {
            throw new ModelNotFoundException($class . ' with uuid $uuid doesn\'t exists!' );
        }

        if (!$this->model->delete()) {
            throw new \Exception('Fail on delete ' . $class . " with uuid $uuid" );
        }

        return $this->model;
    }
}
