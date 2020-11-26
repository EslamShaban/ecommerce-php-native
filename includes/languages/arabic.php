<?php 


     function lang($Phrase){
         

         static $lang = array(
         
         'HOME_ADMIN'   =>     'الرئيسيه',
         'Categories'   =>      'الاقسام',
         'ITEMS'        =>     'العناصر',
         'MEMBERS'      =>    ' الاعضاء',
         'STATISTICS'   =>    'الاحصائيات',
         'LOGS'         =>      'الدخول',
         'DROPDOWN'     =>       'القائمة',
         'EDIT'         =>       'تحرير',
         'SETTING'      =>      'الاعدادات',
         'LOGOUT'       =>    'تسجيل خروج'
            
         ); 
         
         return $lang[$Phrase];
         
     }
?>