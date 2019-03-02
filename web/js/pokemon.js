$(document).ready(function()
{
    $('#prawo').on('click', 'button.description', function()
    {
        var id = $(this).attr('data-id');
        var params = {
            'id' : id,
            'what' : 'description',
            'value' : $('textarea[data-id="description-'+id+'"]').text()
        };
        $.ajax({
            type: "POST",
            url: changeHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });
    $('#prawo').on('click', 'span.btn', function()
    {
        var id = $(this).attr('data-id');
        var params = {
            'id' : id,
            'what' : 'name',
            'value' : $('input[id="pokemon-name"][data-id="'+ id +'"]').val()
        };
        $.ajax({
            type: "POST",
            url: changeHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });
    $('#prawo').on('click', 'button.action', function()
    {
        var params = {
            'id' : $(this).attr('data-id'),
            'what' : $(this).attr('data-what'),
            'value' : $(this).attr('data-value')
        };
        $.ajax({
            type: "POST",
            url: changeHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });
    $('#prawo').on('click', '.nakarm', function()
    {
        var id = $(this).attr('data-id');
        var href = $(this).attr('data-href');
        $('#nakarm_'+id).load(href);
    });


});