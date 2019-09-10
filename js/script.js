function sendForm( start = 0 ){
    let f = document.forms.namedItem('cs_args');
    let fd = new FormData(f);
    fd.append('start', start)
    let $data = {
        "url": '../c/service_connect.php',
        "method": "POST",
        "processData": false,
        "contentType": false,
        "data": fd,
    }
    
    $.ajax($data)
    .done(($response) => {
        console.log('done');
    })
    .error(($response) => {
        console.log('error');
    });
}

$( document ).ready(function() {
    $('.btn-back').click( () => {
        $('.content-response').fadeOut(100, () =>{
            $('.cs').fadeIn();
        });
    } );

    $('form').submit( (e) => {
        e.preventDefault();
            //req ajax
            sendForm();
        $('.cs').fadeOut(100, () =>{
            $('.content-response').css('display', 'flex').hide().fadeIn();
        });
    } );
});