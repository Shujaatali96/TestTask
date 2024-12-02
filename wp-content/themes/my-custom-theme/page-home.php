<?php
get_header();
?>

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


<section class="info-section">
    <div class="container">
        <!-- Section Heading -->
        <div class="section-header">
            <h2 class="main-heading">What We Do
            </h2>
            <p class="subheading" id="info-subheading">Simplifying the journey of buying, selling, and renting properties. Our expert team provides comprehensive real estate solutions tailored to your needs

</p>
<div class="divider"></div>
        </div>

        <!-- Four Columns -->
        <div class="row">
            <div class="column">
                <div class="info-box">
                    <div class="number">01</div>
                    <h3 class="info-title">Property Sales
                    </h3>
                    <p class="info-description">Find your dream home with Real Estate - our expert team will guide you through the process and ensure a smooth transaction.</p>
                </div>
            </div>
            <div class="column">
                <div class="info-box">
                    <div class="number">02</div>
                    <h3 class="info-title">Property Rentals</h3>
                    <p class="info-description">Find your dream rental property with Real Estate, offering a variety of options to suit your needs and preferences.</p>
                </div>
            </div>
            <div class="column">
                <div class="info-box">
                    <div class="number">03</div>
                    <h3 class="info-title">Management
                    </h3>
                    <p class="info-description">Trust Real Estate to handle the day-to-day management of your property, maximizing its value and minimizing your stress.

</p>
                </div>
            </div>
            <div class="column">
                <div class="info-box">
                    <div class="number">04</div>
                    <h3 class="info-title">Investments
                    </h3>
                    <p class="info-description">Real Estate presents lucrative investment opportunities in the real estate market, providing high returns on investments.

</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="projects-carousel-section">
    <h2 class="section-title">Our Projects</h2>
    
    <!-- Swiper Container -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // WP Query to fetch Projects
            $args = array(
                'post_type' => 'projects',  // Custom Post Type
                'posts_per_page' => 6,  // Display 6 projects
            );
            $projects_query = new WP_Query($args);
            
            if ($projects_query->have_posts()) :
                while ($projects_query->have_posts()) : $projects_query->the_post();

                    // Get the starting and ending dates
                    $starting_date = get_field('project_starting_date'); // ACF field for starting date
                    $ending_date = get_field('project_ending_date'); // ACF field for ending date
                    ?>
                    <div class="swiper-slide project-card">
                        <div class="project-card-inner">
                            <div class="project-image">
                                <?php the_post_thumbnail('medium'); // Display project featured image ?>
                            </div>
                            <div class="project-info">
                                <h3 class="project-title"><?php the_title(); ?></h3>
                                <p class="project-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>

                                <!-- Display starting and ending dates inline -->
                                <?php if ($starting_date && $ending_date): ?>
                                    <div class="project-dates">
                                        <span class="start-date">Start: <?php echo date('F j, Y', strtotime($starting_date)); ?></span>
                                        <span class="end-date">End: <?php echo date('F j, Y', strtotime($ending_date)); ?></span>
                                    </div>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>" class="btn btn-read-more">Read More</a>
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
        
        <!-- Swiper Navigation Buttons (Optional) -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>



<section class="contact-us-section">
    <!-- Background Overlay -->
    <div class="overlay"></div>

    <h2 class="section-title">Contact Us</h2>

    <div class="contact-container">
        <!-- Contact Info -->
        <div class="contact-info">
            <h2>How to Contact Us?</h2>
            <div class="contact-info-item">
                <!-- <i class="fas fa-phone"></i> -->
                 <img src="http://localhost/TestTask/wp-content/uploads/2024/12/phone-call-2.png" alt="">
                <a href="tel:+1234567890" class="contact-info-link">+123 456 7890</a>
            </div>
            <div class="contact-info-item">
                <!-- <i class="fas fa-envelope"></i> -->
                 <img src="http://localhost/TestTask/wp-content/uploads/2024/12/letter.png" alt="">
                <a href="mailto:info@example.com" class="contact-info-link">info@example.com</a>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="contact-form">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name"> Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" name="submit_contact_form" class="submit-button">Submit</button>
                    <button type="reset" class="reset-button">Reset</button>
                </div>
            </form>
        </div>
    </div>
</section>





<?php
get_footer();
?>
