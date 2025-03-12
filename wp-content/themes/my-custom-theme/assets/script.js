document.addEventListener('scroll', function () {
    const header = document.querySelector('.site-header');
    const bannerHeight = document.querySelector('.banner-section').offsetHeight;

    if (window.scrollY > bannerHeight) { // When scrolling past the banner
        header.classList.add('sticky');
    } else {
        header.classList.remove('sticky');
    }
});

// Swiper Carousel Initialization
document.addEventListener('DOMContentLoaded', function() {
    const swiper = new Swiper('.swiper-container', {
        loop: false,  // Disable looping, so it stops at first and last slides
        slidesPerView: 2,  // Number of cards visible at once
        spaceBetween: 20,  // Space between the cards
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            0: {
                slidesPerView: 1, // Show 1 slide
                spaceBetween: 10,
            },
        },
    });
    
    
});

// JavaScript to toggle the mobile menu
document.addEventListener("DOMContentLoaded", function() {
    const hamburgerMenu = document.getElementById('hamburger-menu');
    const mainMenu = document.querySelector('.main-menu');
    const closeButton = document.getElementById('close-button');

    // Check the screen width and hide the main menu on mobile devices by default
    if (window.innerWidth <= 768) {
        mainMenu.style.display = 'none'; 
        closeButton.style.display = 'none'; // Hide the menu on mobile
    }


    // Toggle menu display when hamburger is clicked
    hamburgerMenu.addEventListener('click', function() {
        if (mainMenu.style.display === 'none') {
            mainMenu.style.display = 'block';  // Hide the menu
            hamburgerMenu.style.display = 'none';  // Hide the hamburger menu
            closeButton.style.display = 'block';

        }
    });
    closeButton.addEventListener('click', function() {
        if (mainMenu.style.display === 'block') {
            mainMenu.style.display = 'none';  // Hide the menu
            hamburgerMenu.style.display = 'flex';  // Hide the hamburger menu
            closeButton.style.display = 'none';

        }
    });

    // Optionally, handle window resize events to make sure the menu is shown or hidden
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            mainMenu.style.display = 'block';  // Always show the menu on larger screens
            hamburgerMenu.style.display = 'none';
        } else {
            mainMenu.style.display = 'none';  // Hide the menu on mobile by default
        }
    });
});




