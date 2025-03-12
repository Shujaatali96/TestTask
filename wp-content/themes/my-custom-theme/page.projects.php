<?php
/*
Template Name: Projects Grid
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

<section class="projects-grid-section">
    <div class="container">
        <h1 class="section-title">Our Projects</h1>

        <!-- Date Filter Form -->
        <form method="GET" class="project-filter-form">
            <label for="start_date">Start Date:</label>
            <input type="text" name="start_date" id="start_date" value="<?php echo isset($_GET['start_date']) ? esc_attr($_GET['start_date']) : ''; ?>" placeholder="DD/MM/YYYY">

            <label for="end_date">End Date:</label>
            <input type="text" name="end_date" id="end_date" value="<?php echo isset($_GET['end_date']) ? esc_attr($_GET['end_date']) : ''; ?>" placeholder="DD/MM/YYYY">

            <button class="filter-button" type="submit">Filter</button>
        </form>

        <div class="projects-grid">
            <?php
            // Get filter values
            $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
            $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

            // Convert input dates to Ymd format for ACF comparison
            $start_date_timestamp = !empty($start_date) ? strtotime(str_replace('/', '-', $start_date)) : '';
            $end_date_timestamp = !empty($end_date) ? strtotime(str_replace('/', '-', $end_date)) : '';

            $start_date_ymd = !empty($start_date_timestamp) ? date('Ymd', $start_date_timestamp) : '';
            $end_date_ymd = !empty($end_date_timestamp) ? date('Ymd', $end_date_timestamp) : '';

            // Debugging Output
//             if (!empty($start_date) && !empty($end_date)) {
//                 echo "<pre>Filter Debug:
// Start Date (Ymd): $start_date_ymd
// End Date (Ymd): $end_date_ymd</pre>";
//             }

            // Default WP Query Args
            $args = array(
                'post_type'      => 'projects',
                'posts_per_page' => -1,
                'orderby'        => 'meta_value',
                'order'          => 'DESC'
            );

            // If filtering is applied, add meta_query
            if (!empty($start_date_ymd) && !empty($end_date_ymd)) {
                $args['meta_query'] = array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'project_starting_date',
                        'value'   => $start_date_ymd,
                        'compare' => '>=',
                        'type'    => 'DATE'
                    ),
                    array(
                        'key'     => 'project_ending_date',
                        'value'   => $end_date_ymd,
                        'compare' => '<=',
                        'type'    => 'DATE'
                    )
                );
            }

            // WP Query Execution
            $projects_query = new WP_Query($args);

            if ($projects_query->have_posts()) :
                while ($projects_query->have_posts()) : $projects_query->the_post();
                    $starting_date = get_field('project_starting_date');
                    $ending_date = get_field('project_ending_date');

                    // Convert ACF stored format (d/m/Y) to readable format
                    $formatted_start_date = !empty($starting_date) ? date('F j, Y', strtotime(str_replace('/', '-', $starting_date))) : '';
                    $formatted_end_date = !empty($ending_date) ? date('F j, Y', strtotime(str_replace('/', '-', $ending_date))) : '';
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
                                <?php if ($formatted_start_date && $formatted_end_date): ?>
                                    <div class="project-dates">
                                        <span class="start-date">Start: <?php echo esc_html($formatted_start_date); ?></span>
                                        <span class="end-date">End: <?php echo esc_html($formatted_end_date); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No projects found matching your criteria.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
