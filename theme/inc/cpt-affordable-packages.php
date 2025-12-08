<?php
/**
 * Custom Post Type: Affordable Packages
 */

add_action( 'init', 'raseth_register_affordable_packages_cpt' );
function raseth_register_affordable_packages_cpt() {
    $args = array(
        'label' => 'Affordable Packages',
        'public' => true,
        'show_in_menu' => true,
        'supports' => array( 'title', 'thumbnail' ),
        'has_archive' => false,
        'rewrite' => array( 'slug' => 'affordable-packages' ),
        'menu_icon' => 'dashicons-video-alt3',
    );
    register_post_type( 'affordable_package', $args );
}

add_action( 'add_meta_boxes', 'raseth_add_affordable_package_metabox' );
function raseth_add_affordable_package_metabox() {
    add_meta_box(
        'affordable_package_meta',
        'Package Details',
        'raseth_affordable_package_metabox_callback',
        'affordable_package',
        'normal',
        'high'
    );
}

function raseth_affordable_package_metabox_callback( $post ) {
    wp_nonce_field( 'raseth_package_nonce', 'raseth_package_nonce_field' );
    
    $section_title = get_post_meta( $post->ID, '_package_section_title', true );
    $description = get_post_meta( $post->ID, '_package_description', true );
    $video_id = get_post_meta( $post->ID, '_package_video_id', true );
    $btn_text = get_post_meta( $post->ID, '_package_btn_text', true );
    $btn_url = get_post_meta( $post->ID, '_package_btn_url', true );
    $accent_color = get_post_meta( $post->ID, '_package_accent_color', true );
    
    // Get video URL from attachment ID
    $video_url = $video_id ? wp_get_attachment_url( $video_id ) : '';
    ?>
    <div style="display: grid; gap: 15px;">
        <div style="padding: 15px; background: #f5f5f5; border-radius: 4px;">
            <p style="margin: 0 0 10px 0; font-weight: bold;">📸 Video Poster Image (Featured Image)</p>
            <p style="margin: 0; color: #666; font-size: 13px;">Use the featured image box on the right to upload the video poster/thumbnail.</p>
        </div>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 10px 0;">
        <div style="padding: 10px 0;">
            <h4 style="margin: 0 0 15px 0; font-size: 14px; font-weight: bold; color: #333;">📝 Content Section</h4>
            
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Section Title:</label>
                <input type="text" name="_package_section_title" value="<?php echo esc_attr( $section_title ); ?>" placeholder="e.g., Affordable Packages" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Description:</label>
                <textarea name="_package_description" style="width:100%; height:100px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" placeholder="Brief description...">
<?php echo esc_textarea( $description ); ?></textarea>
            </div>

            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Accent Line Color (Hex):</label>
                <input type="text" name="_package_accent_color" value="<?php echo esc_attr( $accent_color ); ?>" placeholder="#EF4444" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Default: #EF4444 (red)</p>
            </div>

            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Button Text:</label>
                <input type="text" name="_package_btn_text" value="<?php echo esc_attr( $btn_text ); ?>" placeholder="e.g., View Profiles" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-top: 10px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Button URL:</label>
                <input type="text" name="_package_btn_url" value="<?php echo esc_attr( $btn_url ); ?>" placeholder="https://example.com" style="width:100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 10px 0;">
        <div style="padding: 10px 0;">
            <h4 style="margin: 0 0 15px 0; font-size: 14px; font-weight: bold; color: #333;">🎬 Video Upload</h4>
            
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Upload Video File (MP4, WebM, etc):</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input 
                        type="hidden" 
                        id="package_video_id" 
                        name="_package_video_id" 
                        value="<?php echo esc_attr( $video_id ); ?>"
                    >
                    <input 
                        type="text" 
                        id="package_video_url" 
                        value="<?php echo esc_attr( $video_url ); ?>" 
                        placeholder="Video URL will appear here" 
                        readonly 
                        style="flex:1; padding: 8px; border: 1px solid #ddd; border-radius: 4px; background: #f9f9f9;"
                    >
                    <button 
                        type="button" 
                        id="upload_package_video_btn" 
                        class="button button-primary"
                        style="padding: 8px 16px;">
                        Upload Video
                    </button>
                </div>
                <?php if ( $video_url ) : ?>
                    <div style="margin-top: 10px; padding: 10px; background: #f0f6fc; border-left: 4px solid #0073aa; border-radius: 4px;">
                        <p style="margin: 0 0 8px 0; font-size: 13px; font-weight: bold; color: #0073aa;">✓ Video Uploaded</p>
                        <video width="200" style="border-radius: 4px;" controls>
                            <source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
                        </video>
                    </div>
                <?php endif; ?>
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Upload directly from your computer</p>
            </div>
        </div>
    </div>

    <script>
    jQuery(function($) {
        var frame;
        var videoField = $('#package_video_id');
        var videoUrl = $('#package_video_url');

        $('#upload_package_video_btn').on('click', function(e) {
            e.preventDefault();

            // If the media frame already exists, reopen it.
            if (frame) {
                frame.open();
                return;
            }

            // Create the media frame.
            frame = wp.media.frames.downloadable_file = wp.media({
                title: 'Select or Upload Video',
                button: {
                    text: 'Use this video'
                },
                multiple: false,
                library: {
                    type: ['video'] // Only show videos
                }
            });

            // When a file is selected, run a callback.
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                videoField.val(attachment.id);
                videoUrl.val(attachment.url);
            });

            // Finally, open the modal on click
            frame.open();
        });
    });
    </script>
    <?php
}

add_action( 'save_post_affordable_package', 'raseth_save_affordable_package_meta' );
function raseth_save_affordable_package_meta( $post_id ) {
    if ( ! isset( $_POST['raseth_package_nonce_field'] ) || ! wp_verify_nonce( $_POST['raseth_package_nonce_field'], 'raseth_package_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'affordable_package' ) {
        return;
    }

    $fields = array(
        '_package_section_title',
        '_package_description',
        '_package_video_id',
        '_package_btn_text',
        '_package_btn_url',
        '_package_accent_color'
    );
    
    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }
}