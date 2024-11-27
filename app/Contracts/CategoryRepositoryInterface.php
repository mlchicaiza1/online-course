<?php

namespace App\Contracts;

use App\Dtos\CategoryDto;

interface CategoryRepositoryInterface
{
    public function all(): array;
    public function findById($id);
    public function create(CategoryDto $data);
    public function update($id, CategoryDto $data) ;
    public function delete($id): bool;


}
