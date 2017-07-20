<?php
    include '../dbconfig.php';
    //Check the situation of log in 
    //Traversing the data and write data
    try {
        $con = new PDO("mysql:host=".$db_config["host"].";dbname=".$db_config["database"], $db_config["username"], $db_config["password"]);
        
        $arr_data = $_POST["data"];
        session_start();
        if(!isset($_SESSION["USER"])) {
             echo -1;
             die();
        }
        $id = $_SESSION["USER"]["id"];
        // var_dump($arr_data);
        $row = 0;
        foreach ($arr_data as $value) {
            $row += $con->exec("delete from saved_articles where articleID='$value' and subscriberID=$id");
        }
        $con = null;
        echo $row;
        
    } catch(PDOException $e) {
        echo array('Error:' => $e->getMessage());
        die();
    }   
    
?>

