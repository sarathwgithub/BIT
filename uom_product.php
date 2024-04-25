<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\FoodItemDishOptionModel;

class Product extends BaseController {

    public function index() {
        helper('form');
        $product = new ProductModel();
        $data['product'] = $product->select('fooditem.*,category.Description AS Category')->join('category', 'category.Id=fooditem.CategoryId', 'inner')->findAll();

        $dishOptions = [];
        foreach ($data['product'] as $product) {
            $foodItemId = $product['Id'];
            $dishOptions[$foodItemId] = $this->getDishOptionsForProduct($foodItemId);
        }
        $data['dishOptions'] = $dishOptions;

        return view('product/view', $data);
    }

    protected function getDishOptionsForProduct($foodItemId) {
        $foodItemDishOptionModel = new FoodItemDishOptionModel();
        $options = $foodItemDishOptionModel->select('dishoption.Id,dishoption.Description')
                ->join('dishoption', 'dishoption.Id = fooditemdishoption.DishOptionId', 'inner')
                ->where('fooditemdishoption.FoodItemId', $foodItemId)
                ->findAll();

        return $options;
    }
}
