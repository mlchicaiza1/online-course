<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use App\Dtos\CategoryDto;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): array
    {
        return $this->categoryRepository->all();
    }

    public function findCategoryById($id): ?CategoryDto
    {
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(CategoryDto $data): ?CategoryDto
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, CategoryDto $data): ?CategoryDto
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id):bool
    {
        return $this->categoryRepository->delete($id);
    }
}
