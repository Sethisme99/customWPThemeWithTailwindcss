<?php
/**
 * Feature Cards Custom Post Type
 */

function raseth_register_feature_cards_cpt() {
    $labels = array(
        'name'                  => 'Feature Cards',
        'singular_name'         => 'Feature Card',
        'menu_name'             => 'Feature Cards',
        'name_admin_bar'        => 'Feature Card',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Feature Card',
        'new_item'              => 'New Feature Card',
        'edit_item'             => 'Edit Feature Card',
        'view_item'             => 'View Feature Card',
        'all_items'             => 'All Feature Cards',
        'search_items'          => 'Search Feature Cards',
        'not_found'             => 'No feature cards found.',
        'not_found_in_trash'    => 'No feature cards found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'description'        => 'Feature Cards for homepage',
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'feature-card' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-layout',
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
    );

    register_post_type( 'feature_card', $args );
}
add_action( 'init', 'raseth_register_feature_cards_cpt' );

/**
 * Add meta boxes for feature cards
 */
function raseth_add_feature_card_metabox() {
    add_meta_box(
        'feature_card_details',
        'Feature Card Details',
        'raseth_feature_card_metabox_callback',
        'feature_card',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'raseth_add_feature_card_metabox' );

function raseth_feature_card_metabox_callback( $post ) {
    $title = get_post_meta( $post->ID, '_feature_title', true );
    $description = get_post_meta( $post->ID, '_feature_description', true );
    ?>
    <div style="padding: 10px;">
        <p>
            <label for="feature_title"><strong>Title:</strong></label>
            <input type="text" id="feature_title" name="feature_title" value="<?php echo esc_attr( $title ); ?>" style="width: 100%; padding: 8px; margin-top: 5px;">
        </p>
        <p>
            <label for="feature_description"><strong>Description:</strong></label>
            <textarea id="feature_description" name="feature_description" rows="4" style="width: 100%; padding: 8px; margin-top: 5px;"><?php echo esc_textarea( $description ); ?></textarea>
        </p>
    </div>
    <?php
    wp_nonce_field( 'raseth_feature_card_nonce', 'raseth_feature_card_nonce_field' );
}

function raseth_save_feature_card_meta( $post_id ) {
    if ( ! isset( $_POST['raseth_feature_card_nonce_field'] ) || ! wp_verify_nonce( $_POST['raseth_feature_card_nonce_field'], 'raseth_feature_card_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $_POST['feature_title'] ) ) {
        update_post_meta( $post_id, '_feature_title', sanitize_text_field( $_POST['feature_title'] ) );
    }
    if ( isset( $_POST['feature_description'] ) ) {
        update_post_meta( $post_id, '_feature_description', sanitize_textarea_field( $_POST['feature_description'] ) );
    }
}
add_action( 'save_post_feature_card', 'raseth_save_feature_card_meta' );