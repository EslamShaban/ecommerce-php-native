<?php 

    /*
    ===========================================
    == Items Page
    ===========================================
    */
      ob_start();

      session_start();
 
      $pageTitle = 'Items';

     if(isset($_SESSION['Username'])){
         
         include 'init.php';
         
         $do = (isset($_GET['do']))? $_GET['do'] : 'Manage';
         
         if($do == 'Manage'){
                               
                  $stmt = $con->prepare("SELECT 
                                              items.*, 
                                              categories.Name As Ctaegory_Name, 
                                              users.Username 
                                        FROM 
                                              items 
                                        INNER JOIN 
                                              categories 
                                        ON 
                                              categories.ID=items.Cat_ID 
                                        INNER JOIN 
                                              users 
                                        ON 
                                              users.UserID = items.Member_ID
                                        ORDER BY

                                              item_ID DESC");
                  $stmt->execute();
                  $items= $stmt->fetchAll(); 

                  if(! empty($items)){

                  ?>

                  <h1 class="text-center">Manage Items</h1>

                  <div class="container">

                      <div class="table-responsive ">
                      
                          <table class="main-table table table-bordered text-center">
                          
                              <tr>
                                  <td>#ID</td>
                                  <td>Name</td>
                                  <td>Description</td>
                                  <td>Price</td>
                                  <td>Adding Date</td>
                                  <td>Category</td>
                                  <td>Username</td>
                                  <td>Control</td>
                              </tr>
                              
                              <?php 

                                 foreach($items as $item){
                                     
                                                                    
                                     echo "<tr>";
                                         echo "<td>" . $item['item_ID'] . "</td>";
                                         echo "<td>" . $item['Name'] . "</td>";
                                         echo "<td>" . $item['Description'] . "</td>";
                                         echo "<td>" . $item['Price'] . "</td>";
                                         echo "<td>" . $item['Add_Date']  . "</td>";
                                         echo "<td>" . $item['Ctaegory_Name']  . "</td>";
                                         echo "<td>" . $item['Username']  . "</td>";
                                         echo "<td>
                                         
                                                 <a href='?do=Edit&itemid="   . $item['item_ID'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                                 <a href='?do=Delete&itemid=" . $item['item_ID'] ."' class='confirm btn btn-danger'><i class='fa fa-close'></i> Delete</a> ";
                                                                                               
                                                 if($item['Approve'] == 0){
                                                    
                                                    echo "<a href='?do=Approve&itemid=" . $item['item_ID'] ."' class=' btn btn-info'><i class='fa fa-check'></i> Approve</a>";
                                                 }

                                              
                                        echo "</td>";
                                   
                                    echo "</tr>";
                                     
                                 }
                              
                              
                              ?>                         
                              
                          </table>
                          
                      </div>
                                  
                      <a href = "items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>

                  </div> 

                <?php } else{

                      echo "<div class='container'>";
                           echo "<div class='nice-message'>There's No Items To Show</div>";
                           echo '<a href ="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>';

                      echo "</div>";
                }?>        
     
           <?php
             
         }elseif($do == 'Add'){ ?>
               
                <h1 class="text-center">Add New Item</h1>

                <div class="container">

                    <form class="form-horizontal" action="?do=Insert" method="POST">                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Name</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input 
                                       type="text" 
                                       name="name" 
                                       class="form-control" 
                                       required="required" 
                                       placeholder="Name of The Item">
                            </div>
                            
                        </div>
                                            
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Description</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" 
                                       name="description" 
                                       class="form-control"                                      
                                       required="required" 
                                       placeholder="Type Description For This Item">
                            </div>
                            
                        </div>                        
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Price</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" 
                                       name="price" 
                                       class="form-control"                                      
                                       required="required" 
                                       placeholder="Price of The Item">
                            </div>
                            
                        </div>  
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Country</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" 
                                       name="country" 
                                       class="form-control"                                      
                                       required="required" 
                                       placeholder="Country of Made">
                            </div>
                            
                        </div> 
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Status</label>
                            
                            <div class="col-sm-10 col-md-6">
                              
                                <select name="status" class="form-control">
                                
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>
                                    
                                </select>
                                
                            </div>
                            
                        </div>                       
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Member</label>
                            
                            <div class="col-sm-10 col-md-6">
                              
                                <select name="member" class="form-control">
                                
                                    <option value="0">...</option>
                                   <?php 

                                      $allMembers = getAllFrom("*", "users", "WHERE RegStatus=1", "", "UserID");
                                          
                                      foreach($allMembers as $user){
                                          
                                          echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] .  "</option>";
                                      }
                                    
                                    
                                   ?>
                                    
                                </select>
                                
                            </div>
                            
                        </div>
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Category</label>
                            
                            <div class="col-sm-10 col-md-6">
                              
                                <select name="category" class="form-control">
                                
                                    <option value="0">...</option>
                                   <?php 
                                      $allCats = getAllFrom("*", "categories", "Where parent=0", "", "ID");
                                          
                                      foreach($allCats as $cat){
                                          
                                          echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] .  "</option>";

                                          $allChild = getAllFrom("*", "categories", "Where parent={$cat['ID']}", "", "ID");

                                          foreach ($allChild as $child) {
                                                      
                                               echo "<option value='" . $child['ID'] . "'>---" . $child['Name'] .  "</option>";

                                          }

                                      }
                                    
                                    
                                    ?>
                                    
                                </select>
                                
                            </div>
                            
                        </div>

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Tags</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" 
                                       name="tags" 
                                       class="form-control"                                      
                                       placeholder="Seperate tags with comma (,)">
                            </div>
                            
                        </div> 
                    
                        <div class="form-group">
                                                    
                            <div class="col-sm-offset-2 col-sm-10">
                                
                                <input type="submit" value="Add Item" class="btn btn-primary btn-lg">
                                
                            </div>
                            
                        </div>
                    
                    </form>
    
                </div>

               
               
           <?php 
             
         }elseif($do == 'Insert'){
             
               
               echo '<div class="container">';
               
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                  
                   echo "<h1 class='text-center'>Insert New Item</h1>" ;

                   $name     = $_POST['name'];
                   $desc     = $_POST['description'];
                   $price    = $_POST['price'];
                   $country  = $_POST['country'];
                   $status   = $_POST['status'];
                   $member   = $_POST['member'];
                   $cat      = $_POST['category'];
                   $tags      = $_POST['tags'];
                   
                   
                   $formError = array();
                   
                   if(empty($name)){
                       
                       $formError[] = "Name Cant Be <strong>Empty</strong>";
                   }                   
                           
                   if(empty($desc)){
                       
                       $formError[] = "Description Cant Be <strong>Empty</strong>";
                   }                   
                   if(empty($price)){
                       
                       $formError[] = "Price Cant Be <strong>Empty</strong>";
                   }                   
                   if(empty($country)){
                       
                       $formError[] = "Country Cant Be <strong>Empty</strong>";
                   }                    
                   if($status == 0){
                       
                       $formError[] = "You Must Choose The <strong>Status</strong>";
                   }  
                   if($member == 0){
                       
                       $formError[] = "You Must Choose The <strong>Status</strong>";
                   }                   
                   if($cat == 0){
                       
                       $formError[] = "You Must Choose The <strong>Status</strong>";
                   } 
                   
                   foreach($formError as $error){
                       
                       echo '<div class="alert alert-danger">' . $error . '</div>';
                       
                   }
                   
                   if(empty($formError)){                
                   
            
                              $stmt = $con->prepare("INSERT INTO 
                                             items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, Tags)
                                             VALUES(:Zname, :Zdesc, :Zprice, :Zcountry, :Zstatus, now(), :Zcat, :Zmember, :Ztags)");
                              $stmt->execute(array(
                       
                                  "Zname"      => $name,
                                  "Zdesc"      => $desc,
                                  "Zprice"     => $price,
                                  "Zcountry"   => $country,
                                  "Zstatus"    => $status,
                                  "Zcat"       => $cat,
                                  "Zmember"    => $member,
                                  "Ztags"      => $tags
                       
                       ));
                       
                           $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Inserted </div>';
                           
                           redirectHome($theMsg, 'back');
                           
                       
                       
                   }

                   
               }else{
                                  
                   $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
                   
                   redirectHome($theMsg);
           
           
           }
        echo '</div>';
               
             
         }elseif($do == 'Edit'){
             
                          
            $itemid = isset ($_GET['itemid'] ) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                                  
            $stmt = $con->prepare("SELECT * FROM items Where item_ID = ?");
            $stmt->execute(array($itemid));
            $items = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count>0){ ?>

                <h1 class="text-center">Edit Item</h1>

                <div class="container">
                    
                    <form class="form-horizontal" action="?do=Update" method="POST">                      
                        <input type="hidden" name="itemid" value="<?php echo $itemid ?>" >
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Name</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input 
                                       type="text" 
                                       name="name" 
                                       class="form-control" 
                                       required="required" 
                                       placeholder="Name of The Item"
                                       value = " <?php echo $items['Name'] ?> ">
                            </div>
                            
                        </div>
                                            
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Description</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" 
                                       name="description" 
                                       class="form-control"                                      
                                       required="required" 
                                       placeholder="Type Description For This Item"
                                       value = " <?php echo $items['Description'] ?>">
                            </div>
                            
                        </div>                        
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Price</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" 
                                       name="price" 
                                       class="form-control"                                      
                                       required="required" 
                                       placeholder="Price of The Item"
                                        value = " <?php echo $items['Price'] ?>">
                            </div>
                            
                        </div>  
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Country</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" 
                                       name="country" 
                                       class="form-control"                                      
                                       required="required" 
                                       placeholder="Country of Made"
                                        value = " <?php echo $items['Country_Made'] ?>">
                            </div>
                            
                        </div> 
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Status</label>
                            
                            <div class="col-sm-10 col-md-6">
                              
                                <select name="status" class="form-control">
                                
                                    <option value="1" <?php if($items['Status']==1){echo "selected";}?> >New</option>
                                    <option value="2" <?php if($items['Status']==2){echo "selected";}?>>Like New</option>
                                    <option value="3" <?php if($items['Status']==3){echo "selected";}?>>Used</option>
                                    <option value="4" <?php if($items['Status']==4){echo "selected";}?>>Very Old</option>
                                    
                                </select>
                                
                            </div>
                            
                        </div>                       
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Member</label>
                            
                            <div class="col-sm-10 col-md-6">
                              
                                <select name="member" class="form-control">
                                
                                   <?php 
             
                                      $stmt = $con->prepare("SELECT * FROM users WHERE RegStatus=1");
                                      $stmt->execute();
                                      $users = $stmt->fetchAll();
                                          
                                      foreach($users as $user){
                                          
                                          echo "<option value='" . $user['UserID'] . "'";
                                          if($items['Member_ID']==$user['UserID']){echo "selected";}
                                          echo " >" . $user['Username'] .  "</option>";
                                      }
                                    
                                    
                                    ?>
                                    
                                </select>
                                
                            </div>
                            
                        </div>
                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Category</label>
                            
                            <div class="col-sm-10 col-md-6">
                              
                                <select name="category" class="form-control">
                                
                                    <option value="0">...</option>
                                   <?php 
             
                                      $stmt2 = $con->prepare("SELECT * FROM categories");
                                      $stmt2->execute();
                                      $cats  = $stmt2->fetchAll();
                                          
                                      foreach($cats as $cat){
                                          
                                          echo "<option value='" . $cat['ID'] . "'";
                                          if($items['Cat_ID']== $cat['ID']){echo "selected";}
                                          echo ">" . $cat['Name'] .  "</option>";
                                      }
                                    
                                    
                                    ?>
                                    
                                </select>
                                
                            </div>
                            
                        </div>
                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Tags</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" 
                                       name="tags" 
                                       class="form-control" 
                                       value=" <?php echo $items['Tags'] ?>" >
                                       
                            </div>
                            
                        </div> 
                    
                        <div class="form-group">
                                                    
                            <div class="col-sm-offset-2 col-sm-10">
                                
                                <input type="submit" value="Save Item" class="btn btn-primary btn-lg">
                                
                            </div>
                            
                        </div>
                    
                    </form>
    
                 <?php 
                         
                  $stmt = $con->prepare("SELECT 
                                               comments.*, users.Username AS Memeber
                                         FROM 
                                               comments
                                                
                                        INNER JOIN
                                            
                                               users
                                        ON
                                               users.UserID = comments.user_id
                                        WHERE
                                               item_id = ?");
                  $stmt->execute(array($itemid));
                  $rows= $stmt->fetchAll(); 
                
                  if(! empty($rows)){

              ?>

                <h1 class="text-center">Manage <?php echo "[" . $items['Name'] . "]"; ?> Comments</h1>

                    <div class="table-responsive ">
                    
                        <table class="main-table table table-bordered text-center">
                        
                            <tr>
                                <td>Comment</td>
                                <td>User Name</td>
                                <td>Added Date</td>
                                <td>Control</td>
                            </tr>
                            
                            <?php 

                               foreach($rows as $row){
                                   
                                                                  
                                   echo "<tr>";
                                       echo "<td>" . $row['comment'] . "</td>";
                                       echo "<td>" . $row['Memeber'] . "</td>";
                                       echo "<td>" . $row['comment_date']  . "</td>";
                                       echo "<td>
                                       
                                               <a href='comments.php?do=Edit&comid=" . $row['c_id'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                               <a href='comments.php?do=delete&comid=" . $row['c_id'] ."' class='confirm btn btn-danger'><i class='fa fa-close'></i> Delete</a> ";
                                               
                                              if($row['status'] == 0){
                                                  
                                                  echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] ."' class=' btn btn-info'><i  class='fa fa-check'></i> Approve</a>";
                                              }
                                               
                                            
                                      echo "</td>";
                                 
                                  echo "</tr>";
                                   
                               }
                            
                            
                            ?>                         
                            
                        </table>
                        
                    </div>
                         
                    <?php } ?>
                </div>
   
           <?php } else{
                
                    echo '<div class="container">';
                        
                    $theMsg =  "<div class='alert alert-danger'>Theres No Such ID</div>";
                
                    redirectHome($theMsg);

                    echo '</div>';
            }
           
             
         }elseif($do == 'Update'){
             
               echo "<h1 class='text-center'>Update Item</h1>" ;
               echo '<div class="container">';
               
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                   $id       = $_POST['itemid'];
                   $name     = $_POST['name'];
                   $desc     = $_POST['description'];
                   $price    = $_POST['price'];
                   $country  = $_POST['country'];
                   $status   = $_POST['status'];
                   $member   = $_POST['member'];
                   $cat      = $_POST['category'];
                   $tags     = $_POST['tags'];
                   
                   
                   $formError = array();
                   
                   if(empty($name)){
                       
                       $formError[] = "Name Cant Be <strong>Empty</strong>";
                   }                   
                           
                   if(empty($desc)){
                       
                       $formError[] = "Description Cant Be <strong>Empty</strong>";
                   }                   
                   if(empty($price)){
                       
                       $formError[] = "Price Cant Be <strong>Empty</strong>";
                   }                   
                   if(empty($country)){
                       
                       $formError[] = "Country Cant Be <strong>Empty</strong>";
                   }                    
                   if($status == 0){
                       
                       $formError[] = "You Must Choose The <strong>Status</strong>";
                   }  
                   if($member == 0){
                       
                       $formError[] = "You Must Choose The <strong>Status</strong>";
                   }                   
                   if($cat == 0){
                       
                       $formError[] = "You Must Choose The <strong>Status</strong>";
                   } 
                   
                   foreach($formError as $error){
                       
                       echo '<div class="alert alert-danger">' . $error . '</div>';
                       
                   }
                   

                   
                   if(empty($formError)){                

                           
                            $stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Member_ID = ?, Cat_ID = ?, Tags = ? WHERE item_ID = ?");
                            $stmt->execute(array($name, $desc, $price, $country, $status, $member, $cat, $tags, $id));
                            $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Updated </div>';
                                         
                            redirectHome($theMsg,'back');
            
                   }

                   
               }else{
               
                      $theMsg = '<div class="alert alert-success">Sorry You Cant Browse This Page Directly</div>';
                                         
                      redirectHome($theMsg);
                   
           
           }
        echo '</div>';

             
         }elseif($do == 'Delete'){
             
                 echo "<h1 class='text-center'>Delete Member</h1>" ;

                 echo '<div class="container">';

                      $itemid = isset ($_GET['itemid'] ) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;                    

                      $check = checkItem("item_ID", "items", $itemid);


                      if($check > 0){

                           $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :Zid");
                           $stmt->bindParam(":Zid", $itemid);
                           $stmt->execute();

                           $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Deleted </div>';

                          redirectHome($theMsg,'back');



                    }else{

                          $theMsg = '<div class="alert alert-danger">This ID Not Exist</div>';

                          redirectHome($theMsg);


                    }

                echo "</div>";

             
         }elseif($do == 'Approve'){
             
                 echo "<h1 class='text-center'>Approve Item</h1>" ;

                 echo '<div class="container">';

                      $itemid = isset ($_GET['itemid'] ) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;                    

                      $check = checkItem("item_ID", "items", $itemid);


                      if($check > 0){

                           $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ?");

                           $stmt->execute(array($itemid));

                           $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Approved </div>';

                          redirectHome($theMsg,'back');



                    }else{

                          $theMsg = '<div class="alert alert-danger">This ID Not Exist</div>';

                          redirectHome($theMsg);


                    }

                echo "</div>";

             
         }
         
     }else{
         header('Location:index.php');
         exit();
     }

    include $tpl . 'footer.php';
   
    ob_end_flush();


?>