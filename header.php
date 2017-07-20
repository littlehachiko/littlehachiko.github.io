
<link rel="stylesheet" type="text/css" href="css/normalize.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/reset.css">

<!-- scripts -->
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/common.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand hidden-sm" href="index.php">Easy reading</a>
        </div>
        <div class="navbar-collapse collapse" role="navigation">
          <ul class="nav navbar-nav">
          <?php
            session_start();
            $tmp = '<li class="hidden-sm hidden-md">'
              .'<a href="favor.php">'
                .'<span class="glyphicon glyphicon-heart"></span>'
               .'My favorites'
              .'</a>'
            .'</li>';
            if(isset($_SESSION["USER"])) {
              echo $tmp;
            }

          ?>
            <li class="searchBar">
              <form action="controller/search.php" method="get">
              <input type="text" placeholder="search" / name="q">
              <button class="btn" type="submit">
                <span class="glyphicon glyphicon-search"></span>
              </button>
              </form>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right hidden-sm">
          <?php
            
            $tmp1 = "<li>"
                .'<a href="login.php">'
                    .'<span class="glyphicon glyphicon-log-in"></span>'
                    .'Sign in'
                .'</a>'
            .'</li>'
            .'<li>'
                .'<a href="regist.php">'
                    .'<span class="glyphicon glyphicon-send"></span>'
                    .'Sign up'
                .'</a>'
            .'</li>';
          

            $tmp2 ='<li>'
                .'<a href="##">'
                  .'<span class="glyphicon glyphicon-user"></span>'
                    .'fokess'
                .'</a>'
            .'</li>'
            .'<li>'
                .'<a href="controller/logout.php">'
                   . '<span class="glyphicon glyphicon-log-out"></span>'
                    .'Sign out'
                .'</a>'
            .'</li>';
            if(isset($_SESSION["USER"])) {
              $output = str_replace("fokess", $_SESSION["USER"]["name"], $tmp2);
            } else {
              $output = $tmp1;
            }
            echo $output;
          ?>
          </ul>
        </div>
      </div>
    </nav>
</header>