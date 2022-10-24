<?php

/* Perfom all sql operations */
class ProductQuery
{
    private array $prodDict;

    public function __construct() {
        $ptype = array(
            "Book" => $this->insertBook(),
            "DVD" => $this->insertDVD(),
            "Furniture" => $this->insertFurniture()
        );
        $this->prodDict = $ptype;
    }

    public function getAll(): string
    {
        $query = 'SELECT * FROM prod;';
        return $query;
    }


    public function productExists(): string
    {
        $query = 'SELECT EXISTS(SELECT * FROM prod WHERE sku = (:sku));';
        return $query;
    }

    public function insert($type)
    {
        if (array_key_exists($type, $this->prodDict)) {
            return $this->prodDict[$type];
        } else {
            $response = http_response_code(500);
            return $response;
        }
    }

    private function insertBook(): string
    {
        $query = "INSERT INTO prod (sku, name, price, type, weight) 
        VALUES (:sku, :name, :price, 'Book', :weight)";
        return $query;
    }

    private function insertDVD(): string
    {
        $query = "INSERT INTO prod (sku, name, price, type, size) 
        VALUES (:sku, :name, :price, 'DVD', :size)";
        return $query;
    }

    private function insertFurniture(): string
    {
        $query =  "INSERT INTO prod (sku, name, price, type, height, width, length) 
        VALUES (:sku, :name, :price, 'Furniture', :height, :width, :length)";
        return $query;
    }
  
    public function delete(): string
    {
        $query = "DELETE FROM prod WHERE id IN (:productList)";
        return $query;
    }

}