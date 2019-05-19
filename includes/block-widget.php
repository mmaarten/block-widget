<?php

namespace mm;

class Block_Widget extends \WP_Widget
{
	public function __construct()
	{
		parent::__construct( 'mm_block_widget', __( 'Block', 'block-widget' ), array
		( 
			'description' => esc_html__( 'Displays a reusable block.', 'block-widget' ),
			'classname'   => 'block-widget',
		));
	}

	public function widget( $args, $instance )
	{
		if ( empty( $instance['block'] ) || ! get_post_type( $instance['block'] ) )
		{
			return;
		}

		echo $args['before_widget'];

		echo do_blocks( get_post_field( 'post_content', $instance['block'] ) );

		echo $args['after_widget'];
	}

	public function form( $instance ) 
	{
		$block_id = ! empty( $instance['block'] ) ? absint( $instance['block'] ) : 0;
		
		$widget_title = $block_id ? get_post_field( 'post_title', $block_id ) : '';

		$posts = get_posts( array
		(
			'post_type'   => 'wp_block',
			'post_status' => 'publish',
			'numberposts' => 999,
		));

		// No blocks found.

		if ( empty( $posts ) )
		{
			printf( '<p>%s</p>', __( 'No reusable blocks available.', 'block-widget' ) );

			return;
		}

		// Input field with id is required for WordPress to display the title in the widget header.
		?>
		<input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo esc_attr( $widget_title ); ?>">
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'block' ) ); ?>"><?php esc_attr_e( 'Block:', 'block-widget' ); ?></label> 
			<select id="<?php echo esc_attr( $this->get_field_id( 'block' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'block' ) ); ?>">
				<option value=""><?php esc_html_e( '- Select -', 'block-widget' ); ?></option>
				<?php foreach ( $posts as $post ) : ?>
				<option value="<?php echo esc_attr( $post->ID ); ?>"<?php selected( $post->ID, $block_id ); ?>><?php echo esc_html( $post->post_title ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<?php 
	}

	public function update( $new_instance, $old_instance ) 
	{
		$instance = array();
		$instance['block'] = ! empty( $new_instance['block'] ) ? $new_instance['block'] : 0;
		
		return $instance;
	}
}

register_widget( __NAMESPACE__ . '\Block_Widget' );
