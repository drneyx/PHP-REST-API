<?php


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

    public function selectAll(): string
    {
        return 'SELECT * FROM prod;';

    }

    public function exists(): string
    {
        return 'SELECT EXISTS(SELECT * FROM prod WHERE sku = (:sku));';
    }

    public function insert($type)
    {
        if (array_key_exists($type, $this->dict)) {
            return $this->prodDict[$type];
        } else {
            $response = http_response_code(500);
            return $response;
        }
    }

    private function insertDVD(): string
    {
        return "INSERT INTO product (sku, name, price, type, size) 
                VALUES (:sku, :name, :price, 'DVD', :size)";
    }
    private function insertFurniture(): string
    {
        return "INSERT INTO product (sku, name, price, type, height, width, length) 
                VALUES (:sku, :name, :price, 'Furniture', :height, :width, :length)";
    }
    private function insertBook(): string
    {
        return "INSERT INTO product (sku, name, price, type, weight) 
                VALUES (:sku, :name, :price, 'Book', :weight)";
    }

    public function delete(): string
    {
        return "DELETE FROM product WHERE id IN (:productList)";
    }

}