<?php
/*
Template Name: Projects Grid
*/

get_header(); ?>
<section class="banner-section">
    <?php
    // Get custom fields (assuming you are using ACF)
    $banner_image = get_field('banner_image');
    $banner_title = get_field('banner_title');
    $banner_subtitle = get_field('banner_subtitle');
    $banner_button_url = get_field('banner_button'); // Get the banner button URL
    $banner_button_text = get_field('banner_button_text'); // Get the banner button text

    // Display banner only if there's an image set
    if ($banner_image) :
    ?>
        <div class="banner-image" style="background-image: url('<?php echo esc_url($banner_image['url']); ?>');">
            <!-- Background Overlay -->
            <div class="banner-overlay"></div>

            <div class="banner-content">
                <h4 class="banner-title"><?php echo esc_html($banner_title); ?></h4>
                <h1 class="banner-subtitle"><?php echo esc_html($banner_subtitle); ?></h1>

                <!-- Check if banner_button URL is set, if so, display the button -->
                <?php if ($banner_button_url) : ?>
                    <a href="<?php echo esc_url($banner_button_url); ?>" class="banner-button">
                        <?php echo esc_html($banner_button_text ? $banner_button_text : 'Click Here'); ?> <!-- Default text if no ACF field is set -->
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<section class="projects-grid-section">
    <div class="container">
        <h1 class="section-title">Our Projects</h1>

        <div class="projects-grid">
            <?php
            // WP Query to fetch Projects
            $args = array(
                'post_type'      => 'projects', // Custom Post Type
                'posts_per_page' => -1,        // Display all projects
                'orderby'        => 'date',   // Order by date
                'order'          => 'DESC',   // Newest first
            );
            $projects_query = new WP_Query($args);

            if ($projects_query->have_posts()) :
                while ($projects_query->have_posts()) : $projects_query->the_post(); 
                 // Get the starting and ending dates
            $starting_date = get_field('project_starting_date'); // ACF field for starting date
            $ending_date = get_field('project_ending_date'); // ACF field for ending date
            ?>
                    <div class="project-card">
                        <div class="project-card-inner">
                            <div class="project-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="project-info">
                                <h3 class="project-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="project-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                                 <!-- Display starting and ending dates inline below the excerpt -->
                        <?php if ($starting_date && $ending_date): ?>
                            <div class="project-dates">
                                <span class="start-date">Start: <?php echo date('F j, Y', strtotime($starting_date)); ?></span>
                                <span class="end-date">End: <?php echo date('F j, Y', strtotime($ending_date)); ?></span>
                            </div>
                        <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No projects found.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
