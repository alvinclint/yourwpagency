<?php
/*
* Post Box Widget
*/
add_action( 'widgets_init', 'wfs_load_home_hero' );
function wfs_load_home_hero() {
	register_widget( 'WFS_Home_Hero' );
}

class WFS_Home_Hero extends WP_Widget {
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct() {

		$this->defaults = array(
			'title'                   => '',
			'image'            => '',
			'content' 			=> ''
		);

		$widget_ops = array(
			'classname'   => 'wfs-home-hero',
			'description' => __( 'WFS home hero widget', 'wfs' ),
		);

		$control_ops = array(
			'id_base' => 'wfs-home-hero',
			'width'   => 505,
			'height'  => 350,
		);

		parent::__construct( 'wfs-home-hero', __( 'WFS - Home Hero', 'wfs' ), $widget_ops, $control_ops );
	}

	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @global WP_Query $wp_query               Query object.
	 * @global array    $_genesis_displayed_ids Array of displayed post IDs.
	 * @global $integer $more
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		global $wp_query, $_genesis_displayed_ids, $post,  $authordata;

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

		echo '<div class="wfs_hero_wrap" style="background-image: url('.$instance['image'].')">';

			echo '<div class="wfs_hero_content"><div class="wfs_hero_content_wrap">';
				//* Set up the author bio
				if ( ! empty( $instance['title'] ) )
					echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

				echo '<div class="wfs_hero_label"><p>'.do_shortcode( $instance['content'] ).'</p></div>';
			echo '</div></div>';
		echo '</div>';
		
		echo $args['after_widget'];

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 0.1.8
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wfs' ); ?>:</label>
			<input class="widefat"  type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php _e( 'Add Image URL', 'wfs' ); ?>:</label>
			<input class="widefat"  type="text" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" size="2" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php _e( 'Add Content', 'wfs' ); ?>:</label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" rows="20" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" ><?php echo esc_attr( $instance['content'] ); ?></textarea>
		</p>		

		<?php

	}
}
