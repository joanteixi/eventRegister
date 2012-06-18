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

            },
            error:function (jqXHR, textStatus, errorThrown) {
                var msg = 'Error:\n';
                var jsonResponse = jQuery.parseJSON(jqXHR.responseText);
                $.each(jsonResponse.errors, function (index, value) {
                    idTag = index.replace('[', '').replace(']', '');
                    console.log(value);

                    $('#' + idTag).addClass('error').find('p').html(value);

                    msg += $('label[for=' + index.replace('[', '').replace(']', '') + ']').html() + ': ' + value + '\n';
                });
//                alert(msg);
            }
        });
        return false;
    })
});

$('#myModal').on('show', function () {
    $('#body-mapa').load('http://maps.google.es');
});
