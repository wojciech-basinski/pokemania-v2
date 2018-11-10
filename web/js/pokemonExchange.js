$(document).ready(function()
{
    $('#prawo').on('click', '.ewoluuj', function()
    {
        var params = {
            'id'  : $(this).attr('data-id'),
            'mode' : 'add'
        };
        $.ajax({
            type: "POST",
            url: exchangeAction,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    });
    $('#prawo').on('click', '.oddaj', function()
    {
        var params = {
            'id'  : $(this).attr('data-id'),
            'mode' : 'get'
        };
        $.ajax({
            type: "POST",
            url: exchangeAction,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    });
});