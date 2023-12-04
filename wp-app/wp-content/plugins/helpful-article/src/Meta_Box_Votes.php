<?php

namespace wp360\Helpful_Article;

class Meta_Box_Votes {
    private string $template_path;
    private string|array $post_types;

    public function __construct( string|array $post_types, string $template_path = '' ) {
        $this->template_path = $template_path;
        $this->post_types = $post_types;
        add_action( 'add_meta_boxes', [$this, 'add'] );
    }

	public function add() {
		add_meta_box(
			'ha_votes',
			'Votes',
			[ $this, 'render' ],  // Content callback, must be of type callable
            $this->post_types,
		);
	}

	public function render( $post ) {
        $votes = (new Manager_Vote($post->ID))->get_votes()->get_all();
		include_once( $this->template_path . 'votes.php');
	}
}