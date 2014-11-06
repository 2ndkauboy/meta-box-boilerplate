<?php

namespace meta_box_boilerplate;

class Meta_Box {

	/**
	 * The meta box name (e.g. used for the nonce)
	 */
	protected $key;

	/**
	 * The meta box label
	 */
	private $label;

	/**
	 * The meta box post type
	 */
	private $post_type;

	/**
	 * The meta box default position
	 */
	private $position;

	/**
	 * The meta box priority
	 */
	private $priority;

	/**
	 * Object of the Nonce_Validator
	 */
	protected $nonce_validator;

	/**
	 * Object of the Request_Validator
	 */
	protected $request_validator;

	/**
	 * Constructor
	 *
	 * @param string $key       The key for the meta box
	 * @param string $label     The label for the meta box in the edit screen
	 * @param string $post_type The post type the meta box should be added to
	 * @param string $position  The default position of the meta box
	 * @param string $priority  The priority of the meta box
	 */
	public function __construct( $key, $label, $post_type, $position, $priority = 'default' ) {

		$this->key       = $key;
		$this->label     = $label;
		$this->post_type = $post_type;
		$this->position  = $position;
		$this->priority  = $priority;

		$this->nonce_validator   = new Nonce_Validator( $this->key . '_name', $this->key . '_action' );
		$this->request_validator = new Request_Validator();

		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
	}

	/**
	 * Register this meta box
	 *
	 * @wp-hook add_meta_boxes
	 */
	public function register() {
		add_meta_box( $this->key, $this->label, array( $this, 'render' ), $this->post_type, $this->position, $this->priority );
	}

	public function check() {
		return $this->request_validator->is_valid() && $this->nonce_validator->is_valid();
	}
}