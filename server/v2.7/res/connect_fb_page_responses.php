<?php

# get app data
$fb_app_name = $_GET['fb_app_name'];
$fb_app_token = $_GET['fb_app_token'];
$fb_app_pageid = $_GET['fb_app_pageid'];

# app info
$pre_file = "<?php
             # App name
             \$fb_app_name = \"$fb_app_name\";
             
             # app token
             \$fb_app_token = \"$fb_app_token\";
             
             # App PageID
             \$fb_app_pageid = \"$fb_app_pageid\";
             
             ";
# new file
$f = "fb-apps/" . $fb_app_name . ".php";

# open and write new file
$file = fopen("$f","a+");
fwrite($file, $pre_file);
fclose($file);

if(file_exists($f)) {
    echo "App $fb_app_name added.";
} else {
    echo "error, app $fb_app_name not added.";
}
?>