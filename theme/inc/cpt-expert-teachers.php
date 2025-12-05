<?php
/**
 * Custom Post Type: Expert Teachers
 */

add_action( 'init', 'raseth_register_expert_teachers_cpt' );
function raseth_register_expert_teachers_cpt() {
    $args = array(
        'label' => 'Expert Teachers',
        'public' => true,
        'show_in_menu' => true,
        'supports' => array( 'title', 'thumbnail' ),
        'has_archive' => false,
        'rewrite' => array( 'slug' => 'expert-teachers' ),
        'menu_icon' => 'dashicons-groups',
    );
    register_post_type( 'expert_teacher', $args );
}

add_action( 'add_meta_boxes', 'raseth_add_expert_teacher_metabox' );
function raseth_add_expert_teacher_metabox() {
    add_meta_box(
        'expert_teacher_meta',
        'Teacher Details',
        'raseth_expert_teacher_metabox_callback',
        'expert_teacher',
        'normal',
        'high'
    );
}


function raseth_expert_teacher_metabox_callback( $post ) {
    wp_nonce_field( 'raseth_teacher_nonce', 'raseth_teacher_nonce_field' );
    
    $cert_image = get_post_meta( $post->ID, '_teacher_cert_image', true );
    $card_label = get_post_meta( $post->ID, '_teacher_card_label', true );
    $card_title = get_post_meta( $post->ID, '_teacher_card_title', true );
    $card_description = get_post_meta( $post->ID, '_teacher_card_description', true );
    $satisfaction = get_post_meta( $post->ID, '_teacher_satisfaction', true );
    $section_title = get_post_meta( $post->ID, '_teacher_section_title', true );
    $achievement1_name = get_post_meta( $post->ID, '_teacher_achievement1_name', true );
    $achievement1_score = get_post_meta( $post->ID, '_teacher_achievement1_score', true );
    $achievement2_name = get_post_meta( $post->ID, '_teacher_achievement2_name', true );
    $achievement2_score = get_post_meta( $post->ID, '_teacher_achievement2_score', true );
    $description = get_post_meta( $post->ID, '_teacher_description', true );
    $btn_text = get_post_meta( $post->ID, '_teacher_btn_text', true );
    $btn_url = get_post_meta( $post->ID, '_teacher_btn_url', true );
    $btn2_text = get_post_meta( $post->ID, '_teacher_btn2_text', true );
    $btn2_url = get_post_meta( $post->ID, '_teacher_btn2_url', true );
    ?>
    <div style="display: grid; gap: 15px;">
        <div style="padding: 15px; background: #f5f5f5; border-radius: 4px;">
            <p style="margin: 0 0 10px 0; font-weight: bold;">📸 Main Teacher Image (Featured Image)</p>
            <p style="margin: 0; color: #666; font-size: 13px;">Use the featured image box on the right to upload the main teacher image.</p>
        </div>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 10px 0;">
        <div style="padding: 10px 0;">
            <h4 style="margin: 0 0 15px 0; font-size: 14px; font-weight: bold; color: #333;">🎨 Top Left Card Content</h4>
            
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Card Label (e.g., "Certified Expert"):</label>
                <input type="text" name="_teacher_card_label" value="<?php echo esc_attr( $card_label ); ?>" placeholder="e.g., Certified Expert" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Card Title:</label>
                <input type="text" name="_teacher_card_title" value="<?php echo esc_attr( $card_title ); ?>" placeholder="e.g., Award Winner" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Card Description:</label>
                <textarea name="_teacher_card_description" style="width:100%; height:80px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" placeholder="Brief description for the card">
<?php echo esc_textarea( $card_description ); ?></textarea>
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 10px 0;">
        <div style="padding: 10px 0;">
            <h4 style="margin: 0 0 15px 0; font-size: 14px; font-weight: bold; color: #333;">📋 Main Content Section</h4>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Left Section Title (e.g., "Meet Our Expert Teachers"):</label>
                <input type="text" name="_teacher_section_title" value="<?php echo esc_attr( $section_title ); ?>" placeholder="Meet Our Expert Teachers" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Certification Image URL:</label>
                <input type="text" name="_teacher_cert_image" value="<?php echo esc_attr( $cert_image ); ?>" placeholder="https://example.com/image.jpg" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Paste the URL of the certification/badge image</p>
            </div>
            
            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Student Satisfaction (%):</label>
                <input type="number" name="_teacher_satisfaction" value="<?php echo esc_attr( $satisfaction ); ?>" max="100" min="0" placeholder="95" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Achievement 1 Name:</label>
                    <input type="text" name="_teacher_achievement1_name" value="<?php echo esc_attr( $achievement1_name ); ?>" placeholder="e.g., Andrea R." style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Achievement 1 Score:</label>
                    <input type="text" name="_teacher_achievement1_score" value="<?php echo esc_attr( $achievement1_score ); ?>" placeholder="e.g., 6/10" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Achievement 2 Name:</label>
                    <input type="text" name="_teacher_achievement2_name" value="<?php echo esc_attr( $achievement2_name ); ?>" placeholder="e.g., Naomi O." style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Achievement 2 Score:</label>
                    <input type="text" name="_teacher_achievement2_score" value="<?php echo esc_attr( $achievement2_score ); ?>" placeholder="e.g., 9/10" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>
            
            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Description:</label>
                <textarea name="_teacher_description" style="width:100%; height:100px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" placeholder="Learn from industry leaders...">
                    <?php echo esc_textarea( $description ); ?></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Button Text:</label>
                    <input type="text" name="_teacher_btn_text" value="<?php echo esc_attr( $btn_text ); ?>" placeholder="e.g., Learn More" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Button URL:</label>
                    <input type="text" name="_teacher_btn_url" value="<?php echo esc_attr( $btn_url ); ?>" placeholder="https://example.com" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Button2 Text:</label>
                    <input type="text" name="_teacher_btn2_text" value="<?php echo esc_attr( $btn2_text ); ?>" placeholder="e.g., View Profiles" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Button2 URL:</label>
                    <input type="text" name="_teacher_btn2_url" value="<?php echo esc_attr( $btn2_url ); ?>" placeholder="https://example.com" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>
        </div>
    </div>
    <?php
}

add_action( 'save_post_expert_teacher', 'raseth_save_expert_teacher_meta' );
function raseth_save_expert_teacher_meta( $post_id ) {
    if ( ! isset( $_POST['raseth_teacher_nonce_field'] ) || ! wp_verify_nonce( $_POST['raseth_teacher_nonce_field'], 'raseth_teacher_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'expert_teacher' ) {
        return;
    }

    $fields = array(
        '_teacher_card_label',
        '_teacher_card_title',
        '_teacher_card_description',
        '_teacher_cert_image',
        '_teacher_satisfaction',
        '_teacher_section_title',
        '_teacher_achievement1_name',
        '_teacher_achievement1_score',
        '_teacher_achievement2_name',
        '_teacher_achievement2_score',
        '_teacher_description',
        '_teacher_btn_text',
        '_teacher_btn_url',
        '_teacher_btn2_text',
        '_teacher_btn2_url'
    );
    
    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }
}