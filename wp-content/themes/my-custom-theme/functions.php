<?php
function my_theme_enqueue_scripts() {
    // Enqueue the main stylesheet
    wp_enqueue_style('my-theme-style', get_stylesheet_uri());

    // Enqueue the custom JavaScript file (original script.js in 'js' folder)
    wp_enqueue_script('my-theme-script', get_template_directory_uri() . '/assets/script.js', array('jquery'), null, true);

    // Enqueue the custom JavaScript file in the 'assets' folder
    wp_enqueue_script(
        'sticky-header', // Handle for the script
        get_template_directory_uri() . '/assets/script.js', // Path to the script
        array(), // Dependencies (none in this case)
        false, // Version (set to `false` to skip versioning or use `wp_get_theme()->get('Version')` for dynamic versioning)
        true // Load in the footer
    );
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

function my_theme_setup() {
    // Add custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menu
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'my-custom-theme'),
    ));
}
add_action('after_setup_theme', 'my_theme_setup');

// Registering Sidebar
function my_theme_register_sidebars() {
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'my-custom-theme'),
        'id'            => 'main-sidebar',
        'description'   => __('Widgets in this area will be shown in the main sidebar.', 'my-custom-theme'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'my_theme_register_sidebars');
function enqueue_theme_assets() {
    // Enqueue Swiper CSS
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), null);

    // Enqueue Swiper JS
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);

    // Enqueue your custom script.js file
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/script.js', array('swiper-js', 'jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');

// Register Custom Post Type for 'Projects'
function create_projects_post_type() {
    $args = array(
        'label'               => 'Projects',
        'description'         => 'A post type for projects.',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'projects'),
        'show_in_rest'        => true,
    );
    register_post_type('projects', $args);
}
add_action('init', 'create_projects_post_type');


// Register Custom Taxonomy for 'Project Categories'
function create_projects_taxonomy() {
    $args = array(
        'hierarchical' => true,
        'labels' => array(
            'name'                       => 'Project Categories',
            'singular_name'              => 'Project Category',
            'search_items'               => 'Search Project Categories',
            'all_items'                  => 'All Project Categories',
            'parent_item'                => 'Parent Project Category',
            'parent_item_colon'          => 'Parent Project Category:',
            'edit_item'                  => 'Edit Project Category',
            'update_item'                => 'Update Project Category',
            'add_new_item'               => 'Add New Project Category',
            'new_item_name'              => 'New Project Category Name',
            'menu_name'                  => 'Project Categories',
        ),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'project-category'),
    );
    register_taxonomy('project_categories', array('projects'), $args);
}
add_action('init', 'create_projects_taxonomy');


function enqueue_swiper_assets() {
    // Enqueue Swiper CSS
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');

    // Enqueue Swiper JS
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);

    // Enqueue your custom script.js (Assuming it’s located in the assets/js folder inside the theme)
    wp_enqueue_script('swiper-init', get_template_directory_uri() . '/assets/script.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');


add_theme_support('post-thumbnails');


// Handle contact form submission
function handle_contact_form_submission() {
    if (isset($_POST['submit_contact_form'])) {
        // Get form data
        $first_name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $message = sanitize_textarea_field($_POST['message']);

        // Prepare the email content
        $to = get_option('admin_email'); // Send to the WordPress admin email
        $subject = 'New Contact Us Message';
        $body = "First Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message";
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        // Send the email
        wp_mail($to, $subject, $body, $headers);

        // Redirect or show a success message
        echo '<div class="success-message">Thank you for contacting us. We will get back to you soon!</div>';
    }
}
add_action('wp_head', 'handle_contact_form_submission'); // Hook into wp_head for form handling
function my_custom_scripts() {
    wp_enqueue_script('hamburger-menu', get_template_directory_uri() . '/assets/script.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'my_custom_scripts');

// Registering Custom Post type Blogs

function create_custom_post_type_blogs() {
    $args = array(
        'label'  => 'Blogs',
        'public' => true,
        'show_in_menu' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'blogs'), // URL structure
        'menu_icon' => 'dashicons-admin-post', // WordPress Dashicons
    );

    register_post_type('blogs', $args);
}
add_action('init', 'create_custom_post_type_blogs');
