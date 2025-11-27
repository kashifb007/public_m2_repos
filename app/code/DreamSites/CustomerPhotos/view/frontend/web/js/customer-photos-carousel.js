define([
    'jquery',
    'splide'
], function ($, Splide) {
    'use strict';

    return function (config, element) {
        var carouselElement = $(element).find('.splide')[0];

        if (carouselElement) {
            new Splide(carouselElement, {
                type: 'loop',
                perPage: 4,
                perMove: 1,
                gap: '1rem',
                width: '100em',
                pagination: false,
                autoplay: true,
                interval: 4000,
                pauseOnHover: true,
                pauseOnFocus: false,
                breakpoints: {
                    1200: {
                        perPage: 3,
                    },
                    900: {
                        perPage: 2,
                    },
                    600: {
                        perPage: 1,
                    },
                }
            }).mount();
        }
    };
});
