<?php
/*
Plugin Name: Mon Plugin
Description: Un plugin pour ajouter un Custom Post Type "Produits" avec un champ image.
Version: 1.0
Author: Votre Nom
*/

// Si ce fichier est appelé directement, abort.
if (!defined('ABSPATH')) {
    exit;
}

// Inclure le fichier CPT
require_once plugin_dir_path(__FILE__) . 'includes/cpt-produits.php';

// Enqueue scripts for the admin area
function mon_plugin_enqueue_admin_scripts($hook_suffix) {
    if ('post.php' === $hook_suffix || 'post-new.php' === $hook_suffix) {
        wp_enqueue_media();
        wp_enqueue_script('assets/admin_js', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'mon_plugin_enqueue_admin_scripts');
