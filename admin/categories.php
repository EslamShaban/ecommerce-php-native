<?php 


    /*
    ===========================================
    == Categories Page
    ===========================================
    */

      ob_start();

      session_start();

      $pageTitle = 'Categories';

     if(isset($_SESSION['Username'])){
         
         include 'init.php';

         $do = (isset($_GET['do']))? $_GET['do'] : 'Manage';
         
         
         if($do == 'Manage'){
             
             $sort = 'ASC';
             
             $sort_array = array('ASC', 'DESC');
             
             if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
                             
                 $sort = $_GET['sort'];

             }
             
             $stmt = $con->prepare("SELECT *  FROM categories where parent=0 ORDER BY Ordering $sort");
             $stmt->execute();
             $cats = $stmt->fetchAll(); 

             if(! empty($cats)){

             ?>

            <h1 class="text-center">Manage Categories</h1>

            <div class="container categories">

                <div class="panel panel-default">
                
                    <div class="panel-heading">
                        
                        <i class="fa fa-edit"></i> Manage Categories
                        
                        <div class="option pull-right">
                        
                            <i class="fa fa-sort"></i> Ordering : [
                            <a class = " <?php if($_GET['sort']=='ASC' || $sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC">ASC</a> | 
                            <a class = " <?php if($_GET['sort']=='DESC'){echo 'active';} ?>" href="?sort=DESC">DESC</a> ]
                            
                            <i class="fa fa-eye"></i> View : [
                            
                            <span class="active" data-view='full'>Full</span> | 
                            <span>Classic</span> ]
                        
                        </div>
                    
                    
                    </div>
                    <div class="panel-body">
                    
                        <?php  
                        
                            foreach($cats as $cat){
                                
                                echo "<div class='cat'>";
                                
                                        echo "<div class='hidden-buttons'>";
                                
                                             echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                             echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
                                
                                        echo "</div>";
                                        echo "<h3>" . $cat['Name'] . "</h3>";
                                        echo "<div class='full-view'>";
                                            echo "<p>";  if($cat['Description'] == ''){echo 'This category has no description';}else{echo $cat['Description'];} echo"</p>";
                                            if($cat['Visibility'] == '1'){echo "<span class='visibility equalone'><i class='fa fa-eye'></i> Hidden </span>";} 
                                            if($cat['Allow_Comment'] == '1'){echo "<span class='Commenting equalone'><i class='fa fa-close'></i> Comment Disabled</span>";} 
                                            if($cat['Allow_Ads'] == '1'){echo "<span class='Advertise equalone'><i class='fa fa-close'></i> Ads Disabled </span>";} 
                                        echo "</div>";


                                        // Get Child Categories
                                        
                                        $childCategories = getAllFrom("*", "categories", "where parent = {$cat['ID']} ", "", "ID");

                                        if(! empty($childCategories)){

                                            echo "<h4 class='child-head'>Child Categories</h4>";

                                            echo "<ul class='list-unstyled child-cats'>";

                                                foreach ($childCategories as $child) {

                                                    echo "<li class='child-link'>

                                                    <a href='categories.php?do=Edit&catid=" . $child['ID'] . " ' >". $child['Name'] . " </a>
                                                    <a href='categories.php?do=Delete&catid=" . $child['ID'] . "' class='confirm show-delete'> Delete</a>

                                                    </li>";
                                                }

                                            echo "</ul>";

                                        }
                                echo "</div>";

                                echo "<hr>";
                            }
                        
                        ?>
                    
                    </div>
                
                </div>
                <a href="categories.php?do=Add" class="add-category btn btn-primary" ><i class="fa fa-plus"></i> Add New Category</a>

            </div>
            <?php } else{

                  echo "<div class='container'>";
                       echo "<div class='nice-message'>There's No Categories To Show</div>";
                       echo '<a href="categories.php?do=Add" class="add-category btn btn-primary" ><i class="fa fa-plus"></i> Add New Category</a>';

                  echo "</div>";
            }?>  
             
        <?php  }elseif($do == 'Add'){ ?>
               
                
                <h1 class="text-center">Add New Category</h1>

                <div class="container">

                    <form class="form-horizontal" action="?do=Insert" method="POST">                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Name</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Type Category Name">
                            </div>
                            
                        </div>
                                            
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Description</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" class="form-control" placeholder="Type Description For This Category">
                            </div>
                            
                        </div>

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Ordering</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Category">
                            </div>
                            
                        </div>

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Parent ?</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <select name="parent">
                                    <option value="0">None</option>
                                    <?php 

                                        $allCats = getAllFrom("*", "categories", "where parent=0", "", "ID", $ordering = 'ASC');

                                        foreach ($allCats as $cat) {

                                            echo "<option value='" . $cat['ID']. "'>" . $cat['Name'] . "</option>"; 
                                        }
                                         
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                    
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Visibility</label>
                            
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id = "vis-yes" type="radio" name="visibility" value="0" checked>
                                    <label for="vis-yes">Yes</label>
                                </div>                                
                                <div>
                                    <input id = "vis-no" type="radio" name="visibility" value="1">
                                    <label for="vis-no">No</label>
                                </div>
                                
                            </div>
                            
                        </div>                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Allow Commenting</label>
                            
                            <div class="col-sm-10 col-md-6">
                                
                                <div>
                                    
                                    <input id = "com-yes" type="radio" name="commenting" value="0" checked>
                                    
                                    <label for="com-yes">Yes</label>
                                    
                                </div>       
                                
                                <div>
                                    
                                    <input id = "com-no" type="radio" name="commenting" value="1">
                                    
                                    <label for="com-no">No</label>
                                    
                                </div>
                                
                            </div>
                            
                        </div>                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            
                            <div class="col-sm-10 col-md-6">
                                
                                <div>
                                    
                                    <input id = "Ad-yes" type="radio" name="ads" value="0" checked>
                                    
                                    <label for="Ad-yes">Yes</label>
                                    
                                </div>    
                                
                                <div>
                                    
                                    <input id = "Ad-no" type="radio" name="ads" value="1">
                                    
                                    <label for="Ad-no">No</label>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                    
                        <div class="form-group">
                                                    
                            <div class="col-sm-offset-2 col-sm-10">
                                
                                <input type="submit" value="Add Category" class="btn btn-primary btn-lg">
                                
                            </div>
                            
                        </div>
                    
                    </form>
    
                </div>

               
               
           <?php 
         }elseif($do == 'Insert'){
             
             
                            
               echo '<div class="container">';
               
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                  
                   echo "<h1 class='text-center'>Insert Category</h1>" ;

                   $name     = $_POST['name'];
                   $desc     = $_POST['description'];
                   $parent   = $_POST['parent'];
                   $order    = $_POST['ordering'];
                   $visible  = $_POST['visibility'];
                   $comment  = $_POST['commenting'];
                   $ads      = $_POST['ads'];               
                   
                       
                       $check = checkItem("Name", "categories",$name);
                       
                       if($check == 1){
                           $theMsg = '<div class="alert alert-danger">This Category Is Exist</div>';
                           redirectHome($theMsg, 'back');

                       }else{
                           
                              $stmt = $con->prepare("INSERT INTO 
                                             categories(Name, Description, parent, Ordering, Visibility, Allow_Comment, Allow_Ads)
                                             VALUES(:Zname, :Zdesc, :Zparent, :Zorder, :Zvisibile, :Zcomment, :Zads)");
                              $stmt->execute(array(
                       
                                  "Zname"      => $name,
                                  "Zdesc"      => $desc,
                                  ":Zparent"   => $parent,
                                  "Zorder"     => $order,
                                  "Zvisibile"  => $visible,
                                  "Zcomment"   => $comment,
                                  "Zads"       => $ads
                       
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

                $catid = isset ($_GET['catid'] ) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                $stmt = $con->prepare("SELECT * FROM categories Where ID = ?");
                $stmt->execute(array($catid));
                $cat = $stmt->fetch();
                $count = $stmt->rowCount();
                if($count>0){ ?>

                
                        <h1 class="text-center">Edit Category</h1>

                        <div class="container">

                            <form class="form-horizontal" action="?do=Update" method="POST">   
                                
                                                        
                                <input type="hidden" name="catid" value="<?php echo $catid ?>" >

                                
                                <div class="form-group form-group-lg">

                                    <label class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="name" class="form-control" required="required" placeholder="Type Category Name" value="<?php echo $cat['Name']; ?>">
                                    </div>

                                </div>

                                <div class="form-group form-group-lg">

                                    <label class="col-sm-2 control-label">Description</label>

                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="description" class="password form-control" placeholder="Type Description For This Category" value="<?php echo $cat['Description']; ?>">
                                    </div>

                                </div>

                                <div class="form-group form-group-lg">

                                    <label class="col-sm-2 control-label">Ordering</label>

                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Category" value="<?php echo $cat['Ordering']; ?>" >
                                    </div>

                                </div>

                                <div class="form-group form-group-lg">
                                
                                    <label class="col-sm-2 control-label">Parent ?</label>
                                    
                                    <div class="col-sm-10 col-md-6">
                                        <select name="parent">
                                            <option value="0">None</option>
                                            <?php 

                                                $allCats = getAllFrom("*", "categories", "where parent=0", "", "ID", $ordering = 'ASC');

                                                foreach ($allCats as $c) {

                                                    echo "<option value='" . $c['ID']. "'";
                                                    if($cat["parent"] == $c['ID']){echo "selected";}
                                                    echo ">" . $c['Name'] . "</option>"; 
                                                }
                                                 
                                            ?>
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="form-group form-group-lg">

                                    <label class="col-sm-2 control-label">Visibility</label>

                                    <div class="col-sm-10 col-md-6">
                                        <div>
                                            <input id = "vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0){echo 'checked';} ?> >
                                            <label for="vis-yes">Yes</label>
                                        </div>                                
                                        <div>
                                            <input id = "vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1){echo 'checked';} ?> >
                                            <label for="vis-no">No</label>
                                        </div>

                                    </div>

                                </div>                        
                                <div class="form-group form-group-lg">

                                    <label class="col-sm-2 control-label">Allow Commenting</label>

                                    <div class="col-sm-10 col-md-6">

                                        <div>

                                            <input id = "com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0){echo 'checked';} ?>>

                                            <label for="com-yes">Yes</label>

                                        </div>       

                                        <div>

                                            <input id = "com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1){echo 'checked';} ?>>

                                            <label for="com-no">No</label>

                                        </div>

                                    </div>

                                </div>                        
                                <div class="form-group form-group-lg">

                                    <label class="col-sm-2 control-label">Allow Ads</label>

                                    <div class="col-sm-10 col-md-6">

                                        <div>

                                            <input id = "Ad-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){echo 'checked';} ?>>

                                            <label for="Ad-yes">Yes</label>

                                        </div>    

                                        <div>

                                            <input id = "Ad-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1){echo 'checked';} ?>>

                                            <label for="Ad-no">No</label>

                                        </div>

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

            
               echo "<h1 class='text-center'>Update Category</h1>" ;
               echo '<div class="container">';
               
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                    $id       = $_POST['catid'];
                    $name     = $_POST['name'];
                    $desc     = $_POST['description'];
                    $parent   = $_POST['parent'];
                    $order    = $_POST['ordering'];

                    $visibil  = $_POST['visibility'];
                    $comment  = $_POST['commenting'];
                    $ads      = $_POST['ads'];



                    $stmt = $con->prepare("UPDATE 
                                                 categories 
                                              SET
                                                 Name = ?, 
                                                 Description = ?,
                                                 parent = ?,
                                                 Ordering = ?, 
                                                 Visibility = ?, 
                                                 Allow_Comment = ?,
                                                 Allow_Ads = ?
                                            WHERE 
                                                 ID = ?");
                    $stmt->execute(array($name, $desc, $parent,  $order, $visibil, $comment, $ads, $id));
                   
                    $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Updated </div>';

                    redirectHome($theMsg,'back');

                   
               }else{
               
                      $theMsg = '<div class="alert alert-success">Sorry You Cant Browse This Page Directly</div>';
                                         
                      redirectHome($theMsg);
            
           }
         
        echo '</div>';


         }elseif($do == 'Delete'){

                 echo "<h1 class='text-center'>Delete Category</h1>" ;

                 echo '<div class="container">';

                      $catid = isset ($_GET['catid'] ) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;                    

                      $check = checkItem("ID", "categories", $catid);


                      if($check > 0){

                           $stmt = $con->prepare("DELETE FROM categories WHERE ID = :Zid");
                           $stmt->bindParam(":Zid", $catid);
                           $stmt->execute();

                           $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Deleted </div>';

                          redirectHome($theMsg,'back');



                    }else{

                          $theMsg = '<div class="alert alert-danger">This ID Not Exist</div>';

                          redirectHome($theMsg);


                    }

                echo "</div>";

         }

         include $tpl . 'footer.php';

     }else{

        header('Location:index.php');
        exit();
     }


    ob_end_flush();


?>