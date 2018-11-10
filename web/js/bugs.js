$(document).ready(function()
{
    $('#prawo').on('click', '.wyswietl', function()
    {
        $('#prawo').load(listHref);
        history.replaceState( null,null, listHref );
    });
    $('#prawo').on('click', '.np', function()
    {
        $('.panel-body').laduj('?wyswietl&np&ajax', 1, '?wyswietl&np');
    });
    $('#prawo').on('click', '.powrot', function()
    {
        $('#prawo').load(homeAddingHref);
        history.replaceState( null,null, homeAddingHref );
    });
    $('#prawo').on('click', '.zglos', function()
    {
        var params = {
            'title'  : $('textarea[name="tytul"]').val(),
            'content' : $('textarea[name="opis"]').val()
        };
        $.ajax({
            type: "POST",
            url: addHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });
    $('#prawo').on('click', '.usun', function()
    {
        var id = $(this).attr('data-id');
        $('.modal').modal("hide");
        $('.modal').on('hidden.bs.modal', function () {
            var params = {
                'id'  : id,
                'mode' : 'delete'
            };
            $.ajax({
                type: "POST",
                url: adminHref,
                data: params
            }).done(function(msg){
                $('#prawo').html(msg);
            });
        });
    });
    $('#prawo').on('click', '.popraw', function()
    {
        var id = $(this).attr('data-id');
        $('.modal').modal("hide");
        $('.modal').on('hidden.bs.modal', function () {
            var params = {
                'id'  : id,
                'mode' : 'resolve'
            };
            $.ajax({
                type: "POST",
                url: adminHref,
                data: params
            }).done(function(msg){
                $('#prawo').html(msg);
            });
        });
    });
});