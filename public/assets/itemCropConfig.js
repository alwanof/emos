var placeID = null;
const base_url = 'https://2urkeymenu.com/public/';
$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
        width: 300,
        height: 300,
        type: 'square' //square
    },
    boundary: {
        width: 300,
        height: 300
    }
});

$('.crop_image').click(function(event) {
    $image_crop.croppie('result', {
        type: 'canvas',
        //size: 'viewport'
        size: 'original',
        format:'jpeg',
        quality: 0.7,
        size: { width: 500, height: 500 }
    }).then(function(response) {
        //var rand = Math.floor(Math.random() * 1000000);
        var rand = $('#placeholder').attr('dataID');
        $.ajax({
            url: base_url + "/assets/itemAvatarUpload.php?title=" + rand,
            type: "POST",
            data: { "image": response },
            success: function(data) {
                $('#uploadimageModal').modal('hide');
                $(placeID).html(data);
            }
        });
    })
});

function canvasArea(areaID, placeHolder) {
    placeID = placeHolder;
    var reader = new FileReader();
    reader.onload = function(event) {
        $image_crop.croppie('bind', {
            url: event.target.result
        }).then(function() {
            console.log('jQuery bind complete');
        });
    }

    reader.readAsDataURL(areaID.files[0]);
    $('#uploadimageModal').modal('show');

}
