<?php

require_once __DIR__."/../Modal/productDB.php";

class Util {

    private ProductDB $productDB;

    public function __construct()
    {
        $this->productDB = new ProductDB();
    }

    /* Add product to the DB */
    public function addProduct($data)
    {
        $data = json_decode($data, true);
        if ($data == null) {
            http_response_code(500);
            return false;
        }
        foreach ($data as $key => $value) {
            if ($value === "") {
                unset($data[$key]);
            }
        }
        return $this->productDB->addProduct($data);
    }


    /* Get list of all products */
    public function getAllProducts()
    {
        $all_products = $this->productDB->listAllProducts();
        return json_encode($all_products);
    }



    /* Mass delete of the products using product id's */
    public function massDeleteProducts($data) {

        $data = json_decode($data, true);
        $data = $data["productIds"];
        $newProducts = [];
        foreach ($data as $key => $value) {
            if ($value == true) {
                $newProducts[] = $value;
            }
        }
        return $this->productDB->massDelete($newProducts);
    }

}