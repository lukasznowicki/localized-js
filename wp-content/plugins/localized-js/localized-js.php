<?php
/*
Plugin Name: Localized JS
Description: This is just an example on using localized strings in javascript files.
    Version: 0.1.0
     Author: £ukasz Nowicki
 Author URI: http://lukasznowicki.info/
Text Domain: localizedjs
*/
namespace Phylax\WP\Plugin\LocalizedJS;

if ( !is_admin() ) { return; }

class Plugin {

	function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'wp_ajax_drawanswer', [ $this, 'drawanswer' ] );
	}

	function admin_menu() {
		add_media_page(
			__( 'LocalizedJS Example Page', 'localizedjs' ),
			__( 'LocalizedJS', 'localizedjs' ),
			'edit_files',
			'localizedjs',
			[ $this, 'admin_menu_view' ]
		);
	}

	function admin_menu_view() {
?>
	<div class="wrap">
		<h1><?php echo __( 'LocalizedJS', 'localizedjs' ); ?></h1>
		<div id="localizedjs">
			<a href="#" id="localizedjs_click">Draw the answer</a>
			<div id="answer"></div>
		</div>
	</div>
<?php
	}

	function admin_enqueue_scripts( $hook ) {
		if ( 'media_page_localizedjs' !== $hook ) { return; }
		wp_enqueue_script( 'localizedjs', plugins_url( 'localized.js', __FILE__ ), [ 'jquery' ] );
		wp_localize_script( 'localizedjs', 'localizedjs_msg', [
			'error' => __( 'Something went wrong', 'localizedjs' ),
			'answer_one' => __( 'The answer is one. Generated on: ', 'localizedjs' ),
			'answer_two' => __( 'The answer is two. Generated on: ', 'localizedjs' ),
			'wpnonce' => wp_create_nonce( 'draw_the_answer' ),
		] );
	}

	function drawanswer() {
		if ( !current_user_can( 'edit_files' ) ) { wp_die(); }
		check_ajax_referer( 'draw_the_answer' );
		$answer = rand( 1, 2 );
		echo json_encode( [
			'answer' => $answer,
			'dt' => date( 'Y-m-d H:i:s' ),
		] );
		wp_die();
	}

}

$phylax_localizedjs = new Plugin();