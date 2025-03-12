<?php
get_header();
?>
<main>
    <div class="content-area">
        <?php if (have_posts()) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Latest Posts', 'my-custom-theme'); ?></h1>
            </header>

            <div class="post-list">
                <?php
                // Start the Loop
                while (have_posts()) : the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="post-meta">
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                            <span class="post-author"><?php the_author_posts_link(); ?></span>
                        </div>
                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php
                // Pagination
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'my-custom-theme'),
                    'next_text' => __('Next', 'my-custom-theme'),
                ));
                ?>
            </div>
        <?php else : ?>
            <div class="no-posts">
                <h2><?php esc_html_e('No posts found', 'my-custom-theme'); ?></h2>
                <p><?php esc_html_e('It seems we can’t find what you’re looking for. Perhaps searching can help.', 'my-custom-theme'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php get_sidebar(); ?>

<?php
get_footer();
?>
