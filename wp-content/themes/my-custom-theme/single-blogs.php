<?php
// Ensure WordPress environment is loaded
get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <!-- Banner Section -->
    <section class="project-banner project-detail" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'large'); ?>');">
        <div class="banner-overlay project-detail">
            <div class="container project-detail">
                <h1 class="project-title project-detail"><?php the_title(); ?></h1>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="project-content project-detail">
        <div class="container project-detail">
            
            <!-- Description Section -->
            <h2 class="section-heading project-detail">About Blog</h2>
            <div class="blog-description project-detail">
                <!-- Display ACF 'blog_description' field -->
                <?php 
                $blog_description = get_field('blog_description'); 
                if ($blog_description) {
                    echo wp_kses_post($blog_description); // Output the ACF content safely
                }
                ?>
            </div>

        </div>
    </section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
