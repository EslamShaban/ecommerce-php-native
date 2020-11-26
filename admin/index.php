<?php 
       session_start();
       $noNavbar  = '';
       $pageTitle = 'Login';
	   if (isset($_SESSION['Username'])) {
		   header('Location: dashboard.php'); // Redirect To Dashboard Page
	   }
       include 'init.php';
       
       // Check If User Coming From Http Post Request

       if($_SERVER['REQUEST_METHOD'] == 'POST'){
       
           $username   = $_POST['user'];
           $password   = $_POST['pass'];
           $hashedPass = sha1($password);
           
           // Check If The User Exist In Database
           
           $stmt = $con->prepare("SELECT UserID, Username, Password FROM users Where Username = ? And Password=? And GroupID=1 LIMIT 1");
           $stmt->execute(array($username,$hashedPass ));
           $row = $stmt->fetch();
           $count = $stmt->rowCount();
           if($count>0){
                $_SESSION['Username'] = $username;
                $_SESSION['ID'] = $row['UserID'];
                header('Location:dashboard.php');
                exit();
           }
           
       }
?>


<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

    <h4 class="text-center">Admin Login</h4>
    <input type="text"      class="form-control" name="user"  placeholder="Username" autocomplete="off">
    <input type="password"  class="form-control" name="pass"  placeholder="Password" autocomplete="new-password">
    <input type="submit"    class="btn btn-primary btn-block" value="Login">
    
</form>


<?php include $tpl . 'footer.php'; ?>