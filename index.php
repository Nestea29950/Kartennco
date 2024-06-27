<?php

/*
Plugin Name: Mon Plugin
Description: Un plugin pour ajouter un Custom Post Type "Produits" avec un champ image.
Version: 1.0
Author: Gaonarc'h William Colin Loic Erwan Siaunneau Le Moine Corentin
*/

// Si ce fichier est appelé directement, abort.
if (!defined('ABSPATH')) {
    exit;
}

// Inclure le fichier CPT
require_once plugin_dir_path(__FILE__) . 'includes/cpt-produits.php';

// Enqueue scripts for the admin area
function mon_plugin_admin_scripts() {
    // Enqueue your custom JS file
    wp_enqueue_script(
        'mon-plugin-admin-script', // Handle
        plugin_dir_url(__FILE__) . 'assets/js/admin.js', // Path to JS file
        array('jquery'), // Dependencies (optional)
        null, // Version (optional)
        true // Load in footer (optional)
    );

    // Localize the script with new data
    wp_localize_script('mon-plugin-admin-script', 'my_plugin_data', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my_plugin_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'mon_plugin_admin_scripts');

function mon_plugin_admin_styles($hook_suffix) {
    // Vérifier si la page courante est celle de votre plugin
    $plugin_page = 'kartennco'; // Slug de la page de votre plugin

    if ($hook_suffix === 'toplevel_page_' . $plugin_page) {
        // Enqueue your custom CSS file
        wp_enqueue_style(
            'mon-plugin-admin-style', // Handle
            plugin_dir_url(__FILE__) . 'assets/css/output.css', // Path to CSS file
            array(), // Dependencies (optional)
            null // Version (optional)
        );
    }
}
add_action('admin_enqueue_scripts', 'mon_plugin_admin_styles');


function kartennco_menu() {
    add_menu_page(
        'Kartennco',         // Titre de la page
        'kartennco',                // Titre du menu
        'manage_options',            // Capacité
        'kartennco',                 // Slug du menu
        'kartennco_page',            // Fonction callback
        'dashicons-admin-home',      // Icône du menu
        6                            // Position du menu
    );
}
add_action('admin_menu', 'kartennco_menu');

// Fonction callback pour afficher la page du plugin
function kartennco_page() {
    include plugin_dir_path(__FILE__) . 'views/home.php';
}



// Action AJAX pour récupérer les zones de sécurité
add_action('wp_ajax_get_product_zones', 'get_product_zones');
function get_product_zones() {
    check_ajax_referer('my_plugin_nonce', '_ajax_nonce');
    $post_id = intval($_GET['post_id']);
    $zones = get_field('zones_de_securite', $post_id);

    if ($zones) {
        wp_send_json_success(['zones' => $zones]);
    } else {
        wp_send_json_error('Aucune zone trouvée.');
    }
}

// Action AJAX pour sauvegarder les zones de sécurité
add_action('wp_ajax_save_product_zones', 'save_product_zones');
function save_product_zones() {
    check_ajax_referer('my_plugin_nonce', '_ajax_nonce');
    $post_id = intval($_POST['post_id']);
    $zones = $_POST['zones'];

    if (!current_user_can('edit_post', $post_id)) {
        wp_send_json_error('Permission refusée');
    }

    update_field('zones_de_securite', $zones, $post_id);
    wp_send_json_success();
}

//Todo faire la dépendences du plugin acf if(acf ) instancier le plugin 





//Todo faire la dépendences du plugin acf if(acf ) instancier le plugin 