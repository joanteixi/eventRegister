$(document).ready(function () {
    $('form').submit(function () {

        $.ajax({
            type:'POST',
            url:$(this).attr('action'),
            data:$(this).serialize(),
            success:function (data, textStatus, jqXHR) {
                $('form').prepend('<div class="alert fade in"><button type="button" class="close" data-dismiss="alert">×</button>' +
                    data.msg +
                    '</div>');

                $('form').find('input[type=text]').val('');
                $('form').find('.error').removeClass('error');
                $('form').find('.help-block').fadeOut();

            },
            error:function (jqXHR, textStatus, errorThrown) {
                var msg = 'Error:\n';
                var jsonResponse = jQuery.parseJSON(jqXHR.responseText);
                $.each(jsonResponse.errors, function (index, value) {
                    idTag = index.replace('[', '').replace(']', '');
                    $('#' + idTag).addClass('error').find('p').html(value);

                });
            }
        });
        return false;
    })
});

$('#myModal').on('show', function () {

    iframe = $('<iframe/>', {
        'name': 'gmap',
        'src' : "https://maps.google.com/maps?q=Casa+del+Mar+de+Barcelona,+Calle+de+Albareda,+Barcelona,+Espa%C3%B1a&hl=ca&ie=UTF8&ll=41.37366,2.173877&spn=0.050561,0.077162&sll=37.0625,-95.677068&sspn=54.005807,79.013672&oq=casa+del+mar+barcelona&t=w&hq=Casa+del+Mar&hnear=Carrer+d'Albareda,+08004+Barcelona,+Catalunya,+Espanya&z=14&output=embed",
        'id'  : 'map',
        'width' : '100%',
        'height' : '450px'
    });
    $('#body-mapa').html(iframe);
});



