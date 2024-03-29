$(document).ready(function (e) {
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzone", {
        url: "/rest/upload",
        maxFiles: 1
    });

    myDropzone.on("success", function (file, response) {
        var fileUrl = response.url;
        $("#appbundle_add_contribution_mediaUrl").val(fileUrl);
        file.previewElement.addEventListener("click", function () {
            myDropzone.removeFile(file);
            $("#appbundle_add_contribution_mediaUrl").val('');
        });
    });

    myDropzone.on("error", function (file) {
        myDropzone.removeFile(file);
    });
});
