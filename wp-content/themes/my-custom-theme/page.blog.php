<?php
/*
Template Name: Blogs Grid
*/

get_header(); ?>

<section class="banner-section">
    <?php
    $banner_image = get_field('banner_image');
    $banner_title = get_field('banner_title');
    $banner_subtitle = get_field('banner_subtitle');
    $banner_button_url = get_field('banner_button');
    $banner_button_text = get_field('banner_button_text');

    if ($banner_image) :
    ?>
        <div class="banner-image" style="background-image: url('<?php echo esc_url($banner_image['url']); ?>');">
            <div class="banner-overlay"></div>
            <div class="banner-content">
                <h4 class="banner-title"><?php echo esc_html($banner_title); ?></h4>
                <h1 class="banner-subtitle"><?php echo esc_html($banner_subtitle); ?></h1>
                <?php if ($banner_button_url) : ?>
                    <a href="<?php echo esc_url($banner_button_url); ?>" class="banner-button">
                        <?php echo esc_html($banner_button_text ?: 'Click Here'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</section>

<section class="blogs-grid-section">
    <div class="container">
        <h1 class="section-title">Our Blogs</h1>

        <div class="blogs-grid">
            <?php
            $args = array(
                'post_type'      => 'blogs',
                'posts_per_page' => -1,
                'orderby'        => 'date',
                'order'          => 'DESC'
            );

            $blogs_query = new WP_Query($args);

            if ($blogs_query->have_posts()) :
                while ($blogs_query->have_posts()) : $blogs_query->the_post();
            ?>
                    <div class="blog-card">
                        <div class="blog-card-inner">
                            <div class="blog-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="blog-info">
                                <h3 class="blog-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="blog-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No blogs found.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>