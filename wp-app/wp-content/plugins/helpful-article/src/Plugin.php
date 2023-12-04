<?php

namespace wp360\Helpful_Article;

class Plugin
{
    const TABLE_LOGS_NAME = 'ha_fingerprint';

    private string $plugin_path;
    private string $templates_path;

    private string|array $supported_post_types = 'post';

    public function __construct(string $plugin_path) {
        $this->plugin_path = trailingslashit($plugin_path);
        $this->templates_path = $this->plugin_path . 'templates/';
    }

    public function init_hooks(): void {
        global $wpdb;

        $fingerprint_manager = new Manager_Fingerprint($wpdb, self::TABLE_LOGS_NAME);
        $request_handler = new Request_Handler($fingerprint_manager, 'ha_vote');

        new Meta_Box_Votes($this->supported_post_types, $this->templates_path . 'admin/meta-box/');

        //add ajax actions
        add_action('wp_ajax_ha_vote', [$request_handler, 'vote']);
        add_action('wp_ajax_nopriv_ha_vote', [$request_handler, 'vote']);

        //insert widget after post content
        add_action('the_content', [$this, 'render_widget'], 99);
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    }

    public function activate(): void {
        global $wpdb;

        $table_name = $wpdb->prefix . self::TABLE_LOGS_NAME;

        $sql = "CREATE TABLE $table_name (
            post_id bigint(20) unsigned NOT NULL,
            fingerprint varchar(32) NOT NULL,
            PRIMARY KEY  (post_id, fingerprint)
        );";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public function deactivate(): void {
        global $wpdb;

        $table_name = $wpdb->prefix . self::TABLE_LOGS_NAME;
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    /**
     * Render front widget
     */
    public function render_widget(): void {
        if(!is_singular($this->supported_post_types)) {
            return;
        }

        $manager = new Manager_Vote(get_the_ID());
        $votes = $manager->get_votes()->get_all();

        include_once($this->templates_path . 'widget-voting.php');
    }

    public function register_scripts(): void {
        wp_localize_script('helpful_article', 'haSettings', [
            'endpoint' => admin_url('admin-ajax.php'),
            'action' => 'ha_vote',
            'nonce' => wp_create_nonce('ha_vote')
        ]);
    }
}