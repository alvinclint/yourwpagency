<?php
// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

// Localization
load_child_theme_textdomain(  'wfs', apply_filters(  'child_theme_textdomain', get_stylesheet_directory(  ) . '/languages', 'wfs'  )  );

// Custom Functions
require_once(  get_stylesheet_directory(  ) . '/include/theme_functions.php' );

// Widgets
require_once(  get_stylesheet_directory(  ) . '/include/widgets/class-popup-form.php' );


// Supports HTML5
add_theme_support( 'html5' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Web Fix Solutions' );
define( 'CHILD_THEME_URL', 'http://www.webfixsolutions.com/' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'wfs_viewport_meta_tag' );
function wfs_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
}

// Add support for custom background
add_theme_support( 'custom-background' );

// Add mobile menu
add_action( 'genesis_header', 'wfs_mobile_menu', 11 );
function wfs_mobile_menu(){
	$output = '';
	
	$output .=  '<div class="mobile_menu navbar-default" role="navigation"><button type="button" class="navbar-toggle">';
	$output .= '<span class="icon-bar icon-first"></span><span class="icon-bar icon-second"></span><span class="icon-bar icon-last"></span>';
	$output .= '</button></div>';
	
	echo $output;
}

// Reposition Primary Navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 11 );

// Reposition Secondary Navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav', 11 );

// Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array ( 'header', 'site-inner', 'footer-widgets','footer' ) );


/** Unregister Layout */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Remove the secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//Add theme logo support
add_theme_support( 'custom-logo', array(
	'height'      => 112,
	'width'       => 400
) );

// Filter Genesis Site title to enable logo
add_action( 'get_header', 'wfs_custom_logo_option' );
function wfs_custom_logo_option(){
	if( has_custom_logo() ){
		//remove site title and site description
		remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
		remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
		//display new custom logo
		add_action( 'genesis_site_title', 'wfs_custom_logo' );
	}
}

// Custom Logo Function
function wfs_custom_logo(){
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

// Additional Stylesheets
add_action( 'wp_enqueue_scripts', 'wfs_print_styles'  );
function wfs_print_styles( ) {
	
	wp_enqueue_style( 'dashicons'  );
	wp_enqueue_style( 'swiper-css', get_stylesheet_directory_uri( ).'/css/swiper.min.css' );
	wp_register_style( 'mobile', get_stylesheet_directory_uri( ).'/css/mobile.css' );
	wp_enqueue_style( 'mobile'  );
	
}

// Enqueue Google Font
add_action( 'wp_enqueue_scripts', 'wfs_google_font', 5  );
function wfs_google_font( ) {
	$query_args = array(
		'family' => 'Poppins:400,600,700|Lato:300,300i,400,400i,700,700i,900,900i|Quicksand:300,400,500,700'
	);
	wp_enqueue_style( 'wfs_google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
}

// Theme Scripts
add_action( 'wp_enqueue_scripts', 'wfs_theme_js' );
function wfs_theme_js( ) {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script('swiper-js', get_stylesheet_directory_uri() . '/js/swiper.jquery.min.js','','', true );
	wp_enqueue_script('custom_js', get_stylesheet_directory_uri() . '/js/custom.js','','1.0', true );
}

// Register Widget Area
genesis_register_sidebar( array(
	'id'			=> 'pop-up',
	'name'			=> __( 'Popup Form', 'wfs' ),
	'description'	=> __( 'This is the popup form widget area', 'wfs' ),
) );

// Add overlay widget
add_action( 'genesis_before', 'wfs_signup_overlay', 12 );
function wfs_signup_overlay(){

	if(is_active_sidebar('pop-up')){
		echo '<div class="sign_up"><div class="sign_up_overlay"></div><div class="sign_up_wrap"><span class="sign_up_close">x</span>';
			dynamic_sidebar('pop-up');
		echo '</div></div>';
	}
}

// Add before footer section
add_action( 'genesis_before_footer', 'wfs_before_footer', 9 );
function wfs_before_footer(){
	if(is_active_sidebar('bottom-widget')){
		echo '<div class="bottom-widget"><div class="wrap">';
			dynamic_sidebar('bottom-widget');
		echo '</div></div>';
	}
}
// Footer Credits
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'wfs_footer_creds_text' );
function wfs_footer_creds_text(){
	
	echo '<div class="creds col-md-12"><p>Built by a WordPress Consultant for WordPress Consultants.</p></div>';
	
}

// Remove Footer
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
//remove_action( 'genesis_footer', 'genesis_do_footer' );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Enable shortcode in Text Widgets
add_filter( 'widget_text', 'do_shortcode' );

// Add footer widgets
//add_theme_support( 'genesis-footer-widgets', 3 );

// Modify Read More Text

add_filter(  'excerpt_more', 'wfs_read_more_link'  );
add_filter(  'get_the_content_more_link', 'wfs_read_more_link'  );
add_filter( 'the_content_more_link', 'wfs_read_more_link' );
function wfs_read_more_link(  ) {
    return '&hellip; <a class="more-link" href="' . get_permalink(  ) . '"> '.__( 'Read More ','wfs' ).'<i class="fa fa-angle-double-right"></i></a>';
}

// Add image sizes
add_image_size( 'blog', 768, 400, true );
add_image_size( 'blog_shortcode', 362, 257, true );


// Add header Feature before content sidebar wrap
add_action( 'genesis_before_content_sidebar_wrap', 'wfs_page_header_feature' );
function wfs_page_header_feature(){
	global $post;

	if(  get_post_meta( $post->ID, 'content', true )  != '' ){
		echo '<div class="home-widget">';
			echo '<section class="wfs-home-hero">';
				echo '<div class="wfs_hero_wrap">';
					echo '<div class="wfs_hero_content">';
						echo '<div class="wfs_hero_content_wrap">';
							echo '<div class="wfs_hero_label">';
								the_field( 'content' );
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</section>';
		echo '</div>';
	}
}

// Remove main wrapper if the content is empty
add_action( 'get_header', 'wfs_hide_content_when_empty' );
function wfs_hide_content_when_empty(){
	global $post;

	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			if( get_the_content() == '' ){
				add_filter( 'body_class', function( $classes ) {
				    return array_merge( $classes, array( 'wfs-no-content' ) );
				} );
			}

			if( get_post_meta( $post->ID, 'content', true ) == '' ){
				add_filter( 'body_class', function( $classes ) {
				    return array_merge( $classes, array( 'wfs-no-header' ) );
				} );
			}
		endwhile;
	endif;
}

// Set BG image when featured image is set
add_action(  'wp_head', 'wfs_BG_image'  );
function wfs_BG_image(  ) {
	global $post;

	if ( get_the_post_thumbnail_url(  get_the_ID()  ) ){
		$image = get_the_post_thumbnail_url(  get_the_ID()  );

		?>
			<style type="text/css">
				.site-container:before {
				    background: url( '<?php echo $image; ?>' );
				}
				.site-container:after {
				    background-color: rgba(0,0,0,0.5);
				    content: "";
				    position: fixed;
				    z-index: 1;
				    height: 100%;
				    width: 100%;
				    left: 0;
				    top: 0;
				}
			</style>
		<?php
	}else if( get_post_meta( $post->ID, 'bg_color', true ) != '' ){
		?>
			<style type="text/css">
				.site-container:before {
				    background: <?php echo get_post_meta( $post->ID, 'bg_color', true ); ?>;
				}

			</style>
		<?php
	}else if( get_post_meta( $post->ID, 'bg_color_gradient_1', true ) != '' || get_post_meta( $post->ID, 'bg_color_gradient_2', true ) != '' ){
		?>
			<style type="text/css">
				.site-container:before {
				    background-color: <?php echo get_post_meta( $post->ID, 'bg_color_gradient_1', true ); ?>;
				    background: -moz-linear-gradient(90deg, <?php echo get_post_meta( $post->ID, 'bg_color_gradient_1', true ); ?> 0%, <?php echo get_post_meta( $post->ID, 'bg_color_gradient_2', true ); ?> 100%);
				    background: -webkit-linear-gradient(90deg, <?php echo get_post_meta( $post->ID, 'bg_color_gradient_1', true ); ?> 0%,<?php echo get_post_meta( $post->ID, 'bg_color_gradient_2', true ); ?> 100%);
				    background: linear-gradient(90deg, <?php echo get_post_meta( $post->ID, 'bg_color_gradient_1', true ); ?> 0%, <?php echo get_post_meta( $post->ID, 'bg_color_gradient_2', true ); ?> 100%);
				    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=<?php echo get_post_meta( $post->ID, 'bg_color_gradient_1', true ); ?>, endColorstr=<?php echo get_post_meta( $post->ID, 'bg_color_gradient_2', true ); ?>,GradientType=1 );
				}
			</style>
		<?php
	}
}