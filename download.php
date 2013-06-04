<?php

// Bootstrap WordPress
$install_dir = realpath(dirname(__FILE__) . '/../../../../wordpress') . '/'; // You might have to change this
chdir($install_dir);
include('wp-load.php');

$posts = CustomPostTypesToCSV::getPosts(); 
CustomPostTypesToCSV::getCSV($posts);
