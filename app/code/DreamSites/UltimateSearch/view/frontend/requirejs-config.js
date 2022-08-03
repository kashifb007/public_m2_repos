var config = {
    map: {
        '*': {
            vue: 'DreamSites_UltimateSearch/js/vue',
            alpine: 'DreamSites_UltimateSearch/js/alpine.min',
        }
    },
    shim: {
        alpine: {
            deps: ['vue']
        },
    }
};
