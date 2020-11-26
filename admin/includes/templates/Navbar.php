<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN')?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang('Categories')?></a></li>
        <li><a href="items.php"><?php echo lang('ITEMS')?></a></li>
        <li><a href="members.php"><?php echo lang('MEMBERS')?></a></li>
        <li><a href="comments.php"><?php echo lang('Comments')?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('DROPDOWN')?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php" target="_blank">Visit Shop</a></li>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']?>"><?php echo lang('EDIT')?></a></li>
            <li><a href="#"><?php echo lang('SETTING')?></a></li>
            <li><a href="logout.php"><?php echo lang('LOGOUT')?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>