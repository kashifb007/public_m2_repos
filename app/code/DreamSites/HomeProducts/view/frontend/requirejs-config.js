var config = {
    deps: [
        "DreamSites_HomeProducts/js/dreamcomputer_slick"
    ],
    map: {
        '*': {
            jquery_migrate: 'DreamSites_HomeProducts/js/jquery-migrate-1.2.1.min',
            slick: 'DreamSites_HomeProducts/js/slick.min',
            jquery_ui: 'DreamSites_HomeProducts/js/jquery-ui-1.9.2',
        }
    },
    shim: {
        slick: {
            deps: ['jquery', 'jquery_migrate'],
            exports: 'jQuery.fn.slick',
        }
    }
};
