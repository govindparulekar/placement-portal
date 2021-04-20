<?php
$upload_dir = 'uploads/sheets/';
$file_temp_name = $_FILES['sheet']['temp_name'];
$file_name = $_FILES['sheet']['name'];
$file_ext = strtolower(end(explode('.',$file_name)));
echo $file_ext;