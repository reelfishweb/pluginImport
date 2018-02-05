<?php
/*
 Plugin Name: ImportXMLfromHTTP
 Plugin URI:  ....
 Description: Importowanie produktów z XML do woocommerce umieszczonych na serwerze HTTP
 Version:     1
 Author:      mazur
 Author URI:  reelfishweb@gmail.com
 License:     GPL2
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 Text Domain: wporg
 Domain Path: pl
 */


define( 'ImportXMLfromHTTP__Version', '1' );
define( 'ImportXMLfromHTTP__MINIMUM_WOO_VERSION', '3.7' );
define( 'ImportXMLfromHTTP__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ImportXMLfromHTTP__PLUGIN', plugin_basename( __FILE__) );
define( 'ImportXMLfromHTTP_DELETE_LIMIT', 100000 );

function searchClass($path) {
    $dir = new DirectoryIterator($path);
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isFile() || $fileinfo->isLink()) {
            require_once $fileinfo->getPathName();
        } elseif (!$fileinfo->isDot() && $fileinfo->isDir()) {
            searchClass($fileinfo->getPathName());
        }
    }
}
function autoLoadClass(){
    $base_dir = dirname(__FILE__) . '/class/';
    searchClass($base_dir);
}
autoLoadClass();

register_activation_hook( __FILE__, array( 'ImportXMlFromHTTP', 'activation_plugin' ) );

function rmlc_plugin_menu() {
    add_menu_page('Logo Carousel', 'Logo Carousel', 'administrator', 'rmlc_settings', 'rmlc_display_settings');
    add_submenu_page('rmlc_settings', __('Images'), __('Images'), 'edit_themes', 'rmlc_images', 'rmlc_images');
}
add_action('admin_menu', 'rmlc_plugin_menu');

function rmlc_display_settings(){
    $import = new ImportXMlFromHTTP();
    $import->importXMLCatalogList();
}

