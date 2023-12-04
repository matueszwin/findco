<?php

namespace wp360\Helpful_Article;

class Votes
{
    private int $up;
    private int $down;
    private int $total;
    private int $up_percent;
    private int $down_percent;

    public function __construct(int $up, int $down) {
        $this->up = $up;
        $this->down = $down;
        $this->calc();
    }

    /**
     * Calculate total, up_percent, down_percent
     */
    private function calc():void {
        $this->total = $this->up + $this->down;
        $this->up_percent = $this->total === 0 ? 0 : ($this->up / $this->total) * 100;
        $this->down_percent = $this->total === 0 ? 0 : ($this->down / $this->total) * 100;
    }

    /**
     * Increment up votes
     */
    public function increment_up(): void {
        $this->up++;
        $this->calc();
    }

    /**
     * Increment down votes
     */
    public function increment_down(): void {
        $this->down++;
        $this->calc();
    }

    /**
     * Prepare votes for post meta
     */
    public function prepare_for_post_meta(): array {
        return [
            'up' => $this->up,
            'down' => $this->down,
        ];
    }

    /**
     * Get all calculates data for votes
     */
    public function get_all(): array {
        return [
            'up' => $this->up,
            'down' => $this->down,
            'total' => $this->total,
            'up_percent' => $this->up_percent,
            'down_percent' => $this->down_percent,
        ];
    }
}