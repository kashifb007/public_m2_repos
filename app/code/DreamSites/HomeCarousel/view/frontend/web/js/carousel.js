define([
    'jquery',
    'splide'
], function ($, Splide) {
    'use strict';

    return function (config, element) {
        var carousel = $(element).find('.splide-carousel')[0];

        if (carousel) {
            var splide = new Splide(carousel, {
                type: 'loop',
                perPage: 1,
                perMove: 1,
                width: '100%',
                pagination: false,
                autoplay: true,
                interval: 6000,
                pauseOnHover: true,
                pauseOnFocus: false,
            }).mount();

            // Store timeout IDs for cleanup
            var animationTimeouts = [];

            function clearAnimationTimeouts() {
                animationTimeouts.forEach(function(timeoutId) {
                    clearTimeout(timeoutId);
                });
                animationTimeouts = [];
            }

            function hideAllSlides() {
                // Select ALL titles, descriptions, and buttons directly
                var allTitles = carousel.querySelectorAll('.slider__content--maintitle');
                var allDescs = carousel.querySelectorAll('.slider__content--desc');
                var allBtns = carousel.querySelectorAll('.slider__content--btn');

                // Remove transitions for instant hiding
                allTitles.forEach(function(title) {
                    title.classList.remove('transition');
                    title.classList.remove('duration-700');
                    title.classList.add('opacity-0', 'translate-y-3');
                    title.classList.remove('opacity-100', 'translate-y-0');
                });

                allDescs.forEach(function(desc) {
                    desc.classList.remove('transition');
                    desc.classList.remove('duration-700');
                    desc.classList.add('opacity-0', 'translate-y-3');
                    desc.classList.remove('opacity-100', 'translate-y-0');
                });

                allBtns.forEach(function(btn) {
                    btn.classList.remove('transition');
                    btn.classList.remove('duration-700');
                    btn.classList.add('opacity-0', 'translate-y-4');
                    btn.classList.remove('opacity-100', 'translate-y-0');
                });
            }

            function animateAllSlides() {
                // Clear any pending animations
                clearAnimationTimeouts();

                // First, reset all slides to hidden state
                hideAllSlides();

                // Select ALL elements directly
                var allTitles = carousel.querySelectorAll('.slider__content--maintitle');
                var allDescs = carousel.querySelectorAll('.slider__content--desc');
                var allBtns = carousel.querySelectorAll('.slider__content--btn');

                // Re-enable transitions before animating
                allTitles.forEach(function(title) {
                    title.classList.add('transition', 'duration-700');
                });
                allDescs.forEach(function(desc) {
                    desc.classList.add('transition', 'duration-700');
                });
                allBtns.forEach(function(btn) {
                    btn.classList.add('transition', 'duration-700');
                });

                // Then animate them all (only visible one will be seen)
                var timeout1 = setTimeout(function () {
                    allTitles.forEach(function(title) {
                        title.classList.remove('opacity-0', 'translate-y-3');
                        title.classList.add('opacity-100', 'translate-y-0');
                    });
                }, 200);

                var timeout2 = setTimeout(function () {
                    allDescs.forEach(function(desc) {
                        desc.classList.remove('opacity-0', 'translate-y-3');
                        desc.classList.add('opacity-100', 'translate-y-0');
                    });
                }, 500);

                var timeout3 = setTimeout(function () {
                    allBtns.forEach(function(btn) {
                        btn.classList.remove('opacity-0', 'translate-y-4');
                        btn.classList.add('opacity-100', 'translate-y-0');
                    });
                }, 800);

                animationTimeouts.push(timeout1, timeout2, timeout3);
            }

            animateAllSlides();

            // After movement starts, hide all slides
            splide.on('move', function () {
                hideAllSlides();
            });

            // Upon dragging, hide all slides
            splide.on('dragging', function () {
                hideAllSlides();
            });

            // After movement completes, animate all slides
            splide.on('moved', function () {
                animateAllSlides();
            });
        } else {
            console.warn('Carousel element not found.');
        }
    };
});
