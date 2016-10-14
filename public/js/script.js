
$(window).load(function () {
    ;
    anime =$('input[name="anime"]').val();
    p = $('input[name=part]').val();
    t = $('input[name=type]').val();

    $('.ui.rating')
        .rating({maxRating:5});
    $('.ui.rating')
        .rating('setting', 'onRate', function(value) {


            var token = $(this).data('token');
            console.log(token);
            console.log  ($(this).find('input[name="anime"]').val());
            $.ajax({
                url:'/vote',
                type:'post',
                data: {vote:value,
                    name:anime,
                    part:p,
                    type:t, _token:token},
                success:function(data)
                {
                    console.log(data);

                }

            });
        });
    $('.dropdown')
        .dropdown({
            // you can use any ui transition
            transition: 'drop'
        })
    ;

    $('.ui.prof.rating')
        .rating('disable')
    ;

});
function submitForm() {
    var anime = $('input[name=nu4]').val();
    var p = $('input[name=part]').val();
    var t =$('input[name=type]').val();
    var token = $('input[name=_token]').val();
    var list=$('.dropdown').find('.item.active.selected').data('value');

    console.log(anime);
    console.log(p);
    var formData = {
        l: list,
        name:anime,
        part:p,
        type:t,
        _token:token

    };
    console.log(formData);

    $.ajax({ type: 'POST', url: '/addtobook', data: formData, success: onFormSubmitted() });
}

function onFormSubmitted(response) {
    // Do something with response ...
    console.log('nu4');
    $('#bookmark').append(' <div class="ui green message" >Добавлено </div>')
    //console.log(response);
}