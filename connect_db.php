<?php
class database{
  private $host = "localhost";
  private $db_name = "project5556";
  private $username = "root";
  private $password = "";
  private $conn;

  // connect database using MYSQLI
  function connect_mysqli(){

    //used to caught mysqli error in catch statement
    // mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL); 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

    try{
      $this->conn = new mysqli($this->host, $this->username, $this->password);//, $this->db_name);
      
      // Create database
      $sql = "CREATE DATABASE IF NOT EXISTS ".$this->db_name;
      $this->conn->query($sql);
      // $this->conn->prepare($sql)->execute();

      
      $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

      $sql = "CREATE TABLE IF NOT EXISTS users (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        password varchar(520) NOT NULL,
        status tinyint(1) NOT NULL,
        registration_key varchar(255) DEFAULT NULL,
        reset_password_key varchar(255) DEFAULT NULL,
        created_at timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (id)
      )";
      $this->conn->query($sql);

      $sql1 = "CREATE TABLE IF NOT EXISTS `recipes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(1200) NOT NULL,
        `image` text NOT NULL ,
        `description` text NOT NULL,
        `ingredients` text NOT NULL,
        `details` text NOT NULL,
        `user_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (id)
      )";
      $this->conn->query($sql1);

      $sql1 = "CREATE TABLE IF NOT EXISTS `share_recipes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `recipe_owner_id` int(11) NOT NULL,
        `recipe_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        `status` varchar(255) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (id)
      )";
      $this->conn->query($sql1);

       $sql1 = "CREATE TABLE IF NOT EXISTS `ingredients` (
           `id` int(11) NOT NULL AUTO_INCREMENT,
           `name` varchar(255) NOT NULL,
           `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
           `user_id` int(11) NOT NULL,
           PRIMARY KEY (`id`)
          )";
      $this->conn->query($sql1);

      $sql1 = "CREATE TABLE IF NOT EXISTS `receipe_ingredients` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `receipe_id` int(11) NOT NULL,
             `ingredient_id` int(11) NOT NULL,
             PRIMARY KEY (`id`)
          )";
      $this->conn->query($sql1);
            // if ($this->conn->query($sql) === TRUE) {
      //   echo "Database created successfully";
      // } else {
      //   echo "Error creating database: " . $this->conn->error;
      // }

      return $this->conn;
    }
    catch (mysqli_sql_exception $ex){
      echo "Connection Error -->> ",$ex->getMessage();
      echo "<br>Error Code -->> ",$ex->getCode();
      echo "<br>Error occur in File -->> ",$ex->getFile();
      echo "<br>Error occur on Line no -->> ",$ex->getLine();

      $this->conn->close(); // close connection in Mysqli
      // OR
      //die('Connection error:   ' . mysqli_connect_error());
    }
 
    // if ($this->conn->connect_errno )
    //   die("Connection Error:<br>" . $this->conn->connect_error);
    
  }

  

}//end of class



?>