<?php

namespace wp360\Helpful_Article;

class Request_Handler
{
    private Manager_Fingerprint $fingerprint_manager;
    private string $nonce_action;

    public function __construct(Manager_Fingerprint $fingerprint_manager, string $nonce_action) {
        $this->fingerprint_manager = $fingerprint_manager;
        $this->nonce_action = $nonce_action;
    }

    public function vote(): void {
        $nonce = filter_input(INPUT_POST, 'nonce');

//        if(!wp_verify_nonce($nonce, $this->nonce_action)) {
//            wp_send_json_error('Invalid nonce', 403);
//        }

        $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
        $vote_type = filter_input(INPUT_POST, 'type');
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);

        if(!$post_id) {
            wp_send_json_error('Invalid post id', 400);
        }

        if(!in_array($vote_type, [Manager_Vote::TYPE_UP, Manager_Vote::TYPE_DOWN])) {
            wp_send_json_error('Invalid vote type', 400);
        }

        try {
            $result = $this->fingerprint_manager->create($post_id, $ip);

            if(!$result) {
                wp_send_json_error('You already voted', 400);
            }

            $manager_vote = new Manager_Vote($post_id);
            $votes = $manager_vote->update_vote($vote_type);

            wp_send_json_success($votes, 200);
        } catch (\Exception $e) {
            wp_send_json_error($e->getMessage(), 500);
        }
    }

}