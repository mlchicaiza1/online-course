<?php

namespace App\Repositories;
use Spatie\LaravelData\Data;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TDto
 */
abstract class BaseRepository
{
    protected Model $model;
    protected Data $dto;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Especifica la clase del DTO a usar.
     *
     * @return class-string<TDto>
     */
    abstract protected function getDtoClass(): string;

    /**
     * Convierte un modelo en su correspondiente DTO.
     *
     * @param Model|null $model
     * @return TDto|null
     */
    protected function toDto($model)
    {
        $dtoClass = $this->getDtoClass();
        return $model ? $dtoClass::from($model) : null;
    }

    /**
     * Convierte una colección de modelos en una colección de DTOs.
     *
     * @param \Illuminate\Support\Collection|array $models
     * @return array<TDto>
     */
    protected function toDtoCollection($models): array
    {
        $dtoClass = $this->getDtoClass();

        // Convertir cada modelo en su correspondiente DTO
        return $models->map(fn($model) => $dtoClass::from($model))->toArray();
    }

    /**
     * Devuelve todos los registros como DTOs.
     *
     * @return array<TDto>
     */
    public function all(array $relations = [], array $filters = []): array
    {
        $query = $this->model->query();
        if (!empty($relations)) {
            $query->with($relations);
        }
        foreach ($filters as $field => $value) {
            if (is_array($value)) {
                $query->where(...$value);
            } else {
                $query->where($field, $value);
            }
        }
        return $this->toDtoCollection($query->get());
    }

    /**
     * Encuentra un registro por ID y lo retorna como DTO.
     *
     * @param mixed $id
     * @return TDto|null
     */
    public function findById($id,array $relations = [])
    {
        $query = $this->model;
        if (!empty($relations)) {
            $query = $query->with($relations);
        }
        return $this->toDto($query->find($id));
    }

    /**
     * Crea un nuevo registro y lo retorna como DTO.
     *
     * @param array $data
     * @return TDto
     */
    public function create(Data $data)
    {
        $this->model->fill($data->toArray());
        $this->model->save();
        return $this->toDto($this->model);
    }

    /**
     * Actualiza un registro existente y lo retorna como DTO.
     *
     * @param mixed $id
     * @param array $data
     * @return TDto|null
     */
    public function update($id, Data $data)
    {
        $this->model = $this->model->find($id);

        if ($this->model) {
            $dtoWithoutNulls = array_filter($data->toArray(), static function($value){ return isset($value); });
            $this->model->fill($dtoWithoutNulls)->save();
            return $this->toDto($this->model);
        }
        return null;
    }

    /**
     * Elimina un registro por ID.
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool
    {
        $model = $this->model->find($id);
        return $model ? $model->delete() : false;
    }
}
