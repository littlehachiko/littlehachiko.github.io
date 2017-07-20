<!DOCTYPE html>
<html>
<head>
    <title>Sign in</title>
<?php
    include 'header.php';
?>

<section class="container">
    <div class="form-contaienr">
        <h1 class="text-center">Log in</h1>
        <form action="controller/login.php" method="post">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="your email" name="email">
        </div>
        <div class="input-group">
            <input class="form-control" type="password" placeholder="your password" name="password">
        </div>
        <div class="btn-container text-right">
            <button type="submit" class="btn btn-primary">Sign in</button>
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


