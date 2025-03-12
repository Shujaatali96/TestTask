<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="container">
        <!-- Left: Logo -->
        <div class="header-left">
            <?php
            if (has_custom_logo()) {
                the_custom_logo(); // Dynamically fetch WordPress logo
            } else {
                echo '<a href="' . home_url() . '">' . get_bloginfo('name') . '</a>';
            }
            ?>
        </div>

        <!-- Center: Navigation Menu -->
        <div class="header-center">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'main-menu', // Ensure you register this menu in functions.php
                'menu_class'     => 'main-menu',
                'container'      => false,
            ));
            ?>
        </div>

        <!-- Right: Button -->
        <div class="header-right">
            <a href="/contact" class="btn btn-primary">Contact Us</a>
        </div>

        <!-- Mobile Hamburger Menu -->
        <div class="hamburger-menu" id="hamburger-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <div class="close-button" id="close-button" style="display: none;">
            <span>&times;</span>
        </div>
    </div>
</header>






