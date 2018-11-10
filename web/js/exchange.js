$(document).ready(function()
{
    $('#prawo').on('click', '.wymien', function()
    {
        var params = {
            'id' : $(this).attr('data-id'),
            'confirm' : $(this).attr('data-confirm'),
            'active' : 1,
            'parts' : 1
        };
        $.ajax({
            type: "POST",
            url: actionHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    });
    $('#prawo').on('click', '.nie', function()
    {
        $('#prawo').load(exchangeHref + '?active=' + $(this).attr('data-active'));
    });
    $('#prawo').on('click', '.tak', function()
    {
        var params = {
            'id' : $(this).attr('data-id'),
            'confirm' : 1,
            'active' : $(this).attr('data-active'),
            'parts' :  $(this).attr('data-parts')
        };
        $.ajax({
            type: "POST",
            url: actionHref,
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
            'active' : 1
        };
        $.ajax({
            type: "POST",
            url: getPokemonHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    });
    $('#prawo').on('click', '.wymien_d', function()
    {
        var params = {
            'id' : $(this).attr('data-id'),
            'confirm' : $(this).attr('data-confirm'),
            'active' : 2,
            'parts' : 0
        };
        $.ajax({
            type: "POST",
            url: actionHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    });
});