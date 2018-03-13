<?php
/*
* Post Box Widget
*/
add_action( 'widgets_init', 'wfs_popup_form' );
function wfs_popup_form() {
	register_widget( 'WFS_Popup_Form' );
}

class WFS_Popup_Form extends WP_Widget {
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
			'desc'            => '',
			'form' 			=> '',
			'footnote' 			=> ''
		);

		$widget_ops = array(
			'classname'   => 'wfs-popup-form',
			'description' => __( 'WFS popup form widget', 'wfs' ),
		);

		$control_ops = array(
			'id_base' => 'wfs-popup-form',
			'width'   => 505,
			'height'  => 350,
		);

		parent::__construct( 'wfs-popup-form', __( 'WFS - Popup Form', 'wfs' ), $widget_ops, $control_ops );
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

		echo '<div class="wfs_popup_form">';
		
			echo '<div class="progress"><div class="progress-bar"><p class="progress-title"><span class="progress-percent">50</span>% complete</p></div></div>';

			echo '<span style="font-size: 30px; display: block; margin: 30px 0;"><strong>'.$instance['title'].'</strong></span>';

			echo '<p><strong>'.$instance['desc'].'</strong></p>';

			echo do_shortcode( $instance['form'] );

			echo '<p><a style="text-decoration: underline; display: block; margin-top: 30px;">'. $instance['footnote']  .'</a></p>';

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>"><?php _e( 'Short Description', 'wfs' ); ?>:</label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>" rows="10" name="<?php echo esc_attr( $this->get_field_name( 'desc' ) ); ?>" ><?php echo esc_attr( $instance['desc'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'form' ) ); ?>"><?php _e( 'Form Shortcode', 'wfs' ); ?>:</label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form' ) ); ?>" rows="5" name="<?php echo esc_attr( $this->get_field_name( 'form' ) ); ?>" ><?php echo esc_attr( $instance['form'] ); ?></textarea>
		</p>	

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'footnote' ) ); ?>"><?php _e( 'Footnote', 'wfs' ); ?>:</label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'footnote' ) ); ?>" rows="5" name="<?php echo esc_attr( $this->get_field_name( 'footnote' ) ); ?>" ><?php echo esc_attr( $instance['footnote'] ); ?></textarea>
		</p>		

		<?php

	}
}
