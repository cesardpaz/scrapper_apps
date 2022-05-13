<?php 
/**
 * Plugin Name:         Scrapper Apps
 * Plugin URI:          https://ficevi.com/
 * Description:         Scrapper for sites of Apps
 * Version:             1.0.0
 * Requires at least:   5.2
 * Requires PHP:        7.0
 * Author:              César De Paz
 * Author URI:          https://ficevi.com/
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         scrapp
 * Domain Path:         /languages
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}
global $wpdb;

define( 'SCRAPP_REALPATH_BASENAME_PLUGIN', dirname( plugin_basename( __FILE__ ) ) . '/' );
define( 'SCRAPP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SCRAPP_DIR_URI', plugin_dir_url( __FILE__ ) );
define( 'SCRAPP_VERSION', '1.0.0' );

require_once SCRAPP_DIR_PATH . 'includes/class-scrapp-master.php';

function scrapp_master() {
    $bc_master = new SCRAPP_Master;
    $bc_master->run();
}

scrapp_master();

/* function upload image */
function Generate_Featured_Image( $image_url, $post_id = false  ){
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);
 
    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
  
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    if($post_id){
        $res2= set_post_thumbnail( $post_id, $attach_id );
    }

    return $attach_id;
    
}