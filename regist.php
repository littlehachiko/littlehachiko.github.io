<!DOCTYPE html>
<html>
<head>
    <title>Sign up</title>
<?php
    include 'header.php';
?>

<section class="container content">
    <div class="form-contaienr">
        <h1 class="text-center">Regist</h1>
        <form action="controller/reg.php" method="post">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="your email" name="email">
        </div>
        <div class="input-group">
            <input class="form-control" type="text" placeholder="your name" name="name">
        </div>
        <div class="input-group">
            <input class="form-control" type="password" placeholder="your password" name="password">
        </div>
        <div class="btn-container text-right">
            <button type="submit" class="btn btn-primary">Sign up</button>
            <button class="btn">reset</button>
        </div>
        </form>
    </div>
    
</section>

<?php
    include 'footer.html';
?>
</body>
</html>


