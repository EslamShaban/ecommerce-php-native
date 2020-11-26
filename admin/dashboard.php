<?php

       session_start();

       if(isset($_SESSION['Username'])){ 
           $pageTitle = 'Dashboard';
           include 'init.php';
           
           $numUsers = 6;
           
           $theLatestUsers = getLatest("*", "users", "WHERE GroupID != 1","UserID", $numUsers);           
           
           $numItems = 6;
           
           $theLatestItems = getLatest("*", "items", "item_ID", $numItems);
           
           ?>

   
           <div class = "home-stats text-center">
               
               <div class="container">
               
                   <h1>Dashboard</h1>
                   <div class="row">
                   
                       <div class="col-md-3">
                       
                           <div class="stats st-members">
                               <i class="fa fa-users"></i>
                               <div class="info">
                                    Total Members
                                    <span> <a href = "members.php"><?php echo CountItems('UserID', 'users') -1?></a></span>
                               </div>
                           </div>
                           
                       </div>                       
                       <div class="col-md-3">
                       
                           <div class="stats st-pending">
                               <i class="fa fa-user-plus"></i>
                               <div class="info">
                                    Pending Members
                                    <span><a href = "members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0); ?></a></span> 
                               </div>
                           </div>
                           
                       </div>                       
                       <div class="col-md-3">
                       
                           <div class="stats st-items">
                               <i class="fa fa-tag"></i>
                               <div class="info">
                                    Total Items
                                    <span> <a href = "items.php"><?php echo CountItems('item_ID', 'items')?></a></span>
                               </div>
                           </div>
                           
                       </div>                       
                       <div class="col-md-3">
                       
                           <div class="stats st-comments">
                               <i class="fa fa-comments"></i>
                               <div class="info">
                               
                                   Total Comments
                                   <span> <a href = "comments.php"><?php echo CountItems('c_id', 'comments')?></a></span>
                                   
                               </div>
                               
                           </div>
                           
                       </div>
                       
                   </div>
                   
               </div>

           </div>

          <div class="latest">
              
              <div class="container">
              
                  <div class="row">

                      <div class="col-sm-6">
    
                          <div class="panel panel-default">

                              <div class="panel-heading">
                                  <i class="fa fa-users"></i> Latest <?php echo $numUsers ?> Registerd Users
                                  <span class="toggle-info pull-right">
                                      <i class="fa fa-plus fa-lg"></i>                                      
                                  </span>
                              </div>
                          
                              <div class="panel-body">
                                  
                                  <?php 
                                                          
                                     echo "<ul class='list-unstyled latest-user'>";

                                     if(! empty($theLatestUsers)){

                                          foreach($theLatestUsers as $user){
                                                                                        
                                                 echo '<li>' . $user['Username'] .
                                                         '<a href="members.php?do=Edit&userid='. $user["UserID"] . '">
                                                          <span class="btn btn-success pull-right">
                                                          <i class="fa fa-edit"></i> Edit </span> </a>';
                                                                                       
                                                          if($user['RegStatus'] == 0){
                                                      
                                                               echo "<a href='members.php?do=activate&userid=" . $user['UserID'] ."' class='pull-right btn btn-info'><i class='fa fa-check'></i> Activate</a> ";
                                                            }
                                                          
                                                          
                                                          
                                                echo '</li>';                                          
                                          }
                                    }else {
                                         echo "There\'s No Record To Show";
                                    }
                                                     
                                    echo "</ul>";

                                  
                                  ?>
                              
                              
                              </div>
                      
                          </div>
                      
                      </div>                  
                      <div class="col-sm-6">
                  
                          <div class="panel panel-default">

                              <div class="panel-heading">
                                  
                                  <i class="fa fa-tag"></i> Latest Items
                                        <span class="toggle-info pull-right">
                                            <i class="fa fa-plus fa-lg"></i>                                      
                                        </span>
                              
                              </div>
                          
                          
                              <div class="panel-body">
                                  
                                  <?php 
                                                    
                                     echo "<ul class='list-unstyled latest-user'>";

                                     if(! empty($theLatestItems)){

                                          foreach($theLatestItems as $item){
                                                                                        
                                                 echo '<li>' . $item['Name'] .
                                                         '<a href="items.php?do=Edit&itemid='. $item["item_ID"] . '">
                                                          <span class="btn btn-success pull-right">
                                                          <i class="fa fa-edit"></i> Edit </span> </a>';
                                                                                       
                                                          if($item['Approve'] == 0){
                                                      
                                                               echo "<a href='items.php?do=Approve&itemid=" . $item['item_ID'] ."' class='pull-right btn btn-info'><i class='fa fa-check'></i> Approve</a> ";
                                                            }
                                                          
                                                          
                                                          
                                                echo '</li>';                                          
                                          }
                                        }else{
                                           echo "There\'s No Record To Show";
                                        }
                                                    
                                      echo "</ul>";

                                  
                                  ?>
                              
                              
                              </div>                      
                          </div>

                      </div>

                  </div>

              </div>

          
         </div>

          <div class="latest">
              
              <div class="container">
              
                  <div class="row">

                      <div class="col-sm-6">
    
                          <div class="panel panel-default">

                              <div class="panel-heading">
                                  <i class="fa fa-comments-o"></i> Latest Comments
                                  <span class="toggle-info pull-right">
                                      <i class="fa fa-plus fa-lg"></i>                                      
                                  </span>
                              </div>
                          
                              <div class="panel-body">  
                                  <?php 
                                  
                                    $stmt = $con->prepare("SELECT 
                                                                comments.*, users.Username AS Memeber
                                                            FROM 
                                                                comments

                                                            INNER JOIN

                                                                users
                                                            ON
                                                                users.UserID = comments.user_id");
                                    $stmt->execute();
                                    $comments= $stmt->fetchAll(); 
           
                                    foreach($comments as $comment){
                                        echo "<div class='comment-box'>";
                                             echo "<span class='comment-n'>" . $comment['Memeber'] . "</span>";
                                             echo "<p class='comment-c'>" 
                                                      . $comment['comment'] . "
                                                      <span class='displayBlock pull-right'>
                                                          <a href='comments.php?do=Edit&comid=" . $comment['c_id'] ."' class=' btn btn-success'><i class='fa fa-edit'></i> Edit</a>  
                                                          <a href='comments.phpcomments.php?do=delete&comid=" . $comment['c_id'] ."' class=' confirm btn btn-danger'><i class='fa fa-close'></i> Delete</a> ";

                                                          if($comment['status'] == 0){

                                                              echo "<a href='comments.php?do=Approve&comid=" . $comment['c_id'] ."' class=' btn btn-info'><i  class='fa fa-check'></i> Approve</a>";
                                                          }
                                                 echo "</span>";
                                             echo"</p>";
                                        echo "</div>";
                                    }
                                  ?>
                              </div>
                      
                          </div>
                      
                      </div>                 

                  </div>

              </div>

          
         </div>
           
    
<?php        
           include $tpl . 'footer.php';
       } else{
           
           header('Location: index.php');
           exit();
       }