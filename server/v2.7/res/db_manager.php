<?php

include "server-config/server-config.php";
include "db-manager/db-manager.php";

 $db_manager = new DBManager();
 $_connection = "";
 $result = $db_manager->db_manager_connect("$server_database_host","$server_database_user","$server_database_pass","$server_database_name","$server_database_port");
 
 if(!$result) {
    
    $_is_connected = "Not connected the " . $server_database_pass;
    
 } else {
    
    $_connection = $result;
    $_is_connected = "Connected the " . $server_database_name;
    
 }
 
 
 
?>

<script>

function view_table(table_name) {
        
    $(function() {
        
        var url = "res/db-manager-responses.php?opt=view_table&table_name=" + table_name;
        
        $("#sub-box-panel").load(url);
    });

}

function select(table_name) {
        
    $(function() {
        
        var url = "res/db-manager-responses.php?opt=select_in_table&table_name=" + table_name;
        
        $("#sub-box-panel-2").load(url);
    });

}

function alter_table(table_name) {
        
    $(function() {
        
        var field_name = prompt("Field ","field1");
        var field_type = prompt("Type ","varchar(30)");
        var field_null = prompt("Null ","true");
        var field_key = prompt("Key ","");
        var field_extra = prompt("Extra","");
        
        var r = "alter table " + table_name + " add " + field_name + " " + field_type + " " + field_null + " " + field_key + " " + field_extra;
        
        var c = confirm("execute query: " + r);
        
        if (!c) {
            
            alert('query canceled');
            
        } else {
        
        var url = "res/db-manager-responses.php?opt=alter_table&table_name=" + table_name + "&field_name=" + field_name + "&field_type=" + field_type + "&field_null=" + field_null + "&field_key=" + field_key + "&field_extra=" + field_extra;
        
        $("#sub-box-panel-2").load(url);
        
        }
    
    });

}

function delete_table(table_name) {
        
    $(function() {
        
        var url = "res/db-manager-responses.php?opt=delete_table&table_name=" + table_name;
        
        $("#sub-box-panel-2").load(url);
    });

}
</script>

<table width='100%'>
    <tr>
        <td width='80%'>
            <span class='box-editor-link' id='db_manager' onclick="alert('under construction')">
                create a new table
            </span>
        </td>
        <td width='5%'>
            
        </td>
        <td style='font:11pt Helvetica;color: skyBlue;'>
            <?php echo $_is_connected ?> 
        </td>
    </tr>
</table>

&nbsp; <br/>

<table width='100%' class='table-tables' border=0>
    <tr>
        <td width='35%'> table name</td>
        <td width='25%'> table options</td>
        <td align='right'>MySQL&reg; query</td>
    </tr>
    <?php
    
    $r = $db_manager->list_tables($_connection);
    
    if($r) {
        
        $tables =  mysqli_num_rows($r);
        
        if($tables > 0) {
        
        for($i=0;$i<$tables;$i++) {
            
            $d = $r->fetch_row();
            
            echo "
                 <tr>
                   <td>
                     $d[0]
                   </td>
                   <td>
                   <a href='#view' onclick=\"view_table('$d[0]')\"> view </a> &nbsp; |
                   <a href='#alter' onclick=\"alter_table('$d[0]')\"> add new field </a> &nbsp; |
                   <a href='#delete' onclick=\"delete_table('$d[0]')\"> delete </a> 
    
                   </td>
                   <td align='right'>
                   <a href='#insert' onclick=\"alert('under construction')\"> insert </a> &nbsp; |
                   <a href='#select' onclick=\"select('$d[0]')\"> select </a> 
                   </td>
                 </tr>
                 ";
            
           }
        } else {
            
            echo "No tables in database...";
            
        }
        
    } else {
        
        echo "error...";
        
    }
    
    
    ?>
</table>

<p>
    <?php echo "total tables: " . $tables ?>
</p>



<div id='sub-box-panel'>
    
    &nbsp;
    
</div>

<div id='sub-box-panel-2'>
    
    &nbsp;
    
</div>