<?php
namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function search($name);

    public function getAllByUser($user_id);

    public function getAllByCategory($category_id);
}