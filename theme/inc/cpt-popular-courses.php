<?php
/**
 * Register Popular Courses Custom Post Type
 * 
 * @package raseth
 */

/**
 * Register Popular Course CPT with enhanced features
 */
function raseth_register_popular_course_cpt() {
    $labels = array(
        'name'                  => _x( 'Popular Courses', 'Post Type General Name', 'raseth' ),
        'singular_name'         => _x( 'Popular Course', 'Post Type Singular Name', 'raseth' ),
        'menu_name'             => __( 'Popular Courses', 'raseth' ),
        'name_admin_bar'        => __( 'Popular Course', 'raseth' ),
        'archives'              => __( 'Course Archives', 'raseth' ),
        'attributes'            => __( 'Course Attributes', 'raseth' ),
        'parent_item_colon'     => __( 'Parent Course:', 'raseth' ),
        'all_items'             => __( 'All Courses', 'raseth' ),
        'add_new_item'          => __( 'Add New Course', 'raseth' ),
        'add_new'               => __( 'Add New', 'raseth' ),
        'new_item'              => __( 'New Course', 'raseth' ),
        'edit_item'             => __( 'Edit Course', 'raseth' ),
        'update_item'           => __( 'Update Course', 'raseth' ),
        'view_item'             => __( 'View Course', 'raseth' ),
        'view_items'            => __( 'View Courses', 'raseth' ),
        'search_items'          => __( 'Search Course', 'raseth' ),
        'not_found'             => __( 'Not found', 'raseth' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'raseth' ),
        'featured_image'        => __( 'Course Image', 'raseth' ),
        'set_featured_image'    => __( 'Set course image', 'raseth' ),
        'remove_featured_image' => __( 'Remove course image', 'raseth' ),
        'use_featured_image'    => __( 'Use as course image', 'raseth' ),
    );

    $args = array(
        'label'              => __( 'Popular Courses', 'raseth' ),
        'description'        => __( 'Popular courses for the homepage', 'raseth' ),
        'labels'             => $labels,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'taxonomies'         => array( 'category' ),
        'hierarchical'       => false,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-book-alt',
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,
        'show_in_rest'       => true,
        'rest_base'          => 'popular-courses',
        'has_archive'        => true,
        'exclude_from_search'=> false,
        'publicly_queryable' => true,
        'capability_type'    => 'post',
        'rewrite'            => array(
            'slug'       => 'popular-course',
            'with_front' => true,
        ),
    );

    register_post_type( 'popular_course', $args );
}
add_action( 'init', 'raseth_register_popular_course_cpt', 10 );

/**
 * Register custom meta fields for Popular Courses
 */
function raseth_register_course_meta_fields() {
    $meta_fields = array(
        '_course_category' => array(
            'label'       => __( 'Course Category', 'raseth' ),
            'description' => __( 'e.g., "For Better Future", "Welcome"', 'raseth' ),
        ),
        '_course_rating' => array(
            'label'       => __( 'Course Rating', 'raseth' ),
            'description' => __( 'e.g., "4.9"', 'raseth' ),
        ),
        '_course_description' => array(
            'label'       => __( 'Short Description', 'raseth' ),
            'description' => __( 'Brief course description', 'raseth' ),
        ),
        '_course_sales' => array(
            'label'       => __( 'Number of Sales', 'raseth' ),
            'description' => __( 'e.g., "15"', 'raseth' ),
        ),
        '_course_original_price' => array(
            'label'       => __( 'Original Price', 'raseth' ),
            'description' => __( 'Price before discount', 'raseth' ),
        ),
        '_course_sale_price' => array(
            'label'       => __( 'Sale Price', 'raseth' ),
            'description' => __( 'Discounted price', 'raseth' ),
        ),
        '_course_button_url' => array(
            'label'       => __( 'Learn More Button URL', 'raseth' ),
            'description' => __( 'URL for the Learn More button', 'raseth' ),
        ),
    );

    foreach ( $meta_fields as $meta_key => $meta_config ) {
        register_post_meta( 'popular_course', $meta_key, array(
            'show_in_rest'      => true,
            'single'            => true,
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function() {
                return current_user_can( 'edit_posts' );
            },
        ) );
    }
}
add_action( 'init', 'raseth_register_course_meta_fields', 11 );

/**
 * Add meta boxes to the course editor
 */
function raseth_add_course_meta_boxes() {
    add_meta_box(
        'popular_course_details',
        __( 'Course Details', 'raseth' ),
        'raseth_course_meta_box_callback',
        'popular_course',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'raseth_add_course_meta_boxes' );

/**
 * Meta box callback
 */
function raseth_course_meta_box_callback( $post ) {
    $meta_fields = array(
        '_course_category',
        '_course_rating',
        '_course_description',
        '_course_sales',
        '_course_original_price',
        '_course_sale_price',
        '_course_button_url',
    );

    wp_nonce_field( 'raseth_course_nonce', 'raseth_course_nonce_field' );
    ?>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <?php foreach ( $meta_fields as $meta_key ) : ?>
            <?php 
            $value = get_post_meta( $post->ID, $meta_key, true );
            $label = '';
            
            switch ( $meta_key ) {
                case '_course_category':
                    $label = __( 'Category', 'raseth' );
                    break;
                case '_course_rating':
                    $label = __( 'Rating', 'raseth' );
                    break;
                case '_course_description':
                    $label = __( 'Short Description', 'raseth' );
                    break;
                case '_course_sales':
                    $label = __( 'Sales Count', 'raseth' );
                    break;
                case '_course_original_price':
                    $label = __( 'Original Price', 'raseth' );
                    break;
                case '_course_sale_price':
                    $label = __( 'Sale Price', 'raseth' );
                    break;
                case '_course_button_url':
                    $label = __( 'Learn More URL', 'raseth' );
                    break;
            }
            ?>
            <div>
                <label for="<?php echo esc_attr( $meta_key ); ?>" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <?php echo esc_html( $label ); ?>
                </label>
                <?php if ( $meta_key === '_course_description' ) : ?>
                    <textarea 
                        id="<?php echo esc_attr( $meta_key ); ?>" 
                        name="<?php echo esc_attr( $meta_key ); ?>" 
                        rows="3"
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                    ><?php echo esc_textarea( $value ); ?></textarea>
                <?php else : ?>
                    <input 
                        type="<?php echo $meta_key === '_course_button_url' ? 'url' : 'text'; ?>" 
                        id="<?php echo esc_attr( $meta_key ); ?>" 
                        name="<?php echo esc_attr( $meta_key ); ?>" 
                        value="<?php echo esc_attr( $value ); ?>"
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                    />
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Save meta box data
 */
function raseth_save_course_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['raseth_course_nonce_field'] ) || 
         ! wp_verify_nonce( $_POST['raseth_course_nonce_field'], 'raseth_course_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $meta_fields = array(
        '_course_category',
        '_course_rating',
        '_course_description',
        '_course_sales',
        '_course_original_price',
        '_course_sale_price',
        '_course_button_url',
    );

    foreach ( $meta_fields as $meta_key ) {
        if ( isset( $_POST[ $meta_key ] ) ) {
            if ( $meta_key === '_course_button_url' ) {
                $value = esc_url_raw( $_POST[ $meta_key ] );
            } else {
                $value = sanitize_text_field( $_POST[ $meta_key ] );
            }
            update_post_meta( $post_id, $meta_key, $value );
        }
    }
}
add_action( 'save_post', 'raseth_save_course_meta_box_data' );

/**
 * Add custom columns to the admin list view
 */
function raseth_add_course_admin_columns( $columns ) {
    $columns['course_category'] = __( 'Category', 'raseth' );
    $columns['course_rating'] = __( 'Rating', 'raseth' );
    $columns['course_sales'] = __( 'Sales', 'raseth' );
    $columns['course_price'] = __( 'Price', 'raseth' );
    $columns['course_button_url'] = __( 'Button URL', 'raseth' );
    
    return $columns;
}
add_filter( 'manage_popular_course_posts_columns', 'raseth_add_course_admin_columns' );

/**
 * Populate custom columns with data
 */
function raseth_populate_course_admin_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'course_category':
            $category = get_post_meta( $post_id, '_course_category', true );
            echo esc_html( $category ?: '—' );
            break;
            
        case 'course_rating':
            $rating = get_post_meta( $post_id, '_course_rating', true );
            echo esc_html( $rating ?: '—' );
            break;
            
        case 'course_sales':
            $sales = get_post_meta( $post_id, '_course_sales', true );
            echo esc_html( $sales ?: '—' );
            break;
            
        case 'course_price':
            $original = get_post_meta( $post_id, '_course_original_price', true );
            $sale = get_post_meta( $post_id, '_course_sale_price', true );
            echo esc_html( '$' . ( $original ?: '—' ) . ' → $' . ( $sale ?: '—' ) );
            break;
            
        case 'course_button_url':
            $url = get_post_meta( $post_id, '_course_button_url', true );
            if ( $url ) {
                echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . esc_html( substr( $url, 0, 30 ) ) . '...</a>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action( 'manage_popular_course_posts_custom_column', 'raseth_populate_course_admin_columns', 10, 2 );