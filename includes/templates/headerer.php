
<!DOCTYPE html>
<html>
    <head>
    
        <meta charset="UTF-8">
        <title><?php getTitle() ?></title>
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
        <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
        <link rel="stylesheet" href="<?php echo $css; ?>front.css">
        
    </head>
    <body>
    <div class="upper-bar">
        <div class="container">
            <?php 

               if (isset($_SESSION['user'])) { ?>

                <img class = 'my-image img-circle img-thumbnail' src='layout/images/avatar.png' alt='' >

                <div class="btn-group my-info">

                  <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    
                    <?php echo $sessionUser; ?>
                    <span class="caret"></span>

                  </span>
                  <ul class="dropdown-menu">
                    
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="newad.php">New Item</a></li>
                    <li><a href="profile.php#myads">My Items</a></li>
                    <li><a href="logout.php">Logout</a></li>

                  </ul>

                </div>


                <?php

               }else{
            ?>
            <a href="login.php">
              <span class="pull-right">LogIn/SignUp</span>
            </a>
          <?php } ?>
        </div>
    </div>
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>