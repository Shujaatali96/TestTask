<footer class="footer">
    <div class="footer-container">
        <!-- Column 1: Site Logo -->
        <div class="footer-logo">
        <?php
        // Display the logo set in the WordPress Customizer
        if (has_custom_logo()) :
            the_custom_logo(); // Displays the logo
        else :
            // Fallback to site title if no logo is set
            echo '<a href="' . home_url() . '">' . get_bloginfo('name') . '</a>';
        endif;
        ?>
    </div>
        
        <!-- Column 2: Description -->
        <div class="footer-description">
            <h3>About Us</h3>
            <p>We are a passionate team providing the best services for your needs. Our goal is to create exceptional value for our customers.</p>
        </div>
        
        <!-- Column 3: Navigation Menu -->
        <div class="footer-nav">
            <h3>Quick Links</h3>
            <?php 
                wp_nav_menu(array(
                    'theme_location' => 'footer_menu', // Change 'footer_menu' to your registered menu location
                    'container' => false,
                    'menu_class' => 'footer-menu',
                ));
            ?>
        </div>
        
        <!-- Column 4: Social Media Icons -->
        <div class="footer-social">
            <h3>Follow Us</h3>
            <ul>
                <li><a href="https://facebook.com" target="_blank"><img src="http://localhost/TestTask/wp-content/uploads/2024/12/facebook.png" alt=""></a></li>
                <li><a href="https://twitter.com" target="_blank"><img src="http://localhost/TestTask/wp-content/uploads/2024/12/instagram.png" alt=""></a></li>
                <li><a href="https://instagram.com" target="_blank"><img src="http://localhost/TestTask/wp-content/uploads/2024/12/twitter.png" alt=""></a></li>

            </ul>
        </div>
    </div>
</footer>

    <?php wp_footer(); ?>
</body>
</html>
