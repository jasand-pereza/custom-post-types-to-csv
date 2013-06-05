Custom Post Types to CSV
========================

#### Wordpress plugin
Ths is a lightweight Wordpress plugin that allows you to easily export posts from your custom post types.

#### Install

* Put the "custom-post-types-to-csv" folder in your plugins directory.
* Activate in the Wordpress admin.

#### Wordpress Requirements
This version has only been tested with Wordpress versions 3.5 and up. 
Testing still needs to be done to make sure this is suitable for older versions. Use at your own risk.

#### Path changes
You may need to change the relative path of the $install_dir in download.php to match your installations root directory.

```PHP
<?php

// Bootstrap WordPress
$install_dir = realpath(dirname(__FILE__) . '/../../../../wordpress') . '/'; // You might have to change this
chdir($install_dir);
include('wp-load.php');

$posts = CustomPostTypesToCSV::getPosts(); 
CustomPostTypesToCSV::getCSV($posts);


```

#### In the Near Future
The plan is to get custom-post-types-to-csv in the Wordpress SVN repo.
