<?php

/**
 * Plugin Name: Helpful Article Rating
 * Requires at least: 6.4
 * Requires PHP:      8.0
 * Version: 1.0.0
 */

require_once __DIR__ . '/vendor/autoload.php';

//init plugin
$helpful_article_plugin = new wp360\Helpful_Article\Plugin(__DIR__);

//register activation and deactivation hooks
register_activation_hook(__FILE__, [$helpful_article_plugin, 'activate']);

$helpful_article_plugin->init_hooks();
