<?php

/**
 * This is of simple demonstration of using Axios (https://github.com/axios/axios) for making WordPress Axaj call
 * The ajax call will fetch a randomly generated name array from the backend and display it onto the screen.
 * The display logic is written using Vue.js v2.
 *
 *  @package wordpress-axios-ajax
 *
 * Plugin Name:       WordPress Ajax Using Axios.js demo.
 * Description:       The plugin will demonstrate a simple WordPress ajax call using axios. the display logic is written using Vue.js
 * Version:           1.0.0
 * Author:            Karthik Thayyil
 * Author URI:        https://kt12.in/blog/wordpress-ajax-call-using-axios-js/
 */

// If this file is called directly, abort.
if ( !defined('WPINC') ) {
    die;
}

/**
 *  Enqueue all scripts needed for this demo
 *  @return void
 */
function wordpress_axios_scripts()
{
    // it's a good practice to download the files locally.
    wp_enqueue_script( 'WAS-vue-js', 'https://unpkg.com/vue@2.4.4/dist/vue.js', array(), '2.4.4', true );
    wp_enqueue_script( 'WAS-axios-js', 'https://unpkg.com/axios@0.16.2/dist/axios.min.js', array(), '0.16.2', true );
    wp_enqueue_script( 'WAS-qs-js', 'https://unpkg.com/qs@6.5.1/dist/qs.js', array(), '6.5.1', true );

    // this script will display AJAX response using Vue
    wp_enqueue_script( 'WAS-functionality-js', plugin_dir_url( __FILE__ ).'js/custom.js', array( 'WAS-axios-js', 'WAS-vue-js', 'WAS-qs-js' ), '1.0.0', true );

    wp_localize_script(
                'WAS-functionality-js',
                'WAS_ajax_obj',
                array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
            );
}

add_action( 'wp_enqueue_scripts', 'wordpress_axios_scripts' );

/*
 * Vue structure which will be embedded in the footer area
 * @return void
 */
function vue_demo_structure()
{
    ob_start(); ?>
  <ul id="vue-demo-root" class="vue-demo">
      <li v-for="value in nameArray">
        {{ value }}
      </li>
      <button  @click.stop.prevent="getNameAjax" >Get Names</button>
      <!-- stop.prevent  is same as event.preventDefault done inside a jQuery call-->
    </ul>
<?php  echo ob_get_clean();
}

add_action( 'wp_footer', 'vue_demo_structure' );


/**
 * ajax code that will return an array of random names.
 * @return void
 */
function ajaxReturnRandomNames()
{
    $names = array( "Millie Mathews", "Susana Sampley", "Moshe Pablo", "Claire Pakele", "Linwood Mayr", "Sarina Lundin", "Hugh Driggs", "Jade Krom", "Lina Pavia", "Gordon Stutes", "Lucila Erickson", "Deonna Cheatham", "Anh Mullins", "Kathlyn Manfre", "Flor Maguire", "Syreeta Mosqueda", "Fermina Dziedzic", "Jeff Soule", "Felton Gargiulo", "Hilary Varian" );
    shuffle( $names );
    $rand_names = array_slice( $names, 0, rand( 1, 20 ) );
    wp_send_json( $rand_names );
}

add_action( 'wp_ajax_nopriv_was_get_names', 'ajaxReturnRandomNames' );  //handles non logged in user ajax calls
add_action( 'wp_ajax_was_get_names', 'ajaxReturnRandomNames' );
