<?php

    /*
    * Plugin Name: Mortgage Calculator STIT
    * Plugin URI: https://softtechiit.com
    * Description: Mortgage Calculator Api
    * Author: Sabbir Hossain and JH Fahim
    * Author URI: https://github.com/devsabbirhossain
    * Version: 1.0.0
    */


    if ( ! defined( 'ABSPATH' ) )
    {
        exit; // Exit if accessed directly
    }

    define('PLUGIN_URL', plugin_dir_path( __FILE__ ));
    define('PLUGIN_URL_INCLUDE', PLUGIN_URL.'/include');

    if(file_exists(PLUGIN_URL_INCLUDE. '/mortgage-calculator.php')){
        require_once(PLUGIN_URL_INCLUDE. '/mortgage-calculator.php');
    }
    if(file_exists(PLUGIN_URL_INCLUDE. '/api.php')){
        require_once(PLUGIN_URL_INCLUDE. '/api.php');
    }

 
/*********************************************
 *        admin menu page
 *********************************************/

function wc_admin_menu_page() {
   add_menu_page(
       __( 'Menu Name', 'mortgage-calculator' ),
       'Mortgage Calculator',
       'manage_options',
       'mortgage-calculator',
       'call_back_functions_display',
       'dashicons-calculator',
       //plugins_url( 'myplugin/images/icon.png' ),
       58
   );
 
}

add_action( 'admin_menu','wc_admin_menu_page') ;

//display call back function
function call_back_functions_display(){
    ?> 

    <div class="mortgagecalculator">
        <h3>Mortgage Calculator</h3>
        <form action="options.php" method="POST">
            <?php settings_fields( 'maildollapi' ); ?>
            <?php do_settings_sections( 'maildollapi' ); ?>
            <label for="tariffCode"> TariffCode </label> <br>
            <input type="text" name="tariffCode" id="tariffCode" value="<?php echo get_option('tariffCode') ?>"> <br>
            <label for="commissionPercentage"> Commission Percentage </label> <br>
            <input type="number" name="commissionPercentage" id="commissionPercentage" value="<?php echo  get_option('commissionPercentage') ?>">
            <?php submit_button(); ?>
        </form>
    </div>

    <?php
    if(isset($_POST['save'])){

        $tariffCode = $_GET['tariffCode'];
        $commissionPercentage = $_GET['commissionPercentage'];
        update_option( 'tariffCode',$tariffCode );
        update_option( 'commissionPercentage',$commissionPercentage );

    }
    
}
function register_maildoll_plugin_settings() {
    //register our settings
    register_setting( 'maildollapi', 'tariffCode' );
    register_setting( 'maildollapi', 'commissionPercentage' );
}
add_action( 'admin_init', 'register_maildoll_plugin_settings');