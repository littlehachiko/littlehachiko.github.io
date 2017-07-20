<?php
    if(isset($_COOKIE["searchResult"])) {
        
        $arr_item = json_decode($_COOKIE["searchResult"]);
        setcookie("searchResult", "", time() - 3600, "/", "newnumyspace.co.uk", false);

    } else {
        $xml = simplexml_load_file("./doc/books_rss.xml");
        //use xpath parse the simpleXML object
        $arr_item = $xml->xpath("channel/item");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Front page</title>
<?php
    include "header.php";
    include 'dbconfig.php';


    
    // var_dump($arr_item);
    $con = new PDO("mysql:host=".$db_config["host"].";dbname=".$db_config["database"], $db_config["username"], $db_config["password"]);

    if(isset($_SESSION["USER"])) {
        $id = $_SESSION["USER"]["id"];
        $arr_saved = $con->query("select title from saved_articles where subscriberID=$id")->fetchAll();
        $saved_length = count($arr_saved);
        $con = null;

        function diff_filter($item){
            global $saved_length,$arr_saved;

            if( $saved_length > 0) {

                foreach($arr_saved as $title) {
                    if($item->title == $title["title"]) {

                        $saved_length--;
                        $item->like = 1;
                    }
                }
            }
            return true;
        }
        $arr_item = array_filter($arr_item, "diff_filter");
    
    }

    function generate_item($arr_item) {
        $str = '<div class="item">
        '.'<p class="title"><span class="glyphicon glyphicon-book text-primary"></span><span class="title-content">%title%</span><span class="%like% glyphicon glyphicon-heart text-danger"></span><a class="%save% btn-save" href="##"><span class="glyphicon glyphicon-star"></span>save</a></p>
        '.'<p class="link"><a href="%link%">%link%</a></p>
        '.'<p class="description">%description%</p>
        '.'</div>';
        if(count($arr_item) == 0) {
            echo '<h1 class="text-center">No article found..</h1>';
        }
        foreach($arr_item as $item) {
            $itemResult = str_replace("%title%", $item->title, $str);
            $itemResult = str_replace("%link%", $item->link, $itemResult);
            $itemResult = str_replace("%description%", $item->description, $itemResult);
            if(isset($item->like)) {
                $itemResult = str_replace("%like%", "", $itemResult);
                $itemResult = str_replace("%save%", "hide", $itemResult);
            } else {
                $itemResult = str_replace("%like%", "hide", $itemResult);
                $itemResult = str_replace("%save%", "", $itemResult);
            }
            
            echo $itemResult;
        } 
    }

    
?>

<section class="container content">
    <?php
         generate_item($arr_item);
    ?>
    
    <div class="btn-hover">
        <p>Sure to save?</p>
        <a id="confirm" class="btn btn-success" href="##">confirm</a>
        <a id="cancel" class="btn btn-danger" href="##">cancel</a>
    </div>
</section>

<?php
    include "footer.html";
?>
<script>
$(document).ready(function(){
    
    var hover_menu = false;
    $('.content').on('click', '.btn-save', function(e) {
            $(this).toggleClass('active');
            if(hover_menu == false) {
                $('.btn-hover').addClass('show');
                hover_menu = !hover_menu;
            }
            
            
    });

    $('#confirm').on('click', function() {

        var arr_chosen = $('.btn-save.active');
        var arr_save = [];
        
        arr_chosen.each(function(index, dom) {

            var oItem = $(dom).parents('.item');
            var temp = {};

            temp.title = oItem.find('.title-content').text();
            temp.link = oItem.find('.link').text();
            temp.description = oItem.find('.description').text();
            
            arr_save.push(temp);
            return true;
        });
        $.post('controller/saveArticles.php',{
            'data': arr_save
        }, function(response) {
           //-1:do not log in，0:operate successfully
           if(response == -1) {
                alert('Please sign in before save operation!');
                location.href = "login.php";
           } else if(response == 0) {
                alert('Save completed!');
                location.href = "favor.php";
           } else {
                console.log(response);
           }
        });
    });

    $('#cancel').on('click', function() {
        //remove all active
        $('.btn-save.active').each(function(index, dom) {
            $(this).removeClass('active');
        });
        $('.btn-hover').removeClass('show');
        hover_menu = !hover_menu;
    });
});
</script>
</body>
</html>


