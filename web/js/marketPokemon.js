
function pokemonsOferts(page)
{
    if (page === undefined) {
        page = 0;
    }
    var params = {
        'page' : page,
        'ID'  : $('#ID').val(),
        'min_level' : $('#min_level').val(),
        'max_level' : $('#max_level').val(),
        'min_value' : $('#min_value').val(),
        'max_value' : $('#max_value').val()
    };
    $.ajax({
        type: "POST",
        url: searchHref,
        data: params
    }).done(function(msg){
        $('#prawo').html(msg);
    });
}

$(document).ready(function()
{

    $('#prawo').on('click', '.szukaj', function()
    {
        pokemonsOferts();
    });

    $('#prawo').on('keydown', '.form-control', function(event)
    {
        if(event.which === 13)
        {
            pokemonsOferts();
        }
    });

    $('#prawo').on('click', '.kup_pokemon', function()
    {
        var params = {
            'id'  : this.id
        };
        $.ajax({
            type: "POST",
            url: buyHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });

    $('#prawo').on('click', '.data_pok_info', function()
    {
        var url = pokemonInfoHref.replace("replace", $(this).attr("data-pok-id"));
        $('.modal-body').load(url+'?modal=1');
        $('#pokemon_modal').modal("show");
    });

    function sell(id)
    {
        var value = $('input[data-id="cena_pok_'+id+'"').val();
        if(value === '') {
            alert('Wpisz cenę!');
        } else {
            var message = $('input[data-id="wiadomosc_pok_'+id+'"]').val();
            message = encodeURIComponent(message);
            var params = {
                'id'  : id,
                'message' : message,
                'value' : value
            };
            $.ajax({
                type: "POST",
                url: sellHref,
                data: params
            }).done(function(msg){
                $('#prawo').html(msg);
                $('#tabelka').load(leftHref);
            });
        }
    }

    $('#prawo').on('keydown','.cena_pok',function( event)
    {
        if ( event.which == 13 )
        {
            var dlugosc = this.id.length;
            var id = new Array(dlugosc-9);
            id = this.id.substr( 9 );
            kliknij_wystaw(id);
        }
    });
    $('#prawo').on('keydown','.wiadomosc_pok',function( event)
    {
        if ( event.which == 13 )
        {
            var dlugosc = this.id.length;
            var id = new Array(dlugosc-14);
            id = this.id.substr( 14 );
            kliknij_wystaw(id);
        }
    });

    $('#prawo').on('click','.wystaw_poka',function()
    {
        var id = $(this).attr('data-id');
        sell(id);
    });

    $('#prawo').on('click', '.wycofaj_poka', function() {
       var params  = {
           'id' : $(this).attr('data-id')
       };
        $.ajax({
            type: "POST",
            url: removeFromMarketHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    });
});
