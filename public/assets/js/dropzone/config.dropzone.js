function configDropzone(
    clickableElement,
    type_upload,
    max_files,
    max_size,
    format_file
) {
    return {
        url: "{{ route('criteria.form.preview.upload') }}",
        method: "post",
        paramName: clickableElement,
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        params: {
            criteria: clickableElement,
            preview: true,
        },
        resizeQuality: 0.8,
        parallelUploads: 100,
        addRemoveLinks: true,
        autoProcessQueue: false,
        clickable: "#input-file-" + clickableElement,
        maxFilesize: max_size,
        // uploadMultiple: false,
        // maxFiles: 1,
        uploadMultiple: type_upload,
        maxFiles: max_files,
        acceptedFiles: format_file,
        removedfile: function (file) {
            file.previewElement.remove();
            $('button[id="example-submit"]').removeAttr("disabled");
            //     // $.ajax({
            //     //     url: "",
            //     //     type: 'DELETE',
            //     //     data: {
            //     //         _token: "{{ csrf_token() }}",
            //     //         id: file.id
            //     //     },
            //     // });
        },
        // error(file, message) {
        //     if (
        //         file.status == 'error' && message != 'You can not upload any more files.' ||
        //         file.status == 'error' && message != "You can't upload files of this type." ||
        //         file.status == 'error' && message.includes('File is too big')
        //     ) {

        //     }
        //     $('button[id="example-submit"]').removeAttr('disabled');
        //     console.log('e', file, message)
        // },
        init: function () {
            const myDropzone = this;
            this.on("addedfile", function (file) {
                $(".dropzone .dz-preview").css("margin-top", "32px");
                $(".dz-remove")
                    .addClass(
                        "btn btn-danger btn-sm text-decoration-none position-absolute rounded-2 px-3"
                    )
                    .css({
                        top: "-30px",
                        left: "6px",
                    });
                $(".dz-success-mark svg g path").attr("fill", "#2AC840");
                $(".dz-error-mark svg g g").attr("fill", "#DC3545");
                $('button[id="example-submit"]').removeAttr("disabled");
            });

            $('button[id="example-submit"]').click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
                $('button[id="example-submit"]').attr("disabled", "disabled");
            });

            this.on("sending", function (file) {
                $('button[id="example-submit"]').attr("disabled", "disabled");
            });

            this.on("completemultiple", function (files) {
                let statusUpload = true;
                files.forEach((file) => {
                    if (statusUpload && file.status == "error") {
                        statusUpload = false;
                    }
                });
                $('button[id="example-submit"]').removeAttr("disabled");
                if (statusUpload) {
                    // $('form#example-form').submit();
                }
            });

            // this.on('queuecomplete', function() {
            // console.log('second')
            // $('form#example-form').submit();
            // });
            // this.on('errormultiple', function(files, message) {
            //     if (message != 'You can not upload any more files.' || message !=
            //         "You can't upload files of this type.") {

            //         // $('button[id="example-submit"]').removeAttr('disabled');
            //     }
            //     console.log('third', files, message)
            // });

            // this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
            //     // Make sure that the form isn't actually being sent.
            //     e.preventDefault();
            //     e.stopPropagation();
            //     myDropzone.processQueue();
            // });
            //     let thisDropzone = this;
            //     const files = {!! json_encode([]) !!}
            //     files.map(file => {
            //         thisDropzone.displayExistingFile(file, file.source);
            //     });
            //     thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - files.length;
            //     $('.dz-remove').addClass('btn btn-danger btn-sm text-decoration-none mt-2');
            //     $('.dz-success-mark svg g path').attr('fill', '#2AC840');
            //     $('.dz-error-mark svg g g').attr('fill', '#DC3545');
        },
    };
}
