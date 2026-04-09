<?php

   $temp = "aaaaaaaaaaa,sssssssssss,dddddddddddddd,";
   $arr = explode(",", $temp);

   for($i=0;$i<count($arr);$i++)
   {
       echo "arr- ". $arr[$i] ."<br>";

   }

?>