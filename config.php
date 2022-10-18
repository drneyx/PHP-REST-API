<?php
	class Config {
	  
        // Database credentials for connection
	  private const DBHOST = 'localhost';
	  private const DBUSER = 'root';
	  private const DBPASS = 'root';
	  private const DBNAME = 'rest';
	  private $dsn = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME . '';
	  protected $conn = null;

	  // Constructor Function
	  public function __construct() {
	    try {
	      $this->conn = new PDO($this->dsn, self::DBUSER, self::DBPASS);
	      $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	    } catch (PDOException $e) {
	      die('Connectionn Failed : ' . $e->getMessage());
	    }
	    return $this->conn;
	  }

	  // Sanitize Inputs
	  public function test_input($data) {
	    $data = strip_tags($data);
	    $data = htmlspecialchars($data);
	    $data = stripslashes($data);
	    $data = trim($data);
	    return $data;
	  }

	  // JSON Format Converter Function
	  public function message($content, $status) {
	    return json_encode(['message' => $content, 'error' => $status]);
	  }
	}

?>