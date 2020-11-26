<?php 


     function lang($Phrase){

         static $Lang = array(
         
         'HOME_ADMIN'     =>  'Home',
         'Categories'     =>  'Categories',
         'ITEMS'          =>  'Items',
         'MEMBERS'        =>  'Members',
         'Comments'       =>  'Comments',
         'STATISTICS'     =>  'Statistics',
         'LOGS'           =>  'Logs',
         'DROPDOWN'       =>  'dropdown',
         'EDIT'           =>  'Edit',
         'SETTING'        =>  'Setting',
         'LOGOUT'         =>  'Logout'
         );
         
         return $Lang[$Phrase];
    
     }
