<?php
/**
 * Plugin Name: Unused Media Manager
 * Description: Detects and lists unused media files with an option to delete them.
 * Version: 1.3
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

// Add Admin Menu
function umm_add_admin_menu() {
    add_menu_page('Unused Media', 'Unused Media', 'manage_options', 'unused-media', 'umm_display_unused_media', 'dashicons-trash', 25);
}
add_action('admin_menu', 'umm_add_admin_menu');

// Fetch Media Usage with Accurate Database Checks
function umm_get_media_usage() {
    global $wpdb;
    
    $media_items = $wpdb->get_results("SELECT ID, guid FROM {$wpdb->posts} WHERE post_type = 'attachment'");
    $media_usage = [];
    
    foreach ($media_items as $media) {
        $media_id = $media->ID;
        $media_url = esc_url($media->guid);
        
        // Check Post Content (Gutenberg & Classic Editor)
        $post_references = $wpdb->get_results($wpdb->prepare(
            "SELECT ID, post_title, post_type FROM {$wpdb->posts} WHERE post_content LIKE %s",
            '%' . $wpdb->esc_like($media_url) . '%'
        ));
        
        // Check Featured Image Usage
        $featured_image_references = $wpdb->get_results($wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_thumbnail_id' AND meta_value = %d",
            $media_id
        ));
        
        // Check Custom Fields (ACF & Other Plugins)
        $meta_references = $wpdb->get_results($wpdb->prepare(
            "SELECT post_id, meta_key FROM {$wpdb->postmeta} WHERE meta_value LIKE %s OR meta_value = %d",
            '%' . $wpdb->esc_like($media_url) . '%', $media_id
        ));
        
        $usage_details = [];
        
        if (!empty($post_references)) {
            foreach ($post_references as $post) {
                $usage_details[] = "Post/Page: " . esc_html($post->post_title) . " (Type: " . esc_html($post->post_type) . ")";
            }
        }
        
        if (!empty($featured_image_references)) {
            foreach ($featured_image_references as $post) {
                $usage_details[] = "Featured Image (Post ID: " . esc_html($post->post_id) . ")";
            }
        }
        
        if (!empty($meta_references)) {
            foreach ($meta_references as $meta) {
                $usage_details[] = "Custom Field: " . esc_html($meta->meta_key) . " (Post ID: " . esc_html($meta->post_id) . ")";
            }
        }
        
        $status = empty($usage_details) ? 'Unused' : 'Used';
        
        $media_usage[] = [
            'id' => $media_id,
            'guid' => $media_url,
            'status' => $status,
            'usage_details' => $usage_details
        ];
    }
    return $media_usage;
}

// Display Media Usage in Admin Panel
function umm_display_unused_media() {
    if (!current_user_can('manage_options')) return;
    
    $media_usage = umm_get_media_usage();
    ?>
    <div class="wrap">
        <h1>Media File Usage</h1>
        <table class="widefat">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Usage Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($media_usage as $media): ?>
                    <tr>
                        <td><img src="<?php echo esc_url($media['guid']); ?>" width="50"></td>
                        <td><?php echo esc_html($media['guid']); ?></td>
                        <td><?php echo esc_html($media['status']); ?></td>
                        <td>
                            <?php if (!empty($media['usage_details'])): ?>
                                <ul>
                                    <?php foreach ($media['usage_details'] as $detail): ?>
                                        <li><?php echo esc_html($detail); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <span>Not Used</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($media['status'] === 'Unused'): ?>
                                <button class="delete-media" data-id="<?php echo esc_attr($media['id']); ?>">Delete</button>
                            <?php else: ?>
                                <span>In Use</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        jQuery(document).ready(function($){
            $('.delete-media').click(function(){
                if (!confirm('Are you sure you want to delete this media?')) return;
                let mediaId = $(this).data('id');
                let button = $(this);
                
                $.post(ajaxurl, {
                    action: 'umm_delete_media',
                    media_id: mediaId,
                    security: '<?php echo wp_create_nonce("umm_delete_nonce"); ?>'
                }, function(response) {
                    if (response.success) {
                        button.closest('tr').remove();
                    } else {
                        alert('Error deleting media.');
                    }
                });
            });
        });
    </script>
    <?php
}

// Handle AJAX Media Deletion
function umm_delete_media() {
    check_ajax_referer('umm_delete_nonce', 'security');
    if (!current_user_can('manage_options')) wp_send_json_error('Unauthorized');
    
    $media_id = intval($_POST['media_id']);
    if ($media_id) {
        wp_delete_attachment($media_id, true);
        wp_send_json_success();
    }
    wp_send_json_error('Invalid ID');
}
add_action('wp_ajax_umm_delete_media', 'umm_delete_media');