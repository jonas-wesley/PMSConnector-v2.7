<?php

include "db-manager/db-manager.php";
include "server-config/server-config.php";

if(getenv("REQUEST_METHOD")=="GET") {
    
    $opt = $_GET['opt'];
    $db_manager = new DBManager();
    $_connection = $db_manager->db_manager_connect("$server_database_host","$server_database_user","$server_database_pass","$server_database_name","$server_database_port");
    
if($opt=="view_table") {
    
    $table = $_GET['table_name'];
    

    if(!$_connection) {
        
        echo "error..";
        
    } else {
        
        $db_manager->desc_table($_connection,$table);
        
    }
 
 } elseif($opt=="select_in_table") {
    
    $table = $_GET['table_name'];
    

    if(!$_connection) {
        
        echo "error..";
        
    } else {
        
        $db_manager->select_in_table($_connection,$table);
        
    }
 
 } elseif($opt=="alter_table" ) {
    
     $table = $_GET['table_name'];
     
     $field_name = $_GET['field_name'];
     $field_type = $_GET['field_type'];
     $field_null = $_GET['field_null'];
     $field_key = $_GET['field_key'];
     $field_extra = $_GET['field_extra'];
     
     if($field_null=="true") {
        
        $field_null = "null";
        
     } else {
        
        $field_null = "not null";
        
     }
    
    
    if(!$_connection) {
        
        echo "error..";
        
    } else {
        
        $query = "alter table $table add $field_name  $field_type  $field_null  $field_key  $field_extra";
        
        $db_manager->alter_table($_connection,$table,$query);
        
    }
 } elseif($opt=="delete_table") {
    
    $table = $_GET['table_name'];
    

    if(!$_connection) {
        
        echo "error..";
        
    } else {
        
        $db_manager->delete_table($_connection,$table);
        
    }
 
 } 
 
}


