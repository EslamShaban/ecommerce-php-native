<?php 
     
        session_start();

        $pageTitle = 'Create New Item';

        include 'init.php';
        
        if(isset($_SESSION['user'])){

        	if($_SERVER['REQUEST_METHOD'] == 'POST'){

        		$formErrors = array();

        		$name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $desc     = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                $price    = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
                $country  = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
                $status   = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
                $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
                $tags     = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

                if(strlen($name) < 4){
                	$formErrors[] = 'Name Must Be At Least 4 Characters';
                }

                if(strlen($desc) < 10){
                	$formErrors[] = 'Description Must Be Larger Than 10 Characters';
                }

                if(empty($price)){
                	$formErrors[] = 'Price Can\'t Be Empty';
                }

                if(strlen($country) < 2){
                	$formErrors[] = 'Country Must Be At Least 2 Characters';
                }

                if(empty($status)){
                	$formErrors[] = 'Status Can\'t Be Empty';
                }

                if(empty($category)){
                	$formErrors[] = 'Category Can\'t Be Empty';
                }


                if(empty($formError)){                
               
        
                          $stmt = $con->prepare("INSERT INTO 
                                         items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, Tags)
                                         VALUES(:Zname, :Zdesc, :Zprice, :Zcountry, :Zstatus, now(), :Zcat, :Zmember, :Ztags)");
                          $stmt->execute(array(
                   
                              "Zname"      => $name,
                              "Zdesc"      => $desc,
                              "Zprice"     => '$' . $price,
                              "Zcountry"   => $country,
                              "Zstatus"    => $status,
                              "Zcat"       => $category,
                              "Zmember"    => $_SESSION['uid'],
                              "Ztags"      => $tags
                   
                   ));
                   
                       if($stmt){
                                 
                            $successMsg = 'Item Has Been Added';

                       }
                       
                   
                   
               }

               
           }


?>

<h1 class="text-center"><?php echo $pageTitle ?></h1>

<div class="create-ad block">
	
	<div class="container">
		
		<div class="panel panel-primary">
			
			<div class="panel-heading"><?php echo $pageTitle ?></div>
			<div class="panel-body">

				<div class="row">
					
					<div class="col-md-8">
						
	                    <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">                    
	                        <div class="form-group form-group-lg">
	                        
	                            <label class="col-sm-2 control-label">Name</label>
	                            
	                            <div class="col-sm-10 col-md-9">
	                                <input 
	                                       pattern=".{4,}"
	                                       title="This Field Required At Least 4 Characters" 
	                                       type="text" 
	                                       name="name" 
	                                       class="form-control live" 
	                                       placeholder="Name of The Item"
	                                       data-class='.live-name'
	                                       required  />
	                            </div>
	                            
	                        </div>
	                                            
	                        <div class="form-group form-group-lg">
	                        
	                            <label class="col-sm-2 control-label">Description</label>
	                            
	                            <div class="col-sm-10 col-md-9">
	                                <input 
	                                       pattern=".{10,}"
	                                       title="This Field Required At Least 10 Characters" 
	                                       type="text" 
	                                       name="description" 
	                                       class="form-control live"                                      
	                                       placeholder="Type Description For This Item"
	                                       data-class='.live-desc'
	                                       required>
	                            </div>
	                            
	                        </div>                        
	                        
	                        <div class="form-group form-group-lg">
	                        
	                            <label class="col-sm-2 control-label">Price</label>
	                            
	                            <div class="col-sm-10 col-md-9">
	                                <input type="text" 
	                                       name="price" 
	                                       class="form-control live"                                      
	                                       placeholder="Price of The Item"
	                                       data-class='.live-price'
	                                       required>
	                            </div>
	                            
	                        </div>  
	                        
	                        <div class="form-group form-group-lg">
	                        
	                            <label class="col-sm-2 control-label">Country</label>
	                            
	                            <div class="col-sm-10 col-md-9">
	                                <input type="text" 
	                                       name="country" 
	                                       class="form-control"                                      
	                                       placeholder="Country of Made"
	                                       required>
	                            </div>
	                            
	                        </div> 
	                        
	                        <div class="form-group form-group-lg">
	                        
	                            <label class="col-sm-2 control-label">Status</label>
	                            
	                            <div class="col-sm-10 col-md-9">
	                              
	                                <select name="status" class="form-control" required>
	                                
	                                    <option value="">...</option>
	                                    <option value="1">New</option>
	                                    <option value="2">Like New</option>
	                                    <option value="3">Used</option>
	                                    <option value="4">Very Old</option>
	                                    
	                                </select>
	                                
	                            </div>
	                            
	                        </div>                       
	                        
	                        <div class="form-group form-group-lg">
	                        
	                            <label class="col-sm-2 control-label">Category</label>
	                            
	                            <div class="col-sm-10 col-md-9">
	                              
	                                <select name="category" class="form-control" required>
	                                
	                                    <option value="">...</option>
	                                   <?php 
	             
	                                      $cats = getAllFrom('*', 'categories', '', '', 'ID');
	                                          
	                                      foreach($cats as $cat){
	                                          
	                                          echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] .  "</option>";
	                                      }
	                                    
	                                    
	                                    ?>
	                                    
	                                </select>
	                                
	                            </div>
	                            
	                        </div>

	                        <div class="form-group form-group-lg">
	                        
	                            <label class="col-sm-2 control-label">Tags</label>
	                            
	                            <div class="col-sm-10 col-md-9">
	                                <input type="text" 
	                                       name="tags" 
	                                       class="form-control"                                
	                                       placeholder="Seperate tags with comma (,)">
	                            </div>
	                            
	                        </div> 
	                    
	                    
	                        <div class="form-group">
	                                                    
	                            <div class="col-sm-offset-2 col-sm-9">
	                                
	                                <input type="submit" value="Add Item" class="btn btn-primary btn-lg">
	                                
	                            </div>
	                            
	                        </div>
	                    
	                    </form>

					</div>
					<div class="col-md-4">
                		<div class='thumbnail item-box live-preview'>
                			<span class='price-tag'>
                			   $  <span class="live-price">0</span>
                		    </span>
                			<img class = 'img-responsive' src='layout/images/avatar.png' alt='' >
                            <div class="caption">
	                			<h3 class="live-name">Title</h3>
	                			<p class="live-desc">Description</p>
                            </div>
                		</div>

					</div>

				</div>

               <!-- Start Looping Through Errors -->

                <?php 
                     
                     if(! empty($formErrors)){
                     	foreach ($formErrors as $error) {
                     		echo '<div class="alert alert-danger">' . $error . '</div>';
                     	}
                     }

                     if(isset($successMsg)){
                 	   
                 	   echo '<div class="alert alert-success">' . $successMsg . '</div>';
                 
                    }


                ?>

               <!-- End Looping Through Errors -->

				
			</div>

		</div>

	</div>

</div>


<?php 

   } else {

   	    header("Location: login.php");

   	    exit();
   }


    include $tpl . 'footer.php'; 

 ?>