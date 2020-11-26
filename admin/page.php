<?php 

   $do = isset($_GET['do'])? $_GET['do'] : 'Manage';

   if($do == 'Manage'){
       
       echo 'Welcome You are in Manage Category Page';
       
   }elseif($do == 'Add'){
              
       echo 'Welcome You are in Add Category Page';

   }elseif($do == 'Insert'){
              
       echo 'Welcome You are in Insert Category Page';

   }else{
       
       echo 'Error Ther\'s No Page With This Name';
   }