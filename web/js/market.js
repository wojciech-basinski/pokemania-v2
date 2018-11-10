function loadOferts(id, page)
{
    if (page === undefined) {
        page = 0;
    }
    var url = searchHref.replace("replace", id) + '?page=' + page;
    $('#content').load(url);
}

$(document).ready(function()
{
    function buy(id)
    {
        var value =  $('input[data-id="ilosc_'+id+'"]').val();
        if (value == '') value = 1;
        var name = $('#przedmiot').text();
        var params = {
            'value'  : value,
            'name' : name,
            'ID' : id
        };
        $.ajax({
            type: "POST",
            url: buyHref,
            data: params
        }).done(function(msg){
            $('#content').html(msg);
        });
    }

    $('#prawo').on('click', '.przedmiot', function()
    {
        var id = $(this).attr('data-id');
        loadOferts(id);
    });

    $('#prawo').on('click', '.btn', function()
    {
        $('.btn').removeClass('active');
        $(this).addClass('active');
    });

    $('#prawo').on('click','.kup',function()
    {
        var id = $(this).attr('data-id');
        buy(id);
    });
    $('#prawo').on('keydown','.targ_ilosc',function( event)
    {
        if ( event.which === 13 )
        {
            var dlugosc = $(this).attr("data-id").length;
            var id = new Array(dlugosc-6);
            id = $(this).attr("data-id").substr( 6 );
            buy(id);
        }
    });

    $('#prawo').on('click','.wycofaj',function()
    {
        var id = $(this).attr("data-id");
        var params = {
            'id'  : id
        };
        $.ajax({
            type: "POST",
            url: removeItemHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });

    function selling(id)
    {
        var quantity =  $('input[data-id="ilosc_'+id+'"]').val();
        if(!quantity) alert("Błędna ilość");
        else
        {
            var value =  $('input[data-id="cena_'+id+'"]').val();
            if(!value) alert("Błędna cena");
            else
            {
                var params = {
                    'id'  : id,
                    'value' : value,
                    'quantity' : quantity
                };
                $.ajax({
                    type: "POST",
                    url: sellingItemHref,
                    data: params
                }).done(function(msg){
                    $('#prawo').html(msg);
                });
            }
        }
    }
    $('#prawo').on('click','.wystaw_przedmiot',function()
    {
        var id = $(this).attr("data-id");
        selling(id);
    });
});