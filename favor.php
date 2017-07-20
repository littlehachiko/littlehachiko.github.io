<!DOCTYPE html>
<html>
<head>
    <title>Front page</title>
<?php
    include "header.php";
    include 'dbconfig.php';

    $userId = $_SESSION["USER"]["id"];
    $con = new PDO("mysql:host=".$db_config["host"].";dbname=".$db_config["database"], $db_config["username"], $db_config["password"]);

    $arr_item = $con->query("select * from saved_articles where subscriberID='$userId'")->fetchAll();
?>

<section class="container content">
    <?php
        if(count($arr_item) > 0) {
            $str = '<div class="item">
                '.'<p class="title"><span class="glyphicon glyphicon-heart text-danger"></span>%title%<a class="btn-del" href="##"><span class="glyphicon glyphicon-trash"></span>remove</a></p>
                '.'<p class="link"><a href="%link%">%link%</a></p>
                '.'<p class="description">%description%</p>
                '.'</div>';

            foreach($arr_item as $item) {
                $itemResult = str_replace("%title%", $item["title"], $str);
                $itemResult = str_replace("%link%", $item["link"], $itemResult);
                $itemResult = str_replace("%description%", $item["description"], $itemResult);
                echo $itemResult;
            }
        } else {
            echo '<h1 class="text-center">you save nothing...</h1>';
        }
    ?>
    <div class="btn-hover">
        <p>Sure to delete?</p>
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
    $('.content').on('click', '.btn-del', function(e) {

            $(this).toggleClass('active');
            if(hover_menu == false) {
                $('.btn-hover').addClass('show');
                hover_menu = !hover_menu;
            }
            
    });

    $('#confirm').on('click', function() {

        var arr_chosen = $('.btn-del.active');
        var arr_del = [];
        
        arr_chosen.each(function(index, dom) {

            var oItem = $(dom).parents('.item');
            
            arr_del.push(oItem.find('.link').text());
            return true;
        });
        $.post('controller/delArticles.php',{
            'data': arr_del
        }, function(response) {
            //@param response the number of deleted
            if(response > 0) {
                alert('Delete operation complete!');
                location.reload();
            }
        });
    });

    $('#cancel').on('click', function() {
        //remove all active
        $('.btn-del.active').each(function(index, dom) {
            $(this).removeClass('active');
        });
        $('.btn-hover').removeClass('show');
        hover_menu = !hover_menu;
    });
});   
</script>
</body>
</html>


