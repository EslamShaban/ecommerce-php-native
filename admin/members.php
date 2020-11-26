<?php

       session_start();
        
       $pageTitle = 'Members';

       if(isset($_SESSION['Username'])){ 
           
           include 'init.php';
           
             
           $do = isset($_GET['do'])? $_GET['do'] : 'Manage';

           if($do == 'Manage'){  
               
                  $query = '';
                  
                  if(isset($_GET['page']) &&  $_GET['page'] == 'Pending'){
                      
                      $query = 'AND RegStatus = 0';
                  }
                               
                  $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID");
                  $stmt->execute();
                  $rows= $stmt->fetchAll(); 

                  if(! empty($rows)){

              ?>

                <h1 class="text-center">Manage Member</h1>

                <div class="container">

                    <div class="table-responsive">
                    
                        <table class="main-table table table-bordered text-center">
                        
                            <tr>
                                <td>#ID</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Full Name</td>
                                <td>Registerd Date</td>
                                <td>Control</td>
                            </tr>
                            
                            <?php 

                               foreach($rows as $row){
                                   
                                                                  
                                   echo "<tr>";
                                       echo "<td>" . $row['UserID'] . "</td>";
                                       echo "<td>" . $row['Username'] . "</td>";
                                       echo "<td>" . $row['Email'] . "</td>";
                                       echo "<td>" . $row['FullName'] . "</td>";
                                       echo "<td>" . $row['Date']  . "</td>";
                                       echo "<td>
                                       
                                               <a href='?do=Edit&userid=" . $row['UserID'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                               <a href='?do=delete&userid=" . $row['UserID'] ."' class='confirm btn btn-danger'><i class='fa fa-close'></i> Delete</a> ";
                                               
                                              if($row['RegStatus'] == 0){
                                                  
                                                  echo "<a href='?do=activate&userid=" . $row['UserID'] ."' class=' btn btn-info'><i  class='fa fa-check'></i> Activate</a>";
                                              }
                                               
                                            
                                      echo "</td>";
                                 
                                  echo "</tr>";
                                   
                               }
                            
                            
                            ?>                         
                            
                        </table>
                        
                    </div>
                                
                    <a href = "members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>

                </div> 

                <?php } else{

                      echo "<div class='container'>";
                           echo "<div class='nice-message'>There's No Members To Show</div>";
                           echo '<a href ="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>';

                      echo "</div>";
                }?>      
   
           <?php }elseif($do == 'Add'){ ?>
               
                
                <h1 class="text-center">Add New Member</h1>

                <div class="container">

                    <form class="form-horizontal" action="?do=Insert" method="POST">                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Username</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Type Your Username">
                            </div>
                            
                        </div>
                                            
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Password</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="Type Your Password">
                                <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                            
                        </div>
                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Email</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" class="form-control" required="required" placeholder="Type Your Email">
                            </div>
                            
                        </div>
                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Full Name</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="FullName" class="form-control" required="required" placeholder="Type Your FullName">
                            </div>
                            
                        </div>

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">User Avatar</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="file" name="avatar" class="form-control" required="required" >
                            </div>
                            
                        </div>
                    
                        <div class="form-group">
                                                    
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Member" class="btn btn-primary btn-lg">
                            </div>
                            
                        </div>
                    
                    </form>
    
                </div>

               
               
           <?php }
           elseif($do == 'Insert'){
               
               
               echo '<div class="container">';
               
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                  
                   echo "<h1 class='text-center'>Insert Member</h1>" ;

                   $avatar = $_FILES['avatar'];

                   print_r($avatar);

                   $user  = $_POST['username'];
                   $pass  = $_POST['password'];
                   $email = $_POST['email'];
                   $name  = $_POST['FullName'];
                   
                   $hashPass = sha1($_POST['password']);
                   
                   $formError = array();
                   
                   if(empty($user)){
                       
                       $formError[] = "Username Cant Be <strong>Empty</strong>";
                   }                   
                   if(strlen($user)<4){
                       
                       $formError[] = "Username Cant Be Less Than <strong>4 Characters</strong>";
                   }                   
                   if(strlen($user)>20){
                       
                       $formError[] = "Username Cant Be More Than <strong>20 Characters</strong>";
                   }                   
                   if(empty($pass)){
                       
                       $formError[] = "Password Cant Be <strong>Empty</strong>";
                   }                   
                   if(empty($email)){
                       
                       $formError[] = "Email Cant Be <strong>Empty</strong>";
                   }                   
                   if(empty($name)){
                       
                       $formError[] = "FullName Cant Be <strong>Empty</strong>";
                   } 
                   
                   foreach($formError as $error){
                       
                       echo '<div class="alert alert-danger">' . $error . '</div>';
                       
                   }
                   
                   

                   if(empty($formError)){                
                    
                    /*
                      
                       $check = checkItem("Username", "users",$user);
                       
                       if($check == 1){
                           $theMsg = '<div class="alert alert-danger">This User Is Exist</div>';
                           redirectHome($theMsg, 'back');

                       }else{
                           
                              $stmt = $con->prepare("INSERT INTO 
                                             users(Username, Password, Email, FullName,RegStatus, Date)
                                             VALUES(:Zuser, :Zpass, :Zmail, :Zfullname, 1 ,now())");
                              $stmt->execute(array(
                       
                                  "Zuser"     => $user,
                                  "Zpass"     => $hashPass,
                                  "Zmail"     => $email,
                                  "Zfullname" => $name
                       
                       ));
                       
                           $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Inserted </div>';
                           
                           redirectHome($theMsg, 'back');
                           
                       }
                       */
                       
                   
                  }
          
               }else{
                                  
                   $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
                   
                   redirectHome($theMsg);
           
           
           }
        echo '</div>';
               
           }elseif($do == 'Edit'){  
               
            $userid = isset ($_GET['userid'] ) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                                  
            $stmt = $con->prepare("SELECT * FROM users Where UserID = ?");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count>0){ ?>

                <h1 class="text-center">Edit Member</h1>

                <div class="container">
                    
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        
                        <input type="hidden" name="userid" value="<?php echo $userid ?>" >
                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Username</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username" value = "<?php echo $row['Username']?>" class="form-control" autocomplete="off" required="required">
                            </div>
                            
                        </div>
                                            
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Password</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>">
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want to Change">
                            </div>
                            
                        </div>
                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Email</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" value = "<?php echo $row['Email']?>" class="form-control" required="required">
                            </div>
                            
                        </div>
                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Full Name</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="FullName" value = "<?php echo $row['FullName']?>" class="form-control" required="required">
                            </div>
                            
                        </div>
                    
                        <div class="form-group">
                                                    
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg">
                            </div>
                            
                        </div>
                    
                    </form>
    
                </div>
   
           <?php } else{
                
                    echo '<div class="container">';
                        
                    $theMsg =  "<div class='alert alert-danger'>Theres No Such ID</div>";
                
                    redirectHome($theMsg);

                    echo '</div>';
            }
           
                                 
        }elseif($do == 'Update'){
               
               echo "<h1 class='text-center'>Update Member</h1>" ;
               echo '<div class="container">';
               
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                   $user  = $_POST['username'];
                   $email = $_POST['email'];
                   $name  = $_POST['FullName'];
                   $id    = $_POST['userid'];
                   $pass  = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
                   
                   $formError = array();
                   
                   if(empty($user)){
                       
                       $formError[] = "Username Cant Be <strong>Empty</strong>";
                   }                   
                   if(strlen($user)<4){
                       
                       $formError[] = "Username Cant Be Less Than <strong>4 Characters</strong>";
                   }                   
                   if(empty($email)){
                       
                       $formError[] = "Email Cant Be <strong>Empty</strong>";
                   }                   
                   if(empty($name)){
                       
                       $formError[] = "FullName Cant Be <strong>Empty</strong>";
                   } 
                   
                   foreach($formError as $error){
                       
                       echo '<div class="alert alert-danger">' . $error . '</div>';
                       
                   }
                   
                   if(empty($formError)){                
                   
                            $stmt = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
                            $stmt->execute(array($user, $id));
                            $count = $stmt->rowCount();

                            if($count == 1){

                              echo "<div class='alert alert-danger'>Sorry, This User Is Exist</div>";

                            }else{


                                $stmt = $con->prepare("UPDATE users SET Username = ?, Password = ?,Email = ?, FullName = ? WHERE UserID = ?");
                                $stmt->execute(array($user, $pass, $email, $name, $id));
                                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Updated </div>';
                                             
                                redirectHome($theMsg,'back');
                            }    
 
                   }

                   
               }else{
               
                      $theMsg = '<div class="alert alert-success">Sorry You Cant Browse This Page Directly</div>';
                                         
                      redirectHome($theMsg);
                   
           
           }
        echo '</div>';

               
        }else if($do =='delete'){
               
                             
             echo "<h1 class='text-center'>Delete Member</h1>" ;
               
             echo '<div class="container">';
               
                  $userid = isset ($_GET['userid'] ) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;                    
                                      
                  $check = checkItem("UserID", "users", $userid);

               
                  if($check > 0){
                 
                       $stmt = $con->prepare("DELETE FROM users WHERE UserID = :Zuser");
                       $stmt->bindParam("Zuser", $userid);
                       $stmt->execute();
                             
                       $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Deleted </div>';
                                             
                      redirectHome($theMsg,'back');


                      
                }else{
                                            
                      $theMsg = '<div class="alert alert-danger">This ID Not Exist</div>';
                      
                      redirectHome($theMsg);


                }
               
            echo "</div>";
               
           }elseif($do=='activate'){
               
                             
             echo "<h1 class='text-center'>activate Member</h1>" ;
               
             echo '<div class="container">';
               
                  $userid = isset ($_GET['userid'] ) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;                    
                                      
                  $check = checkItem("UserID", "users", $userid);

               
                  if($check > 0){
                 
                       $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
                      
                       $stmt->execute(array($userid));
                             
                       $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record activated </div>';
                                             
                      redirectHome($theMsg,'back');


                      
                }else{
                                            
                      $theMsg = '<div class="alert alert-danger">This ID Not Exist</div>';
                      
                      redirectHome($theMsg);


                }
               
            echo "</div>";
               
           }
           
           include $tpl . 'footer.php';
       
       } else{
           
           header('Location: index.php');
           exit();
       }