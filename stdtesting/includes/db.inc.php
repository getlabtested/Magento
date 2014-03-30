<?php

function connection() {
   global $conn;
   if($conn) {
      return $conn;
   } else {
      $conn = mysql_connect(db_host, db_user, db_pass);
      if (!$conn || !mysql_select_db(db_database, $conn)) {
         return 0;
      } else {
         return $conn;
      }
   }
}

function sql($query) {
   if(!($conn = connection())) {
      return 0;
   } else {
      $result = mysql_query($query, $conn);
      if(!$result) {
         print("<div><hr style=\"width: 100%; height: 1px;\"><b>Error:</b><br>[\"$query\"]<br>[".mysql_error()."]<hr style=\"width: 100%; height: 1px;\"></div>");
      } else {
         return $result;
      }
   }
}

?>
