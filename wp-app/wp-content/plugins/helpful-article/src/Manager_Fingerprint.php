<?php

namespace wp360\Helpful_Article;

class Manager_Fingerprint
{
    private \WPDB $wpdb;

    private string $table_name;

    public function __construct(\WPDB $wpdb, string $table_name)
    {
        $this->wpdb = $wpdb;
        $this->table_name = $table_name;
    }

    public function create(int $post_id, string $fingerprint): bool
    {
        $this->wpdb->hide_errors();

        $table_name = $this->wpdb->prefix . $this->table_name;

        $result = $this->wpdb->insert(
            $table_name,
            [
                'post_id' => $post_id,
                'fingerprint' => $fingerprint
            ],
            [
                '%d',
                '%s',
            ]
        );

        return $result;
    }

}