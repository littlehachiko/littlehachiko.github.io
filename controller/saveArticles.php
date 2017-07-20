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
        
        foreach ($arr_data as $value) {
            # code...
            $title = $value["title"];
            $link = $value["link"];
            $description = str_replace("'", "''", $value["description"]);
            $date = date('o/m/d/ H:i:s');
            $row = $con->prepare("insert into saved_articles(articleID, subscriberID, link, title, description, dateSaved) values('$link', $id, '$link', '$title', '$description', '$date')");
            $row->execute();
            
        }
        $con = null;
        echo 0;
        
    } catch(PDOException $e) {
        echo array('error:' => $e->getMessage());
        die();
    }   
    
?>

