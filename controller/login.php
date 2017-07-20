<?php
    include '../dbconfig.php';

    //Compare the password
    //If password corrert: write the last log in time and create session
    //If password wrong:return message that faied to log in and return to log in page
    
    try {
        $con = new PDO("mysql:host=".$db_config["host"].";dbname=".$db_config["database"], $db_config["username"], $db_config["password"]);

        $email = $_POST["email"];
        $psd = md5($_POST["password"]);

        $q = $con
                 ->query("select * from subscriber where email='$email'")
                 ->fetchAll();

        if(count($q) == 0) {
            //no account
            $con = null;
            echo "<script>alert('invalid account');location.href='../login.php'</script>";
        } elseif($q[0]["password"] == $psd) {
            //login success
            //write the last log in time
            //create session
            $dateStr = date('o/m/d/ H:i:s');
            $con->exec("update subscriber set lastlogin='$dateStr' where email='$email'");
            $con = null;
            session_start();
            $_SESSION["USER"] = array(
                                    "id"=>$q[0]["subscriberID"],
                                    "name"=>$q[0]["name"],
                                    "email"=>$email,
                                    "password"=>$psd
                                );
            echo "<script>alert('Login operation finished!');location.href='../index.php'</script>";
        } else {
            //password invalid
            $con = null;
            echo "<script>alert('incorrect password!');location.href='../login.php'</script>";
        }
    } catch(PDOException $e) {
        print "Error:".$e->getMessage();
        die();
    }   
    
?>

