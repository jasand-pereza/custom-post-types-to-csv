custom-post-types-to-csv
========================

Custom Post Types to CSV - A lightweight Wordpress plugin that allows you to easily export posts from your custom post types.

### Install

* Put the "custom-post-types-to-csv" folder in your plugins directory.
* Active in the Wordpress admin

#### Path changes
You may need to change the relative path of $install_dir in download.php to match your installation.

```PHP
<?php

// Bootstrap WordPress
$install_dir = realpath(dirname(__FILE__) . '/../../../../wordpress') . '/'; // You might have to change this
chdir($install_dir);
include('wp-load.php');

PostsToCSV::getPosts(); 

```
