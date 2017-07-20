<?php
    include '../dbconfig.php';
    include '../strFilter.php';
    //Search title, Search description
   

    try {
        //Preprocess search string
        $q = strFilter($_GET["q"]);
        // var_dump($q);
        $query = strtolower($q);

        $xml = simplexml_load_file("../doc/books_rss.xml");
        $arr_item = $xml->xpath("channel/item");
        $arr_query_title = array();
        $arr_query_des = array();
        $pattern = '/'.$query.'/';
        // var_dump($pattern);
        foreach($arr_item as $item) {
            if(preg_match($pattern, strtolower($item->title))) {
                array_push($arr_query_title, $item);
            }
            if(preg_match($pattern, strtolower($item->description))) {
                array_push($arr_query_des, $item);
            }
        }

        $result = array();
        foreach ($arr_query_title as $a) {
            # code...
            $flag = false;
            foreach ($arr_query_des as $b) {
                # code...
                // var_dump($a->title == $b->title);
                if($a->title == $b->title) {
                    $flag = true;
                }
            }
            if(!$flag) {
                array_push($result, $a);
            }
        }
        $result = array_merge($result, $arr_query_des);

        // var_dump($result);
        setcookie("searchResult", json_encode($result), time() + 3600, "/", "newnumyspace.co.uk", false);
        header("location:http://unn-w15030255.newnumyspace.co.uk/index.php");


    } catch(PDOException $e) {
        echo array('error:' => $e->getMessage());
        die();
    }   
    
?>

