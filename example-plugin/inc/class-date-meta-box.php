<?php

namespace meta_box_boilerplate;

class Date_Meta_Box extends Meta_Box implements Meta_Box_Interface {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'event_date_meta_box', __( 'Event dates', 'example-plugin' ), 'post', 'side', 'low' );

		// register hook for AJAX autocompletion
		add_action( 'wp_ajax_event_deadline_label', array( $this, 'request_deadline_label' ) );
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param \WP_Post $post The post object.
	 */
	function render( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->nonce_validator->get_action(), $this->nonce_validator->get_name() );

		// adding the JavaScript file for that meta box
		wp_enqueue_script( 'deadline-label-autocomplete', plugins_url( '../js/deadline-label-autocomplete.js', __FILE__ ), 'jquery-ui-autocomplete', false, true );

		$event_date_start          = get_post_meta( $post->ID, '_event_date_start', true );
		$event_date_start_time     = get_post_meta( $post->ID, '_event_date_start_time', true );
		$event_date_end            = get_post_meta( $post->ID, '_event_date_end', true );
		$event_date_end_time       = get_post_meta( $post->ID, '_event_date_end_time', true );
		$event_date_deadline       = get_post_meta( $post->ID, '_event_date_deadline', true );
		$event_date_deadline_time  = get_post_meta( $post->ID, '_event_date_deadline_time', true );
		$event_date_deadline_label = get_post_meta( $post->ID, '_event_date_deadline_label', true );

		// Echo out the fields
		?>
		<p>
			<label for="event_date_start" style="display: inline-block; margin-right: 4px; width: 60%;"><?php _e( 'Start date', 'example-plugin' ) ?></label>
			<label for="event_date_start_time" style="width: 37%;"><?php _e( 'Time', 'example-plugin' ); ?></label>
			<br />
			<input type="date" id="event_date_start" name="event_date_start" value="<?php echo esc_attr( $event_date_start ) ?>" style="width: 60%;" />
			<input type="time" id="event_date_start_time" name="event_date_start_time" value="<?php echo esc_attr( $event_date_start_time ) ?>" style="width: 37%;" />
		</p>
		<p>
			<label for="event_date_end" style="display: inline-block; margin-right: 4px; width: 60%;"><?php _e( 'End date', 'example-plugin' ) ?></label>
			<label for="event_date_end_time"><?php _e( 'Time', 'example-plugin' ); ?></label>
			<br />
			<input type="date" id="event_date_end" name="event_date_end" value="<?php echo esc_attr( $event_date_end ) ?>" style="width: 60%;" />
			<input type="time" id="event_date_end_time" name="event_date_end_time" value="<?php echo esc_attr( $event_date_end_time ) ?>" style="width: 37%;" />
		</p>
		<p>
			<label for="event_date_deadline" style="display: inline-block; margin-right: 4px; width: 60%;"><?php _e( 'Deadline', 'example-plugin' ) ?></label>
			<label for="event_date_deadline_time"><?php _e( 'Time', 'example-plugin' ); ?></label>
			<br />
			<input type="date" id="event_date_deadline" name="event_date_deadline" value="<?php echo esc_attr( $event_date_deadline ) ?>" style="width: 60%;" />
			<input type="time" id="event_date_deadline_time" name="event_date_deadline_time" value="<?php echo esc_attr( $event_date_deadline_time ) ?>" style="width: 37%;" />
		</p>
		<p>
			<label for="event_date_deadline_label"><?php _e( 'Deadline label', 'example-plugin' ) ?></label>
			<input type="text" id="event_date_deadline_label" name="event_date_deadline_label" value="<?php echo esc_attr( $event_date_deadline_label ) ?>" class="widefat" />
		</p>
	<?php
	}

	/**
	 * Save the meta box date when the post is saved.
	 *
	 * @param   int $post_id The ID of the post being saved.
	 *
	 * @return  void
	 */
	public function save( $post_id ) {

		// check if the values should be saved
		if ( ! self::check() ) {
			return;
		}

		// Sanitize the user input.
		$event_date_start          = sanitize_text_field( $_POST[ 'event_date_start' ] );
		$event_date_start_time     = sanitize_text_field( $_POST[ 'event_date_start_time' ] );
		$event_date_end            = sanitize_text_field( $_POST[ 'event_date_end' ] );
		$event_date_end_time       = sanitize_text_field( $_POST[ 'event_date_end_time' ] );
		$event_date_deadline       = sanitize_text_field( $_POST[ 'event_date_deadline' ] );
		$event_date_deadline_time  = sanitize_text_field( $_POST[ 'event_date_deadline_time' ] );
		$event_date_deadline_label = sanitize_text_field( $_POST[ 'event_date_deadline_label' ] );

		// Update the meta field.
		update_post_meta( $post_id, '_event_date_start', $event_date_start );
		update_post_meta( $post_id, '_event_date_start_time', $event_date_start_time );
		update_post_meta( $post_id, '_event_date_end', $event_date_end );
		update_post_meta( $post_id, '_event_date_end_time', $event_date_end_time );
		update_post_meta( $post_id, '_event_date_deadline', $event_date_deadline );
		update_post_meta( $post_id, '_event_date_deadline_time', $event_date_deadline_time );
		update_post_meta( $post_id, '_event_date_deadline_label', $event_date_deadline_label );
	}

	/**
	 * Query all distinct deadline labels from the database and return it as an JSON array for the autocompletion
	 *
	 * @global \wpdb $wpdb The data base object
	 *
	 * @return void
	 */
	public function request_deadline_label() {
		global $wpdb;

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT DISTINCT meta_value AS value,
								meta_value AS label
				FROM            $wpdb->postmeta
				WHERE           meta_key = '_event_date_deadline_label'
				AND             meta_value LIKE %s
				",
				'%' . $wpdb->esc_like( $_REQUEST[ 'term' ] ) . '%'
			)
		);

		echo json_encode( $results );

		die();
	}
}