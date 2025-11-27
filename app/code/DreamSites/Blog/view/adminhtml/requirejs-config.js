var config = {
    map: {
        '*': {
            'vue': 'DreamSites_Blog/js/vue.global',
            'axios': 'DreamSites_Blog/js/axios.min',
            'text': 'mage/requirejs/text',
            'filepond': 'DreamSites_Blog/js/filepond.min',
            'vue-filepond': 'DreamSites_Blog/js/vue-filepond',
            'filepond-plugin-image-preview': 'DreamSites_Blog/js/filepond-plugin-image-preview.min',
            'filepond-plugin-file-validate-type': 'DreamSites_Blog/js/filepond-plugin-file-validate-type.min',
            'filepond-plugin-image-crop': 'DreamSites_Blog/js/filepond-plugin-image-crop.min',
            'filepond-plugin-image-transform': 'DreamSites_Blog/js/filepond-plugin-image-transform.min',
            'filepond-plugin-image-resize': 'DreamSites_Blog/js/filepond-plugin-image-resize.min',
            'filepond-plugin-file-validate-size': 'DreamSites_Blog/js/filepond-plugin-file-validate-size.min',
            'heic2any': 'DreamSites_Blog/js/heic2any-fixed'
        }
    },
    paths: {
        'DreamSites_Blog/js/vue/FilePondUploader': 'DreamSites_Blog/js/vue/FilePondUploader'
    },
    shim: {
        'DreamSites_Blog/js/vue.global': {
            deps: [],
            exports: 'Vue'
        },
        'DreamSites_Blog/js/axios.min': {
            deps: [],
            exports: 'axios'
        },
        'DreamSites_Blog/js/filepond.min': {
            deps: [],
            exports: 'FilePond'
        },
        'DreamSites_Blog/js/vue-filepond': {
            deps: ['vue', 'filepond']
        },
        'DreamSites_Blog/js/filepond-plugin-image-preview.min': {
            deps: ['filepond'],
            exports: 'FilePondPluginImagePreview'
        },
        'DreamSites_Blog/js/filepond-plugin-file-validate-type.min': {
            deps: ['filepond'],
            exports: 'FilePondPluginFileValidateType'
        },
        'DreamSites_Blog/js/filepond-plugin-image-crop.min': {
            deps: ['filepond'],
            exports: 'FilePondPluginImageCrop'
        },
        'DreamSites_Blog/js/filepond-plugin-image-transform.min': {
            deps: ['filepond'],
            exports: 'FilePondPluginImageTransform'
        },
        'DreamSites_Blog/js/filepond-plugin-image-resize.min': {
            deps: ['filepond'],
            exports: 'FilePondPluginImageResize'
        },
        'DreamSites_Blog/js/filepond-plugin-file-validate-size.min': {
            deps: ['filepond'],
            exports: 'FilePondPluginFileValidateSize'
        }
        // Note: heic2any.min has native AMD support, no shim needed
    },
    config: {
        text: {
            headers: {
                'Accept': 'text/plain'
            }
        }
    }
};
