<?php 

   session_start();

   $pageTitle = 'Login';

   if (isset($_SESSION['user'])) {

	   header('Location: index.php'); 

   }

    include 'init.php'; 

   // Check If User Coming From Http Post Request

   if($_SERVER['REQUEST_METHOD'] == 'POST'){

	   	   if(isset($_POST['login'])){
	   
			       $user       = $_POST['username'];
			       $pass       = $_POST['password'];
			       $hashedPass = sha1($pass);
			       
			       // Check If The User Exist In Database
			       
			       $stmt = $con->prepare("SELECT 
			       							    UserID, Username, Password 
			       						    FROM 
			       						        users 
			       						    Where 
			       						        Username = ? 
			       						    And 
			       						        Password=? ");

			       $stmt->execute(array($user,$hashedPass ));

			       $get = $stmt->fetch();

			       $count = $stmt->rowCount();

			       if($count>0){

			            $_SESSION['user'] = $user;  // Register Session Name
			            $_SESSION['uid']  = $get['UserID']; // Register User ID

			            header('Location:index.php');

			            exit();
			       }

	   }else{

	   	    $username   = $_POST['username'];
	   	    $password   = $_POST['password'];
	   	    $password2  = $_POST['password2'];
	   	    $email      = $_POST['email'];

	   	    $formErrors = array();

	   	   if(isset($username)){
                 $filterUser = filter_var($_POST['username'],FILTER_SANITIZE_STRING);

                 if(strlen($filterUser) < 4){
                 	$formErrors[] = 'Username Must Be Larger Than 4 Characters';
                 }

	   	   }

	   	   if(isset($password) && isset($password2)){

              if(empty($password)){
              	$formErrors[] = "Sorry, Password Can't Be Empty";
              }

	   	   	  if(sha1($password) !== sha1($password2)){

                     $formErrors[] = 'Sorry, Password Is Not Match';

	   	   	  }
	   	   }

	   	   if(isset($email)){
                  
                  $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

                  if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) !=true){
                  	$formErrors[] = 'Email Is Not Valid';
                  }

	   	   }

           if(empty($formErrors)){                
           
               
               $check = checkItem("Username", "users",$username);
               
               if($check == 1){

                   $formErrors[] = 'This User Is Exist';

               }else{
                   
                      $stmt = $con->prepare("INSERT INTO 
                                     users(Username, Password, Email, RegStatus, Date)
                                     VALUES(:Zuser, :Zpass, :Zmail, 0, now())");
                      $stmt->execute(array(
               
                          "Zuser"     => $username,
                          "Zpass"     => sha1($password),
                          "Zmail"     => $email,
               
               ));
               
                   $successMsg = 'Congrats You Are Now Registerd User';
                   
               }
               
           }

           
       }

	   }
       

    ?>

	<div class="container login-page">
		<h1 class="text-center">
			<span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span>
		</h1>

		<!-- Start Login Form -->

		<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            
			<div class="input-container">
				<input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Your Username" required="required" />
			</div>
			<div class="input-container">
				<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type Your Password" required="required" />
			</div>
			<input class="btn btn-block btn-primary" name="login" type="submit" value="Login" />
			
		
		</form>

		<!-- End Login Form -->

		<!-- Start Signup Form -->

		<form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
			<div class="input-container">
				<input class="form-control" pattern=".{4,}" title="Username Must Be 4 Chars" type="text" name="username" autocomplete="off" placeholder="Type Your Username" required="required" />
			</div>
			<div class="input-container">
				<input class="form-control" minlength="4" type="password" name="password" autocomplete="new-password" placeholder="Type Your Password"  required="required" />
			</div>
			<div class="input-container">
				<input class="form-control" minlength="4" type="password" name="password2" autocomplete="new-password" placeholder="Type a password again"  required="required" />
			</div>
			<div class="input-container">
				<input class="form-control" type="text" name="email" a placeholder="Type a Valid email" required="required" />
			</div>
			<input class="btn btn-block btn-success" name="signup" type="submit" value="signup" />
		</form>

		<!-- End Signup Form -->

		<div class="the-errors text-center">
			
			<?php 
                 
                 if(! empty($formErrors)){
                 	foreach ($formErrors as $error) {
                 		echo "<div class='msg'>" . $error . "</div>";
                 	}
                 }

                 if(isset($successMsg)){
                 	echo '<div class="msg success">' . $successMsg . '</div>';
                 }

			?>

		</div>


	</div>

<?php include $tpl . 'footer.php' ; ?>