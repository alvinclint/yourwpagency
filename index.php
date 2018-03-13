<?php

//* Custom page blog template

function gws_blog_quote(){
	if(is_active_sidebar('blog-quote')){
		echo '<div class="blog_quote"><div class="blog-quote">';
			dynamic_sidebar('blog-quote');
		echo '</div></div>';
	}
}


remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'gws_custom_blog_page' );

function gws_custom_blog_page(){
	global $post, $paged;	
			
	$include = genesis_get_option( 'blog_cat' );
	$exclude = genesis_get_option( 'blog_cat_exclude' ) ? explode( ',', str_replace( ' ', '', genesis_get_option( 'blog_cat_exclude' ) ) ) : '';
	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }

		//* Arguments
		$args = 	array(
				'cat'              => $include,
				'category__not_in' => $exclude,
				'posts_per_page'        => genesis_get_option( 'blog_cat_num' ),
				'paged'            => $paged
		);

	
	$query = new WP_Query( $args  );
	
	$i=0;
	$custom_class = '';
	
	if ( have_posts() ) :

		do_action( 'genesis_before_while' );
		while ( have_posts() ) : the_post();

			do_action( 'genesis_before_entry' );

			if( ( $i != 0)  && ( $i % 2 == 1 ) ){
				$custom_class = 'blog_no_right';
			}else{
				$custom_class = '';
			}
			
			printf( '<article class="%s" %s>', join( ' ', get_post_class( $custom_class, $post->ID ) ) ,genesis_attr( 'entry' ) );

				do_action( 'genesis_entry_header' );

				do_action( 'genesis_before_entry_content' );

				printf( '<div %s>', genesis_attr( 'entry-content' ) );
				do_action( 'genesis_entry_content' );
				echo '</div>';

				do_action( 'genesis_after_entry_content' );

				do_action('gws_social');
				do_action( 'genesis_entry_footer' );

			echo '</article>';

			if( $i != 0 && $i == 4 ){
				gws_blog_quote();
			}else if( $i > 4  && $i % 4 == 0){
				gws_blog_quote();
			}

			do_action( 'genesis_after_entry' );
			$i++;

		endwhile; // End of one post.
		do_action( 'genesis_after_endwhile' );

	else : // If no posts exist.
		do_action( 'genesis_loop_else' );
	endif; // End loop.
		
}

genesis();