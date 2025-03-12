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
            <h2 class="section-heading project-detail">About Project</h2>
            <div class="project-description project-detail">
                <!-- Display ACF 'projects_description' field -->
                <?php 
                // Fetch the custom ACF field for project description
                $projects_description = get_field('projects_description'); 
                if ($projects_description) {
                    echo $projects_description; // Output the ACF content with proper formatting
                }
                ?>
            </div>

            <!-- Dates Section -->
            <div class="project-dates project-detail">
                <p><strong>Starting Date:</strong>
                <?php 
                $starting_date = get_field('project_starting_date');
                if ($starting_date) {
                    echo esc_html(date('F j, Y', strtotime($starting_date))); 
                }
                ?></p>

                <p><strong>Ending Date:</strong>
                <?php 
                $ending_date = get_field('project_ending_date');
                if ($ending_date) {
                    echo esc_html(date('F j, Y', strtotime($ending_date))); 
                }
                ?></p>
            </div>

        </div>
    </section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
