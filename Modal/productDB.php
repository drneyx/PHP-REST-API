<?php

require_once __DIR__."/../classes.php";


class ProductDB
{
    private Dbh $db;
    private ProductQuery $query;
    private Validator $validator;
    private ProductFactory $factory;

    public function __construct()
    {
        $this->db = new Dbh();
        $this->query = new ProductQuery();
        $this->validator = new Validator();

        $this->factory = new ProductFactory(array(
            "DVD" => DVD::class,
            "Furniture" => Furniture::class,
            "Book" => Book::class
        ));


    }

    public function selectAll()
    {
        $products = $this->db->execute($this->query->selectAll())->fetchAll();

        $result = array();

        // Call factory object's method create with dict as params
        foreach ($products as $p) {
            $result[] = $this->factory->newProduct($p)->asDict();
        }

        return $result;

    }

    public function addProduct($dict): bool|string
    {
        $product = $this->validate($dict);

        if (is_bool($product)) {
            $response= http_response_code(400);
            return json_encode(array("skuErr" => true));
        }

        $params = $product->getParams();
        $product = $product->asDict();

        $query = $this->query->insert($product["type"]);
        try {
            $this->db->stmtPrepareAndExecute($query, $params);
        } catch (\Throwable $t) {
            return $t->getMessage();
        }

        $response= http_response_code(200);
        return true;

    }

    public function massDelete($idList)
    {
        $query = $this->query->delete();
        $inQuery = "";
        $params = array();
        foreach ($idList as $index => $value) {
            $inQuery = $inQuery.":product".$index.", ";
            $params[":product".$index] = $value;
        }

        $inQuery = substr($inQuery, 0, -2);
        $query = str_replace(":productList", $inQuery, $query);

        try {
            $this->db->stmtPrepareAndExecute($query, $params);
        } catch (\Throwable $t) {
            return $t->getMessage();
        }

    }

    private function validate($params): bool|Product
    {
        $rules = $this->factory->getRules($params);
        $valid = $this->validator->validate($params, $rules);

        if ($valid == false) {
            return false;
        }

        $query = $this->query->exists();
        try {
            $result = $this->db->stmtPrepareAndExecute($query, array(":sku" => $params["sku"]));
        } catch (\Throwable $t) {
            return $t->getMessage();
        }

        if ($result->fetch(PDO::FETCH_NUM)[0] == 1) {
            return false;
        }

        return $this->factory->newProduct($params);
    }


}