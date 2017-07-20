<?php
    include '../dbconfig.php';

    //Check wether eamil has been registed
    //Encrypt password and write into database md5($str)

    try {
        $con = new PDO("mysql:host=".$db_config["host"].";dbname=".$db_config["database"], $db_config["username"], $db_config["password"]);
        
        $email = $_POST["email"];
        $name = $_POST["name"];
        $psd = md5($_POST["password"]);

        $query_email = $con
                         ->query("select email from subscriber where email='$email'")
                         ->fetchAll();

        if(count($query_email) > 0) {
            $con = null;
            echo "<script>alert('This Email already regist!');history.go(-1)</script>";
        } else {
            $result = $con->exec("insert into subscriber(email, name, password) values ('$email','$name','$psd')");
            $con = null;
            echo "<script>alert('Regist operation finished!');location.href='../login.php'</script>";
        }

        
        
        
    } catch(PDOException $e) {
        print "Error:".$e->getMessage();
        die();
    }   
    
?>

