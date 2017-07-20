<?php
    include '../dbconfig.php';

    try {
        session_start();
        unset($_SESSION["USER"]);
        echo "<script>alert('Logout operation complete!');location.href='../index.php'</script>";
    } catch(PDOException $e) {
    	//If log out failed, output error message.
        print "Error:".$e->getMessage();
        die();
    }   
    
?>

