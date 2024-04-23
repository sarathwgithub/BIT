<?php

namespace App\Controllers;

class Mycart extends BaseController {

    
// Call the cart service using the helper function
    public function addCart() {
        $cart = cart();
        $cart->insert(array(
            'id' => 'sku_3456ABCD',
            'qty' => 2,
            'price' => '25.56',
            'name' => 'T-Shirt',
            'options' => array('Size' => 'L', 'Color' => 'Red')
        ));
    }

    public function updateCart() {
        $cart = cart();
        $cart->update(array(
            'rowid' => '68afdf4aa4d7e6551d9eac132c008749',
            'id' => 'sku_1234ABCD',
            'qty' => 5,
            'price' => '24.89',
            'name' => 'T-Shirt',
            'options' => array('Size' => 'L', 'Color' => 'Red')
        ));
    }

    public function getTotalItems() {
        $cart = cart();
        echo $cart->totalItems();
    }

    public function removeItem() {
          $cart = cart();
        $cart->remove('68afdf4aa4d7e6551d9eac132c008749');
    }
    public function viewCart() {
        $cart = cart();
        $c = $cart->contents();
        print_r($c);
    }
    public function clearCart(){
         $cart = cart();
        $cart->destroy();
    }

}


