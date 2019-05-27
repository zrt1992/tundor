<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ProductRepositoryInterface;
//use App\Entity\Product;

class ProductRepository implements ProductRepositoryInterface
{

    public function search($name)
    {
        return "seach";
//        return Product::where('title', 'LIKE', '% ' . $name . '%')
//            ->get();
    }

    public function getAllByUser($user_id)
    {
        return "get all by user";
//        return Product::where('user_id', '=', $user_id)
//            ->get();
    }

    public function getAllByCategory($category_id)
    {
        return "get all by cat";
        return Product::where('category_id', '=', $category_id)
            ->get();
    }
}