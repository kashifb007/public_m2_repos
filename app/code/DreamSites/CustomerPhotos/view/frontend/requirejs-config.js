var config = {
    map: {
        '*': {
            'text': 'mage/requirejs/text',
            'filepond': 'DreamSites_CustomerPhotos/js/filepond/filepond.min',
            'filepond-plugin-image-preview': 'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-image-preview.min',
            'filepond-plugin-file-validate-type': 'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-file-validate-type.min',
            'filepond-plugin-image-crop': 'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-image-crop.min',
            'filepond-plugin-image-transform': 'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-image-transform.min',
            'filepond-plugin-image-resize': 'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-image-resize.min',
            'filepond-plugin-file-validate-size': 'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-file-validate-size.min',
            'heic2any': 'DreamSites_CustomerPhotos/js/filepond/heic-to',
            'splide': 'DreamSites_HomeCarousel/js/splide.min'
        }
    },
    shim: {
        'DreamSites_CustomerPhotos/js/filepond/filepond.min': {
            exports: 'FilePond'
        },
        'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-image-preview.min': {
            deps: ['filepond']
        },
        'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-file-validate-type.min': {
            deps: ['filepond']
        },
        'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-image-crop.min': {
            deps: ['filepond']
        },
        'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-image-transform.min': {
            deps: ['filepond']
        },
        'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-image-resize.min': {
            deps: ['filepond']
        },
        'DreamSites_CustomerPhotos/js/filepond/filepond-plugin-file-validate-size.min': {
            deps: ['filepond']
        },
        'DreamSites_HomeCarousel/js/splide.min': {
            exports: 'Splide'
        }
    },
    config: {
        text: {
            headers: {
                'Accept': 'text/plain'
            }
        }
    }
};
