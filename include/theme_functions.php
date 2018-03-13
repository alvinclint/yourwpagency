<?php 
/** 
 * Themes' Helper Functions
 */

// Override default post image display
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );
add_action( 'genesis_entry_content', 'gws_genesis_do_post_image', 8 );
add_action( 'genesis_post_content', 'gws_genesis_do_post_image' );
function gws_genesis_do_post_image() {

	if ( genesis_get_option( 'content_archive_thumbnail' ) && !is_page() ) {

		$img = genesis_get_image( array(
			'format'  => 'html',
			'size'    => genesis_get_option( 'image_size' ),
			'context' => 'archive',
			'attr'    => genesis_parse_attr( 'entry-image', array ( 'alt' => get_the_title() ) ),
		) );

		if ( ! empty( $img ) ) {

			genesis_markup( array(
 				'open'    => '<a %s>',
 				'close'   => '</a>',
 				'content' => wp_make_content_images_responsive( $img ),
 				'context' => 'entry-image-link'
 			));

 		}

	}

}

// Quote shortcode
if (!function_exists('gws_blog_quote_shortcode')) {
	function gws_blog_quote_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'image' => '',
			'author' => ''
		), $atts, 'gws_quote' ));

	   return '<div class="gws_blog_quote" style="background-image: url('.$image.')"><div class="gws_blog_quote_content"><blockquote>'.do_shortcode($content).'</blockquote><span class="gws_quote_author">'.$author.'</span></div></div>';
	}
	add_shortcode('gws_quote', 'gws_blog_quote_shortcode');
}

// Button shortcode
if (!function_exists('gws_button_shortcode')) {
	function gws_button_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => '',
			'link' => '',
			'target' => '',
			'inline' => ''
		), $atts, 'gws_button' ));

		$inline = ( $inline == 'true' ) ? 'inline': '';

	   return '<a class="gws_button '.$color.' '.$inline.'" href="'.$link.'" target="'.$target.'">'.do_shortcode($content).'</a>';
	}
	add_shortcode('gws_button', 'gws_button_shortcode');
}

// Member Slider shortcode
if (!function_exists('gws_member_slider')) {
	function gws_member_slider( $atts, $content = null ) {
		extract( shortcode_atts( array(
		), $atts, 'member_slider' ));

		$output = '';

		$instance_id = uniqid();

		$data_attr_line = 'class="gws-member-swiper swiper-container"';
		$data_attr_line .= ' data-uniq-id="swiper-carousel-' . $instance_id . '"';
		$data_attr_line .= ' data-slides-per-view="4"';
		$data_attr_line .= ' data-slides-per-group="1"';
		$data_attr_line .= ' data-slides-per-column="1"';
		$data_attr_line .= ' data-space-between-slides="0"';
		$data_attr_line .= ' data-duration-speed="2500"';
		$data_attr_line .= ' data-swiper-loop="true"';
		$data_attr_line .= ' data-free-mode="false"';
		$data_attr_line .= ' data-grab-cursor="true"';
		$data_attr_line .= ' data-mouse-wheel="false"';
		$data_attr_line .= ' data-autoplay="0"';		

		$output .= '<div class="gws_member_slider_wrap">';
		$output .= '<div class="swiper-carousel-container">';
			$output .= '<div id="swiper-carousel-' . $instance_id . '" ' . $data_attr_line . '>';
				$output .= '<div class="swiper-wrapper">';
					$output .= do_shortcode( $content );
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

	   return $output;
	}
	add_shortcode('member_slider', 'gws_member_slider');
}

if (!function_exists('gws_member_sider_item')) {
	function gws_member_sider_item( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'image1' => '',
			'link1' => '',
			'link2' => '',
			'image2' => ''
		), $atts, 'member_item' ));

		$output = '';

		$output .= '<div class="member_item swiper-slide">';
			$output .= '<img src="'.$image1.'" /><img src="'.$image2.'" />';
		$output .= '</div>';

	   return $output;
	}
	add_shortcode('member_item', 'gws_member_sider_item');
}


// Companies  Slider shortcode
if (!function_exists('gws_companies_slider')) {
	function gws_companies_slider( $atts, $content = null ) {
		extract( shortcode_atts( array(
		), $atts, 'company_slider' ));

		$output = '';

		$instance_id = uniqid();

		$data_attr_line = 'class="gws-companies-swiper swiper-container"';
		$data_attr_line .= ' data-uniq-id="swiper-carousel-' . $instance_id . '"';
		$data_attr_line .= ' data-slides-per-view="3"';
		$data_attr_line .= ' data-slides-per-group="1"';
		$data_attr_line .= ' data-slides-per-column="1"';
		$data_attr_line .= ' data-space-between-slides="40"';
		$data_attr_line .= ' data-duration-speed="2000"';
		$data_attr_line .= ' data-swiper-loop="true"';
		$data_attr_line .= ' data-free-mode="false"';
		$data_attr_line .= ' data-grab-cursor="true"';
		$data_attr_line .= ' data-mouse-wheel="false"';
		$data_attr_line .= ' data-autoplay="0"';		

		$output .= '<div class="gws_companies_slider_wrap">';
		$output .= '<div class="swiper-carousel-container">';
			$output .= '<div id="swiper-carousel-' . $instance_id . '" ' . $data_attr_line . '>';
				$output .= '<div class="swiper-wrapper">';
					$output .= do_shortcode( $content );
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

	   return $output;
	}
	add_shortcode('company_slider', 'gws_companies_slider');
}

if (!function_exists('gws_company_sider_item')) {
	function gws_company_sider_item( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'image' => '',
		), $atts, 'company_item' ));

		$output = '';

		$output .= '<div class="company_item swiper-slide">';
			$output .= '<img src="'.$image.'" />';
		$output .= '</div>';

	   return $output;
	}
	add_shortcode('company_item', 'gws_company_sider_item');
}


/**
** Slider shortcode
*/
if (!function_exists('gws_partner_slider')) {
	function gws_partner_slider( $atts, $content = null ) {
		extract( shortcode_atts( array(
		), $atts, 'partner_slider' ));

		$output = '';

		$instance_id = uniqid();

		$data_attr_line = 'class="gws-partner-swiper swiper-container"';
		$data_attr_line .= ' data-uniq-id="swiper-carousel-' . $instance_id . '"';
		$data_attr_line .= ' data-slides-per-view="5"';
		$data_attr_line .= ' data-slides-per-group="1"';
		$data_attr_line .= ' data-slides-per-column="1"';
		$data_attr_line .= ' data-space-between-slides="20"';
		$data_attr_line .= ' data-duration-speed="2000"';
		$data_attr_line .= ' data-swiper-loop="true"';
		$data_attr_line .= ' data-free-mode="false"';
		$data_attr_line .= ' data-grab-cursor="true"';
		$data_attr_line .= ' data-mouse-wheel="false"';
		$data_attr_line .= ' data-autoplay="0"';		

		$output .= '<div class="gws_partners_slider_wrap">';
		$output .= '<div class="swiper-carousel-container">';
			$output .= '<div id="swiper-carousel-' . $instance_id . '" ' . $data_attr_line . '>';
				$output .= '<div class="swiper-wrapper">';
					$output .= do_shortcode( $content );
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

	   return $output;
	}
	add_shortcode('partner_slider', 'gws_partner_slider');
}

if (!function_exists('gws_partner_sider_item')) {
	function gws_partner_sider_item( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'image' => '',
		), $atts, 'partner_item' ));

		$output = '';

		$output .= '<div class="partner_item swiper-slide">';
			$output .= '<img src="'.$image.'" />';
		$output .= '</div>';

	   return $output;
	}
	add_shortcode('partner_item', 'gws_partner_sider_item');
}


/**
* Blog Shortcode
*/
if (!function_exists('gws_blog_shortcode')) {
	function gws_blog_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'category' => '',
			'exclude_ids' => '',
			'items' => ''
		), $atts, 'blog' ));

		return '<div class="blog_shortcode"><div class="blog_wrap">'.gws_blog( $category, $exclude_ids, $items ).'</div></div>';
	}
	add_shortcode('blog', 'gws_blog_shortcode');
}

function gws_blog( $category, $exclude_ids, $items ){
		global $post;
		$output='';
		
		// get blog settings
		$include = $category;
		$exclude = explode( ',', str_replace( ' ', '', $exclude_ids ) );


		// inherit Genesis arguments to render posts
		$query_args = 
			array(
				'post_type'		   => 'post',
				'cat'              => $include,
				'category__not_in' => $exclude,
				'showposts'        => $items
			);
		
		query_posts( $query_args );
		
		$i=0;
		$custom_class = '';
		if ( have_posts() ) :

		while ( have_posts() ) : the_post();

			$image = get_the_post_thumbnail( $post->ID  , 'blog_shortcode' );

			$output .= '<article class="'.join( ' ', get_post_class() ).'" itemscope="" itemtype="http://schema.org/CreativeWork">';

			$output .= '<a class="entry-image-link" href="'.get_permalink().'" aria-hidden="true">'.$image.'</a>';

			$output .= '<header class="entry-header">';
				$output .= '<p class="entry-meta">'.do_shortcode( '[post_categories before=""]' ).'</p>';
				$output .= '<h2 class="entry-title" itemprop="headline"><a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a></h2>';
				//$output .= '<p class="entry-meta">'.__( 'posted by ', 'plugged' ) . do_shortcode( '[post_author_posts_link]' ). __( ' on ', 'plugged' ). do_shortcode('[post_date]').'</p>';
			$output .= '</header>';
			$output .= '<div class="entry-content" itemprop="text">'.get_the_content_limit( 200 ).'</div>';

			$output .= '</article>';

		endwhile; // End of one post.
		endif;
		
		wp_reset_query();
		
		return $output;
}