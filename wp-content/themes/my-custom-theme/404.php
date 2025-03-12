<?php
get_header();
?>

<main id="main" class="site-main">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e('Oops! That page can’t be found.', 'my-custom-theme'); ?></h1>
        </header>

        <div class="page-content">
            <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'my-custom-theme'); ?></p>

            <?php get_search_form(); ?>

            <h2><?php esc_html_e('Recent Posts', 'my-custom-theme'); ?></h2>
            <ul>
                <?php
                // Display recent posts
                $recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 5,
                    'post_status' => 'publish',
                ));
                foreach ($recent_posts as $post) {
                    echo '<li><a href="' . esc_url(get_permalink($post['ID'])) . '">' . esc_html($post['post_title']) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </section>
</main>

<?php
get_footer();
