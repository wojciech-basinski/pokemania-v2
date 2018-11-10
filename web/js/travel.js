$(document).ready(function(){
    $('#prawo').on('click', '.podroz', function(){
        var params = {
            'region' : $(this).attr("data-region")
        };
        $.ajax({
            type: "POST",
            url: changeRegion,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });
});