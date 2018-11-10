$(document).ready(function() {

    $('#prawo').on('click', '.wylecz', function(event)
    {
        var co = $(this).attr('data-href');
        $.ajax({
            type: "POST",
            url: co
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    });

});
