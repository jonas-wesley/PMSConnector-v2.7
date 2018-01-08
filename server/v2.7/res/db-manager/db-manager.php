<?php

class DBManager  {
    
   public function db_manager_connect($host,$user,$pass,$dbname,$port=3306) {
        
        /* new mysqli connection */
        $_connection = new mysqli($host,$user,$pass,$dbname,$port);
        
        if(mysqli_connect_errno()) {
            
            /* get error */
            $error = mysqli_connect_error();
            
            /* display error message */
            echo "not connected, error: $error";
            
            /* return false, stop requesting... */
            return false;
        
        } else {
            
            /* if all ok return connection object */
            return $_connection;
            
        }
    
   }
   
   public function list_tables($_connection) {
    
      $result = $_connection->query("show tables") or die("Data not found");
      
      return $result;
   }
   
   public function desc_table($_connection,$table) {
    
      $result = $_connection->query("desc $table") or die("Data not found");
      
      if($result) {
        
        $rows = mysqli_num_rows($result);
        
        echo "
             <table width='100%' class='table-rows'>
                <tr>
                  <td> Field </td>
                  <td> Type </td>
                  <td> Null </td>
                  <td> Key </td>
                  <td> Default </td>
                  <td> Extra </td>
                </tr>
             ";
             
             for($i=0;$i<$rows;$i++) {
                
                $d = $result->fetch_row();
                
        echo "
                <tr>
                  <td> -> $d[0] </td>
                  <td> $d[1] </td>
                  <td> $d[2] </td>
                  <td> $d[3] </td>
                  <td> $d[4] </td>
                  <td> $d[5] </td>
                </tr>
             ";
                
             }
             
             echo "
                  </table>
                  <p>
                  $rows rows in table $table
                  </p>
                  ";
        
      }
    
   }
   
   public function select_in_table($_connection,$table) {
    
    $result = $_connection->query("select * from $table") or die("Data not found");
    
    if($result) {
        
        $result_table_info = $_connection->query("desc $table") or die("Data not found.");
        $get_rows = mysqli_num_rows($result_table_info);
        
        echo "
             <table width='100%' class='table-rows'>
             <tr>
             ";
             
        for($i=0;$i<$get_rows;$i++) {
            
            $d = $result_table_info->fetch_row();
            
            echo "
                     <td> $d[0] </td>
                 
                 ";
        }
        
        echo "
              <td> actions </td>
              </tr>
              
              ";
        
        $rows = mysqli_num_rows($result);
        
        if($rows > 1) {
        
        for($i=0;$i<$rows;$i++) {
            
            $d = $result->fetch_row();
            
            echo "<tr>";
            
            for($ii=0;$ii<$get_rows;$ii++) {
                
            echo "<td>$d[$ii]</td>";
            
            }
            
            echo "
                 <td>
                 <a href='#delete'> delete </a> &nbsp; or &nbsp;
                 <a href='#update'> update </a>
                 </td>
                 </tr>";
            
          }
          
          echo "
                </tr>
                </table>
                <p> $rows rows in $table </p>
                ";
          
        } else {
            
            $d = $result->fetch_row();
            
            echo "<tr>";
            
            for($ii=0;$ii<$get_rows;$ii++) {
                
            echo "<td>$d[$ii]</td>";
            
            }
            
            echo "
                 <td>
                 <a href='#delete'> delete </a> &nbsp; or &nbsp;
                 <a href='#update'> update </a>
                 </td>
                  </tr>
                  </table>
                  <p> $rows row in $table </p>
                  ";
            
        }
    } else {
        
        echo "Data not found.";
        
    }
    
   }
   
   public function alter_table($_connection,$table,$query) {
    
         $result = $_connection->query($query);
         
         if($result) {
            
            echo "<script>alert('ok, field added.');</script>";
            
         } else {
            
            echo "<script>alert('error field not added.');</script>";
            
         }
    
    
   }
   
   public function delete_table($_connection,$table) {
    
    $result = $_connection->query("drop table $table");
    
    if($result) {
        
        echo "<script>alert('table $table deleted. actualize page.');</script>";
        
    } else {
        
        echo "<script> alert('delete table $table error.');</script>";
        
    }
    
   }
}