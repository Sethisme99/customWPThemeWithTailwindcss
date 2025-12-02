<?php
/**
 * Register Hero Section CPT
 */
function register_hero_section_cpt() {
    $args = array(
        'label' => 'Hero Sections',
        'public' => true,
        'show_in_rest' => true,
        'supports' => array( 'title', 'thumbnail' ),
        'menu_icon' => 'dashicons-image-alt',
        'has_archive' => false,
    );
    register_post_type( 'hero_section', $args );
}
add_action( 'init', 'register_hero_section_cpt' );

/**
 * Add Custom Meta Box for Hero Section
 */
function add_hero_section_meta_box() {
    add_meta_box(
        'hero_section_meta',
        'Hero Section Content',
        'render_hero_section_meta_box',
        'hero_section',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'add_hero_section_meta_box' );

function render_hero_section_meta_box( $post ) {
    wp_nonce_field( 'hero_section_nonce', 'hero_section_nonce' );
    
    $subtitle = get_post_meta( $post->ID, '_hero_subtitle', true );
    $title = get_post_meta( $post->ID, '_hero_title', true );
    $description = get_post_meta( $post->ID, '_hero_description', true );
    $btn1_text = get_post_meta( $post->ID, '_hero_btn1_text', true );
    $btn1_url = get_post_meta( $post->ID, '_hero_btn1_url', true );
    $btn2_text = get_post_meta( $post->ID, '_hero_btn2_text', true );
    $btn2_url = get_post_meta( $post->ID, '_hero_btn2_url', true );
    ?>
    <div style="margin: 15px 0;">
        <label for="hero_subtitle"><strong>Subtitle:</strong></label>
        <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" style="width: 100%; padding: 8px; margin: 5px 0;">
    </div>

    <div style="margin: 15px 0;">
        <label for="hero_title"><strong>Main Title:</strong></label>
        <input type="text" id="hero_title" name="hero_title" value="<?php echo esc_attr( $title ); ?>" style="width: 100%; padding: 8px; margin: 5px 0;">
    </div>

    <div style="margin: 15px 0;">
        <label for="hero_description"><strong>Description:</strong></label>
        <textarea id="hero_description" name="hero_description" rows="4" style="width: 100%; padding: 8px; margin: 5px 0;"><?php echo esc_textarea( $description ); ?></textarea>
    </div>

    <div style="margin: 15px 0;">
        <label for="hero_btn1_text"><strong>Button 1 Text:</strong></label>
        <input type="text" id="hero_btn1_text" name="hero_btn1_text" value="<?php echo esc_attr( $btn1_text ); ?>" style="width: 100%; padding: 8px; margin: 5px 0;">
    </div>

    <div style="margin: 15px 0;">
        <label for="hero_btn1_url"><strong>Button 1 URL:</strong></label>
        <input type="url" id="hero_btn1_url" name="hero_btn1_url" value="<?php echo esc_attr( $btn1_url ); ?>" style="width: 100%; padding: 8px; margin: 5px 0;">
    </div>

    <div style="margin: 15px 0;">
        <label for="hero_btn2_text"><strong>Button 2 Text:</strong></label>
        <input type="text" id="hero_btn2_text" name="hero_btn2_text" value="<?php echo esc_attr( $btn2_text ); ?>" style="width: 100%; padding: 8px; margin: 5px 0;">
    </div>

    <div style="margin: 15px 0;">
        <label for="hero_btn2_url"><strong>Button 2 URL:</strong></label>
        <input type="url" id="hero_btn2_url" name="hero_btn2_url" value="<?php echo esc_attr( $btn2_url ); ?>" style="width: 100%; padding: 8px; margin: 5px 0;">
    </div>
    <?php
}

/**
 * Save Hero Section Meta Data
 */
function save_hero_section_meta( $post_id ) {
    if ( ! isset( $_POST['hero_section_nonce'] ) || ! wp_verify_nonce( $_POST['hero_section_nonce'], 'hero_section_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    update_post_meta( $post_id, '_hero_subtitle', sanitize_text_field( $_POST['hero_subtitle'] ?? '' ) );
    update_post_meta( $post_id, '_hero_title', sanitize_text_field( $_POST['hero_title'] ?? '' ) );
    update_post_meta( $post_id, '_hero_description', sanitize_textarea_field( $_POST['hero_description'] ?? '' ) );
    update_post_meta( $post_id, '_hero_btn1_text', sanitize_text_field( $_POST['hero_btn1_text'] ?? '' ) );
    update_post_meta( $post_id, '_hero_btn1_url', esc_url_raw( $_POST['hero_btn1_url'] ?? '' ) );
    update_post_meta( $post_id, '_hero_btn2_text', sanitize_text_field( $_POST['hero_btn2_text'] ?? '' ) );
    update_post_meta( $post_id, '_hero_btn2_url', esc_url_raw( $_POST['hero_btn2_url'] ?? '' ) );
}
add_action( 'save_post', 'save_hero_section_meta' );