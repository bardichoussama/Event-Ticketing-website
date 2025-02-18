<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct( CategoryRepository $eventRepository)
    {
        $this->categoryRepository = $eventRepository;
    }

   
}