<?php
/**
 * Register Testimonial CPT
 */
function register_testimonial_cpt() {
    $args = array(
        'label' => 'Testimonials',
        'public' => true,
        'show_in_rest' => true,
        'supports' => array( 'title', 'thumbnail' ),
        'menu_icon' => 'dashicons-format-quote',
        'has_archive' => false,
    );
    register_post_type( 'testimonial', $args );
}
add_action( 'init', 'register_testimonial_cpt' );

/**
 * Add Custom Meta Box for Testimonials
 */
function add_testimonial_meta_box() {
    add_meta_box(
        'testimonial_meta',
        'Testimonial Content',
        'render_testimonial_meta_box',
        'testimonial',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'add_testimonial_meta_box' );

function render_testimonial_meta_box( $post ) {
    wp_nonce_field( 'testimonial_nonce', 'testimonial_nonce' );
    
    $rating = get_post_meta( $post->ID, '_testimonial_rating', true ) ?: 4;
    $content = get_post_meta( $post->ID, '_testimonial_content', true );
    $author_name = get_post_meta( $post->ID, '_testimonial_author_name', true );
    $author_role = get_post_meta( $post->ID, '_testimonial_author_role', true );
    ?>
    
    <div style="margin: 15px 0;">
        <label for="testimonial_rating"><strong>Rating (1-5):</strong></label>
        <select id="testimonial_rating" name="testimonial_rating" style="width: 100%; padding: 8px; margin: 5px 0;">
            <option value="1" <?php selected( $rating, 1 ); ?>>1 Star</option>
            <option value="2" <?php selected( $rating, 2 ); ?>>2 Stars</option>
            <option value="3" <?php selected( $rating, 3 ); ?>>3 Stars</option>
            <option value="4" <?php selected( $rating, 4 ); ?>>4 Stars</option>
            <option value="5" <?php selected( $rating, 5 ); ?>>5 Stars</option>
        </select>
    </div>

    <div style="margin: 15px 0;">
        <label for="testimonial_content"><strong>Testimonial Text:</strong></label>
        <textarea id="testimonial_content" name="testimonial_content" rows="4" style="width: 100%; padding: 8px; margin: 5px 0;"><?php echo esc_textarea( $content ); ?></textarea>
    </div>

    <div style="margin: 15px 0;">
        <label for="testimonial_author_name"><strong>Author Name:</strong></label>
        <input type="text" id="testimonial_author_name" name="testimonial_author_name" value="<?php echo esc_attr( $author_name ); ?>" style="width: 100%; padding: 8px; margin: 5px 0;">
    </div>

    <div style="margin: 15px 0;">
        <label for="testimonial_author_role"><strong>Author Role/Title:</strong></label>
        <input type="text" id="testimonial_author_role" name="testimonial_author_role" value="<?php echo esc_attr( $author_role ); ?>" style="width: 100%; padding: 8px; margin: 5px 0;">
    </div>

    <p style="color: #666; font-style: italic; margin-top: 10px;">
        💡 Tip: Set the featured image as the author's profile picture
    </p>
    <?php
}

/**
 * Save Testimonial Meta Data
 */
function save_testimonial_meta( $post_id ) {
    if ( ! isset( $_POST['testimonial_nonce'] ) || ! wp_verify_nonce( $_POST['testimonial_nonce'], 'testimonial_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    update_post_meta( $post_id, '_testimonial_rating', sanitize_text_field( $_POST['testimonial_rating'] ?? 4 ) );
    update_post_meta( $post_id, '_testimonial_content', sanitize_textarea_field( $_POST['testimonial_content'] ?? '' ) );
    update_post_meta( $post_id, '_testimonial_author_name', sanitize_text_field( $_POST['testimonial_author_name'] ?? '' ) );
    update_post_meta( $post_id, '_testimonial_author_role', sanitize_text_field( $_POST['testimonial_author_role'] ?? '' ) );
}
add_action( 'save_post', 'save_testimonial_meta' );