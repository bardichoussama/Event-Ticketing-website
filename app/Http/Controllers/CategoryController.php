<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Models\Category;


class CategoryController extends Controller
{
    // protected $categoryRepository;

    // public function __construct(CategoryRepository $categoryRepository)
    // {
    //     $this->categoryRepository = $categoryRepository;
    // }
    // public function index()
    // {
    //     return response()->json($this->categoryRepository->getAllCategories());
    // }
    public function index()
    {   
        return response()->json( Category::all());
    }
}
