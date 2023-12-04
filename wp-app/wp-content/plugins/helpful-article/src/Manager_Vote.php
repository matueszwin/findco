<?php

namespace wp360\Helpful_Article;

class Manager_Vote
{
    const TYPE_UP = 'up';
    const TYPE_DOWN = 'down';

    const VOTES_KEY = '_votes';

    private int $post_id;

    public function __construct(int $post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * Update vote by type
     */
    public function update_vote(string $type): array {
        $votes = $this->get_votes();

        if($type === self::TYPE_UP) {
            $votes->increment_up();
        } else {
            $votes->increment_down();
        }

        $this->update_votes($votes);

        return $votes->get_all();
    }

    /**
     * Get votes from post meta
     */
    public function get_votes(): Votes {
        $votes = get_post_meta($this->post_id, self::VOTES_KEY, true);

        if(!$votes) {
            return new Votes(0, 0);
        }

        return new Votes($votes['up'], $votes['down']);
    }

    /**
     * Update votes in post meta
     */
    public function update_votes(Votes $votes): void {
        update_post_meta($this->post_id, self::VOTES_KEY, $votes->prepare_for_post_meta());
    }

}