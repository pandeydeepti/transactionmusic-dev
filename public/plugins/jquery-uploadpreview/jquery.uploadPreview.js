(function ($) {
    var canceledUpload = false;
    $.extend({
        uploadPreview: function (options) {

            // Options + Defaults
            var settings = $.extend({
                input_field: ".image-input",
                preview_box: ".image-preview",
                label_field: ".image-label",
                label_default: "Choose File",
                label_selected: "Change File",
                no_label: false
            }, options);
            var image_upload = document.getElementById(settings.input_field.toString());
            if( image_upload == null ) return;

            document.getElementById(settings.input_field.toString()).addEventListener('change', myMethod, false);

            function myMethod(evt){
                if (window.File && window.FileList && window.FileReader) {
                    var files = evt.target.files;
                    f = files[0];

                    if (f == undefined) {
                        canceledUpload = true;
                    } else{
                        canceledUpload = false;
                        changeImageDiv(this, settings);

                    }
                } else {
                    alert("You need a browser with file reader support, to use this form properly.");
                    return false;
                }
            }

        }
    });

    function changeImageDiv( _this, settings ){
        var files = _this.files;

        if (files.length > 0 && canceledUpload == false) {
            var file = files[0];
            var reader = new FileReader();

            // Load file
            reader.addEventListener("load", function (event) {
                var loadedFile = event.target;

                // Check format
                if( loadedFile.readyState == 2 ){
                    if (file.type.match('image')) {
                        // Image
                        $(settings.preview_box).css("background-image", "url(" + loadedFile.result + ")");
                    } else if (file.type.match('audio')) {
                        // Audio
                        $(settings.preview_box).html("<audio controls><source src='" + loadedFile.result + "' type='" + file.type + "' />Your browser does not support the audio element.</audio>");
                    } else {
                        alert("This file type is not supported yet.");
                    }
                }
            });

            if (settings.no_label == false) {
                // Change label
                $(settings.label_field).html(settings.label_selected);
            }

            // Read the file
            reader.readAsDataURL(file);
        } else {
            if (settings.no_label == false) {
                // Change label
                $(settings.label_field).html(settings.label_default);
            }

            // Clear background
            $(settings.preview_box).css("background-image", "none");

            // Remove Audio
            $(settings.preview_box + " audio").remove();
        }
    }
})(jQuery);
