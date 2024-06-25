<?php
// Si ce fichier est appelé directement, abort.
if (!defined('ABSPATH')) {
    exit;
}

function mon_plugin_register_cpt_produits() {
    $labels = array(
        'name'               => _x('Produits', 'post type general name', 'mon-plugin'),
        'singular_name'      => _x('Produit', 'post type singular name', 'mon-plugin'),
        'menu_name'          => _x('Produits', 'admin menu', 'mon-plugin'),
        'name_admin_bar'     => _x('Produit', 'add new on admin bar', 'mon-plugin'),
        'add_new'            => _x('Ajouter Nouveau', 'produit', 'mon-plugin'),
        'add_new_item'       => __('Ajouter Nouveau Produit', 'mon-plugin'),
        'new_item'           => __('Nouveau Produit', 'mon-plugin'),
        'edit_item'          => __('Éditer Produit', 'mon-plugin'),
        'view_item'          => __('Voir Produit', 'mon-plugin'),
        'all_items'          => __('Tous les Produits', 'mon-plugin'),
        'search_items'       => __('Chercher Produits', 'mon-plugin'),
        'parent_item_colon'  => __('Parent Produits:', 'mon-plugin'),
        'not_found'          => __('Aucun produit trouvé.', 'mon-plugin'),
        'not_found_in_trash' => __('Aucun produit trouvé dans la corbeille.', 'mon-plugin')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'produit'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );

    register_post_type('produit', $args);
}

add_action('init', 'mon_plugin_register_cpt_produits');

