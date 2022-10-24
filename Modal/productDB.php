<?php

require_once __DIR__."/../classes.php";

/* Product Modal */
class ProductDB
{
    private Dbh $db;
    private ProductQuery $query;
    private Validator $validator;
    private Factory $productFactory;

    public function __construct()
    {
        $this->db = new Dbh();
        $this->query = new ProductQuery();
        $this->validator = new Validator();

        $this->productFactory = new Factory(array(
            "DVD" => DVD::class,
            "Furniture" => Furniture::class,
            "Book" => Book::class
        ));


    }

    /* Get all products */
    public function listAllProducts()
    {
        $products = $this->db->execute($this->query->getAll())->fetchAll();
        $result = array();

        foreach ($products as $p) {
            $result[] = $this->productFactory->factProduct($p)->asDict();
        }

        return $result;

    }

    /* Add new product to the db modal */
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
        http_response_code(200);
        return true;

    }

    /* Perfom validation first before add and return product instance */
    private function validate($params): bool|Product
    {
        $rules = $this->productFactory->getRules($params);
        $valid = $this->validator->validate($params, $rules);

        if ($valid == false) {
            return false;
        }

        $query = $this->query->productExists();
        try {
            $result = $this->db->stmtPrepareAndExecute($query, array(":sku" => $params["sku"]));
        } catch (\Throwable $t) {
            return $t->getMessage();
        }

        if ($result->fetch(PDO::FETCH_NUM)[0] == 1) {
            return false;
        }

        return $this->productFactory->factProduct($params);
    }

    /* Delete multiple products from the database */
    public function massDelete($idList)
    {
        $query = $this->query->deleteProducts($idList);
        $inQuery = "";
        $params = array();
        foreach ($idList as $index => $value) {
            $inQuery = $inQuery.":prod".$index.", ";
            $params[":prod".$index] = $value;
        }

        $inQuery = substr($inQuery, 0, -2);
        $query = str_replace(":productIds", $inQuery, $query);

        try {
            $this->db->stmtPrepareAndExecute($query, $params);
            return json_encode("success");
            
        } catch (\Throwable $t) {
            return $t->getMessage();
        }
    }
}