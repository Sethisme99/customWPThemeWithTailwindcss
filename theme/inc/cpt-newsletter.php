<?php
/**
 * Register Newsletter Subscriber Custom Post Type
 * Also creates custom table for email storage
 */

function register_newsletter_subscriber_cpt() {
    // Register CPT
    $args = array(
        'label' => 'Newsletter Subscribers',
        'public' => false,
        'show_in_rest' => false,
        'supports' => array(),
        'menu_icon' => 'dashicons-email',
        'has_archive' => false,
        'show_in_menu' => true,
    );
    register_post_type( 'newsletter_sub', $args );
}
add_action( 'init', 'register_newsletter_subscriber_cpt' );

/**
 * Create custom table on plugin/theme activation
 */
function create_newsletter_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        email varchar(100) NOT NULL UNIQUE,
        status varchar(20) NOT NULL DEFAULT 'pending',
        subscribed_at datetime DEFAULT CURRENT_TIMESTAMP,
        confirmed_at datetime NULL,
        unsubscribed_at datetime NULL,
        confirmation_token varchar(64) NULL,
        notes longtext NULL,
        PRIMARY KEY (id),
        KEY email (email),
        KEY status (status)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
add_action( 'wp_loaded', 'create_newsletter_table' );

/**
 * Add Custom Admin Menu for Newsletter Management
 */
function add_newsletter_admin_menu() {
    add_menu_page(
        'Newsletter Subscribers',
        'Newsletter',
        'manage_options',
        'newsletter_subscribers',
        'render_newsletter_admin_page',
        'dashicons-email',
        25
    );
}
add_action( 'admin_menu', 'add_newsletter_admin_menu' );

/**
 * Render Newsletter Admin Page
 */
function render_newsletter_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    // Handle deletion
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['id'] ) ) {
        check_admin_referer( 'delete_subscriber' );
        $wpdb->delete( $table_name, array( 'id' => intval( $_GET['id'] ) ) );
        echo '<div class="notice notice-success"><p>Subscriber deleted.</p></div>';
    }

    // Handle status change
    if ( isset( $_POST['action'] ) && $_POST['action'] === 'change_status' ) {
        check_admin_referer( 'newsletter_nonce' );
        $id = intval( $_POST['subscriber_id'] );
        $status = sanitize_text_field( $_POST['status'] );
        
        $update_data = array( 'status' => $status );
        if ( $status === 'confirmed' ) {
            $update_data['confirmed_at'] = current_time( 'mysql' );
        } elseif ( $status === 'unsubscribed' ) {
            $update_data['unsubscribed_at'] = current_time( 'mysql' );
        }
        
        $wpdb->update( $table_name, $update_data, array( 'id' => $id ) );
        echo '<div class="notice notice-success"><p>Status updated.</p></div>';
    }

    // Get subscribers
    $subscribers = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY subscribed_at DESC" );
    
    // Count by status
    $pending = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'pending'" );
    $confirmed = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'confirmed'" );
    $unsubscribed = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'unsubscribed'" );
    ?>

    <div class="wrap">
        <h1>Newsletter Subscribers</h1>

        <!-- Stats -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 20px 0;">
            <div style="background: #fff; padding: 20px; border-radius: 8px; border-left: 4px solid #0073aa;">
                <strong>Total Confirmed</strong><br>
                <span style="font-size: 24px; color: #0073aa;"><?php echo $confirmed; ?></span>
            </div>
            <div style="background: #fff; padding: 20px; border-radius: 8px; border-left: 4px solid #f39c12;">
                <strong>Pending Confirmation</strong><br>
                <span style="font-size: 24px; color: #f39c12;"><?php echo $pending; ?></span>
            </div>
            <div style="background: #fff; padding: 20px; border-radius: 8px; border-left: 4px solid #dc3545;">
                <strong>Unsubscribed</strong><br>
                <span style="font-size: 24px; color: #dc3545;"><?php echo $unsubscribed; ?></span>
            </div>
        </div>

        <!-- Export Button -->
        <p>
            <a href="<?php echo wp_nonce_url( add_query_arg( 'action', 'export_csv', admin_url( 'admin.php?page=newsletter_subscribers' ) ), 'export_csv' ); ?>" class="button button-primary">
                📥 Export as CSV
            </a>
        </p>

        <!-- Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 35%;">Email</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 20%;">Subscribed</th>
                    <th style="width: 20%;">Confirmed</th>
                    <th style="width: 10%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $subscribers as $sub ) : ?>
                    <tr>
                        <td>
                            <strong><?php echo esc_html( $sub->email ); ?></strong>
                        </td>
                        <td>
                            <form method="post" style="display: inline-block;">
                                <?php wp_nonce_field( 'newsletter_nonce' ); ?>
                                <input type="hidden" name="action" value="change_status">
                                <input type="hidden" name="subscriber_id" value="<?php echo $sub->id; ?>">
                                <select name="status" onchange="this.form.submit();" style="padding: 5px;">
                                    <option value="pending" <?php selected( $sub->status, 'pending' ); ?>>Pending</option>
                                    <option value="confirmed" <?php selected( $sub->status, 'confirmed' ); ?>>Confirmed</option>
                                    <option value="unsubscribed" <?php selected( $sub->status, 'unsubscribed' ); ?>>Unsubscribed</option>
                                </select>
                            </form>
                        </td>
                        <td><?php echo wp_date( 'M d, Y H:i', strtotime( $sub->subscribed_at ) ); ?></td>
                        <td><?php echo $sub->confirmed_at ? wp_date( 'M d, Y H:i', strtotime( $sub->confirmed_at ) ) : '—'; ?></td>
                        <td>
                            <a href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'delete', 'id' => $sub->id ), admin_url( 'admin.php?page=newsletter_subscribers' ) ), 'delete_subscriber' ); ?>" class="submitdelete" onclick="return confirm('Delete this subscriber?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ( empty( $subscribers ) ) : ?>
            <p style="text-align: center; padding: 20px; color: #999;">No subscribers yet.</p>
        <?php endif; ?>
    </div>

    <?php
}

/**
 * Handle CSV Export
 */
function handle_newsletter_csv_export() {
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'export_csv' && current_user_can( 'manage_options' ) ) {
        check_admin_referer( 'export_csv' );

        global $wpdb;
        $table_name = $wpdb->prefix . 'newsletter_subscribers';
        $subscribers = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY subscribed_at DESC", ARRAY_A );

        // CSV headers
        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename="newsletter-subscribers-' . date( 'Y-m-d' ) . '.csv"' );

        $output = fopen( 'php://output', 'w' );
        fputcsv( $output, array( 'Email', 'Status', 'Subscribed Date', 'Confirmed Date', 'Unsubscribed Date' ) );

        foreach ( $subscribers as $sub ) {
            fputcsv( $output, array(
                $sub['email'],
                $sub['status'],
                $sub['subscribed_at'],
                $sub['confirmed_at'],
                $sub['unsubscribed_at']
            ) );
        }

        fclose( $output );
        exit;
    }
}
add_action( 'admin_init', 'handle_newsletter_csv_export' );

/**
 * Save Newsletter Subscription
 */
function save_newsletter_subscription( $email ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $email = sanitize_email( $email );

    // Check if already exists
    $existing = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE email = %s", $email ) );

    if ( $existing ) {
        if ( $existing->status === 'unsubscribed' ) {
            // Re-subscribe
            $wpdb->update( $table_name, 
                array( 'status' => 'pending', 'unsubscribed_at' => null ),
                array( 'id' => $existing->id )
            );
            return array( 'success' => true, 'message' => 'Welcome back! Check your email to confirm.' );
        } else {
            return array( 'success' => false, 'message' => 'Email already subscribed.' );
        }
    }

    // Create confirmation token
    $token = wp_generate_password( 32, false );

    // Insert new subscriber
    $result = $wpdb->insert( $table_name, array(
        'email' => $email,
        'status' => 'pending',
        'confirmation_token' => $token,
    ) );

    if ( $result ) {
        // Send confirmation email
        send_newsletter_confirmation_email( $email, $token );
        return array( 'success' => true, 'message' => 'Subscription received! Check your email to confirm.' );
    } else {
        return array( 'success' => false, 'message' => 'Error saving subscription. Please try again.' );
    }
}

/**
 * Send Confirmation Email
 */
function send_newsletter_confirmation_email( $email, $token ) {
    $confirm_url = home_url( '/?newsletter_action=confirm&token=' . $token );
    
    $subject = 'Confirm Your Newsletter Subscription';
    $message = "
        <h2>Confirm Your Subscription</h2>
        <p>Thank you for subscribing! Click the link below to confirm your email:</p>
        <p><a href='" . esc_url( $confirm_url ) . "'>Confirm Subscription</a></p>
        <p>Or copy this link: " . esc_url( $confirm_url ) . "</p>
    ";

    wp_mail( $email, $subject, $message, array( 'Content-Type: text/html; charset=UTF-8' ) );
}

/**
 * Handle Newsletter Actions (confirm, unsubscribe)
 */
function handle_newsletter_actions() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    if ( isset( $_GET['newsletter_action'] ) && isset( $_GET['token'] ) ) {
        $action = sanitize_text_field( $_GET['newsletter_action'] );
        $token = sanitize_text_field( $_GET['token'] );

        $subscriber = $wpdb->get_row( $wpdb->prepare( 
            "SELECT * FROM $table_name WHERE confirmation_token = %s", 
            $token 
        ) );

        if ( ! $subscriber ) {
            wp_die( 'Invalid token.' );
        }

        if ( $action === 'confirm' ) {
            $wpdb->update( $table_name, 
                array( 'status' => 'confirmed', 'confirmed_at' => current_time( 'mysql' ) ),
                array( 'id' => $subscriber->id )
            );
            wp_die( '<h2>✅ Email Confirmed!</h2><p>You are now subscribed to our newsletter.</p>' );
        } elseif ( $action === 'unsubscribe' ) {
            $wpdb->update( $table_name, 
                array( 'status' => 'unsubscribed', 'unsubscribed_at' => current_time( 'mysql' ) ),
                array( 'id' => $subscriber->id )
            );
            wp_die( '<h2>❌ Unsubscribed</h2><p>You have been unsubscribed from our newsletter.</p>' );
        }
    }
}
add_action( 'wp_loaded', 'handle_newsletter_actions' );


/**
 * AJAX handler for newsletter subscription
 */
function handle_newsletter_ajax() {
    if ( isset( $_POST['email'] ) ) {
        $result = save_newsletter_subscription( $_POST['email'] );
        wp_send_json( $result );
    }
    wp_die();
}
add_action( 'wp_ajax_newsletter_subscribe', 'handle_newsletter_ajax' );
add_action( 'wp_ajax_nopriv_newsletter_subscribe', 'handle_newsletter_ajax' );