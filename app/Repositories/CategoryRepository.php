<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getAllCategories()
    {
        return $this->model->all();
    }
}