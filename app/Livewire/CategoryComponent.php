<?php

namespace App\Livewire;

use App\Dtos\CategoryDto;
use App\Services\CategoryService;
use Livewire\Component;

class CategoryComponent extends Component
{
    public $categories, $name, $categoryId;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required:categories,name',
    ];

    protected $listeners = ['deleteCategory'];

    protected $categoryService;

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = $this->categoryService->getAllCategories();
    }

    public function createCategory()
    {
        $this->validate();

        $this->categoryService->createCategory(CategoryDto::from(['name' => $this->name]));

        $this->resetForm();
        $this->loadCategories();

        session()->flash('success', 'Category created successfully!');
    }

    public function editCategory($id)
    {
        $category = $this->categoryService->findCategoryById($id);

        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->isEdit = true;
    }

    public function updateCategory()
    {
        $this->validate();

        $this->categoryService->updateCategory($this->categoryId, CategoryDto::from(['name' => $this->name]));

        $this->resetForm();
        $this->loadCategories();

        session()->flash('success', 'Category updated successfully!');
    }

    public function confirmDeleteCategory($id)
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    public function deleteCategory($id)
    {
        $this->categoryService->deleteCategory($id);

        $this->loadCategories();

        session()->flash('success', 'Category deleted successfully!');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->categoryId = null;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.category-component');
    }
}
