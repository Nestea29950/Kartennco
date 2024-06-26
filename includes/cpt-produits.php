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

// Définition et enregistrement du groupe de champs ACF
function mon_plugin_register_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key'                   => 'group_kartennco_produits',
            'title'                 => 'Kartennco - Produits',
            'fields'                => array(
                array(
                    'key'               => 'field_image_produit',
                    'label'             => 'Image',
                    'name'              => 'image',
                    'type'              => 'image',
                    'instructions'      => 'Ajouter une image pour le produit.',
                    'required'          => 1,
                    'return_format'     => 'array',
                    'preview_size'      => 'thumbnail',
                    'library'           => 'all',
                ),
                array(
                    'key'               => 'field_zones_de_securite',
                    'label'             => 'Zones de sécurité',
                    'name'              => 'zones_de_securite',
                    'type'              => 'repeater',
                    'instructions'      => 'Ajouter des zones de sécurité pour le produit.',
                    'sub_fields'        => array(
                        array(
                            'key'       => 'field_zone_x',
                            'label'     => 'X',
                            'name'      => 'x',
                            'type'      => 'number',
                            'required'  => 1,
                        ),
                        array(
                            'key'       => 'field_zone_y',
                            'label'     => 'Y',
                            'name'      => 'y',
                            'type'      => 'number',
                            'required'  => 1,
                        ),
                        array(
                            'key'       => 'field_zone_width',
                            'label'     => 'Largeur',
                            'name'      => 'width',
                            'type'      => 'number',
                            'required'  => 1,
                        ),
                        array(
                            'key'       => 'field_zone_height',
                            'label'     => 'Hauteur',
                            'name'      => 'height',
                            'type'      => 'number',
                            'required'  => 1,
                        ),
                    )
                )
            ),
            'location'              => array(
                array(
                    array(
                        'param'         => 'post_type',
                        'operator'      => '==',
                        'value'         => 'produit',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => 1,
            'description'           => '',
        ));
    }
}

add_action('acf/init', 'mon_plugin_register_acf_fields');
