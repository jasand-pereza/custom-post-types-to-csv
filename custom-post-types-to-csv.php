<?php 

/*
 * Plugin Name: Custom Post Types to CSV
 * Plugin URI : https://github.com/jasand-pereza/custom-post-types-to-csv
 * Description: Export posts to a CSV file.
 * Version 1.0
 * Author: Jasand Pereza
 * Author URI: http://www.jasandpereza.com
 * Licencse: GPLv2
*/


add_action('admin_menu' , 'CustomPostTypesToCSV::renderButton');

Class CustomPostTypesToCSV {


  /**
  * Get a combination of custom posts and its post meta data
  * @return array
  */
 public static function getPosts() {
   global $wpdb;
   
   $post_type = array_key_exists('post_type', $_GET) ? $_GET['post_type'] : null;
   if(is_null($post_type)) { return false; exit; }
   
   $post_results = $wpdb->get_results("
      SELECT * FROM wp_posts 
      WHERE post_type = '" . $post_type ."' 
      AND post_status = 'publish'"
      , ARRAY_A
    );
    $wpdb->flush();
    $post_meta_results = $wpdb->get_results("
      SELECT meta_id, post_id, meta_key, meta_value
      FROM wp_postmeta
      RIGHT JOIN wp_posts ON ( wp_posts.ID = wp_postmeta.post_id ) 
      WHERE wp_posts.post_type =  '" . $post_type ."'
      ", ARRAY_A
    );

    $combined = array();
    foreach($post_results as $post) {
      $post_cointainer = $post;
      $meta_container = array();
      foreach($post_meta_results as $meta) {
        if($meta['post_id'] == $post['ID']) $post[$meta['meta_key']] = $meta['meta_value'];
      }
      $combined[] = $post;
    }
    return $combined;
  }
  
  /**
  * Sends headers to download a CSV file
  * @param array $content
  */
  public static function getCSV($content) {
    $fp = tmpfile();
    foreach ($content as $fields) {
      if(empty($header)) { 
        $fields = array_change_key_case($fields, CASE_LOWER);
        $header = array_keys($fields); 
        fputcsv($fp, $header); 
      }
      fputcsv($fp, $fields, ',');
    }
    rewind($fp);
    header("Content-Type:application/csv"); 
    header("Content-Disposition:attachment;filename=file.csv");
    fpassthru($fp);
    fclose($fp); 
  }
  
  /**
  * Tells Wordpress to render a button under each post type
  */
  public static function renderButton() {
    $post_type = array_key_exists('post_type', $_GET) ? $_GET['post_type'] : null;
    if(is_null($post_type)) return;
    add_submenu_page('edit.php?post_type=' . $post_type , 'Custom Post Type Admin', 'Export CSV' , 'edit_posts',  '/../../' . basename(WP_CONTENT_URL) . '/plugins/custom-post-types-to-csv/download.php/?post_type=' . $post_type);
  }
  
}
