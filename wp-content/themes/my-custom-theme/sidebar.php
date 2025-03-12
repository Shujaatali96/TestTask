<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<aside id="sidebar" class="site-sidebar">
    <?php if (is_active_sidebar('main-sidebar')) : ?>
        <?php dynamic_sidebar('main-sidebar'); ?>
    <?php else : ?>
        <p><?php esc_html_e('Add widgets to the sidebar in the WordPress admin panel.', 'my-custom-theme'); ?></p>
    <?php endif; ?>
</aside>
