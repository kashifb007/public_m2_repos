<template>
    <div id="app">
        <file-pond
            name="photo"
            ref="myPond"
            accepted-file-types="image/jpg, image/jpeg, image/png, image/webp, image/avif, image/heic"
            allow-multiple="false"
            max-files="1"
            credits="false"
            instantUpload="true"
            dropValidation="true"
            allowImageResize="false"
            dropOnPage="true"
            allowImageTransform="true"
            imageTransformOutputMimeType="image/jpeg"
            imageTransformOutputQuality="100"
            allowFileEncode="true"
            allowImagePreview="true"
            allowImageCrop="false"
            imageCropAspectRation="1:1"
            imageResizeTargetWidth="1024"
            maxFileSize="100MB"
            allowProcess="true"
            :server="{ process }"
            v-on:addfile="started"
            v-on:processfile="fileProcessed"
            v-on:processfiles="processFilesComplete"
            v-on:warning="warning"
            imagePreviewMaxHeight="120"
            labelIdle="Drag or click here to upload images"
            v-on:init="handleFilePondInit"
            :file-validate-type-detect-type="validateType"
        />
    </div>
</template>
<script>
// All imports are now handled by RequireJS in the wrapper
// FilePond component is created in FilePondUploaderWrapper.js
export default {
    name: "app",
    props: {
        post_url: { type: String, default: '', required: true }
    },
    watch: {
        browse: function () {
            this.handleBrowse();
        },
        processFiles: function () {
            this.handleProcessFiles();
        },
    },
    methods: {
        warning: function(error) {
            this.$emit('file-pond-warning', error.body);
        },
        fileProcessed: function() {
            // this.$refs.myPond.removeFiles();
        },
        started: function(error, file) {
            // Automatically start processing files when added
            this.handleProcessFiles();
        },
        processFilesComplete: function() {
            // this.$refs.myPond.removeFiles();
        },
        handleProcessFiles() {
            // Access the FilePond instance and manually start the upload
            this.$refs.myPond.processFiles();
        },
        handleBrowse() {
            let files = this.$refs.myPond.getFiles();
            if (files.length === 0) {
                this.$refs.myPond.browse();
            }
        },
        validateType(source, type) {
            const p = new Promise((resolve, reject) => {
                if (source.name.toLowerCase().indexOf('.heic') !== -1) {
                    resolve('image/heic');
                } else {
                    resolve(type)
                }
            })

            return p
        },
        process(fieldName, file, metadata, load, error, progress, abort, transfer, options) {
            const processFile = async (fileToProcess) => {

                //begin xhr
                try {
                    const formData = new FormData();
                    formData.append("filename", fileToProcess, fileToProcess.name);
                    formData.append("form_key", window.FORM_KEY);

                    // Use fetch API for upload
                    const xhr = new XMLHttpRequest();

                    xhr.upload.addEventListener('progress', (e) => {
                        if (e.lengthComputable) {
                            progress(e.lengthComputable, e.loaded, e.total);
                        }
                    });

                    xhr.addEventListener('load', () => {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                load(response);
                            } catch (e) {
                                error('Invalid response from server');
                            }
                        } else {
                            error('Upload failed: ' + xhr.statusText);
                        }
                    });

                    xhr.addEventListener('error', () => {
                        error('Upload failed: Network error');
                    });

                    xhr.open('POST', this.post_url, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.send(formData);

                } catch (err) {
                    error('Upload failed: ' + err.message);
                    console.error('Upload failed', err);
                }
                //end xhr
            };

            if (file.name.toLowerCase().indexOf('.heic') !== -1) {
                const conversionPromise = this.heic2any({
                    blob: file,
                    toType: "image/jpeg",
                    quality: 0.3
                });

                conversionPromise.then((convertedBlob) => {
                    const newFileName = file.name.replace(/\.heic$/i, ".jpg");
                    const convertedFile = new File([convertedBlob], newFileName, { type: "image/jpeg" });
                    processFile(convertedFile);
                }).catch((err) => {
                    console.error("HEIC conversion failed:", err);
                    error("HEIC conversion failed: " + err);
                });
            } else {
                processFile(file);
            }

            return {
                abort: () => {
                    // This function should be called if the user aborts the upload
                }
            };
        },
        handleFilePondInit: function () {
            //console.log('FilePond has initialized');

            // example of instance method call on pond reference
            //console.log(this.$refs.myPond.getFiles());
        },
        handleFileError: function (file) {
            this.$refs.myPond.removeFile(file);
        }
    },
    components: {
        FilePond,
    },
};
</script>
