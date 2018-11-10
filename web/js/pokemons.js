var zaz_rezerwa = 0;
var zaz_poczekalnia = 0;

function n()
{
    zaz_rezerwa = 0;
    zaz_poczekalnia = 0;
}
function zamknij()
{
    $('#menu_poczekalnia').hide();
    $('#menu_rezerwa').hide();
    id_konst = 0;
}
function e_rezerwa(a)
{
    if($('input[name="'+a+'"]').is(":checked"))
        zaz_rezerwa++;
    else
        zaz_rezerwa--;

    if(zaz_rezerwa > 0) $('#zaznaczonych_rezerwa').html('<span>Zaznaczono '+zaz_rezerwa+' Pokemonów.</span><span class="pull-right"><div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Przenieś do:<span class="caret"></span></button><ul class="dropdown-menu dropdown-menu_dr"><li class="kursor druzyna_rez"><a>DRUŻYNY</a></li><li class="kursor poczekalnia_rez"><a>POCZEKALNI</a></li></ul></div></span>').show();
    else $('#zaznaczonych_rezerwa').hide();
}
function e_poczekalnia(a)
{
    if($('input[name="'+a+'"]').is(":checked"))
        zaz_poczekalnia++;
    else
        zaz_poczekalnia--;

    if(zaz_poczekalnia > 0) $('#zaznaczonych_poczekalnia').html('<span class="text-center">Zaznaczono '+zaz_poczekalnia+' Pokemonów.</span><span class="pull-right"><div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Przenieś do:<span class="caret"></span></button><ul class="dropdown-menu dropdown-menu_dr"><li class="kursor druzyna_pocz"><a>DRUŻYNY</a></li><li class="kursor rezerwa_pocz"><a>REZERWY</a></li></ul></div></span>').show();
    else $('#zaznaczonych_poczekalnia').hide();
}
function table()
{
    $('#tabelka').load(leftHref);
    $.scrollTo("0%", 300);
}
$(document).ready(function()
{
    var id_konst = 0;
    $('.dropdown-menu_dr').dropdown("toggle");
    //Pokemon z drużyny do rezerwy
    $('#prawo').on('click', '.rezerwa', function()
    {
        var params = {
            'id'  : $(this).attr('pok-id'),
            'active' : 1,
            'fromTeam' : 1
        };
        $.ajax({
            type: "POST",
            url: reserveHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });

    //Pokemony z rezerwy do drużyny
    $('#prawo').on('click', '.druzyna_rez', function()
    {
        var selected = new Array();
        $('.rezerwa_zaz').each(function()
        {
            if($(this).prop("checked")) {
                selected.push($(this).attr("name"));
            }
        });
        var params = {
            'active' : 2,
            'selected' : selected
        };
        $.ajax({
            type: "POST",
            url: teamHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });

    //Pokemony z poczekalni do drużyny
    $('#prawo').on('click', '.druzyna_pocz', function()
    {
        var selected = new Array();
        $('.poczekalnia_zaz').each(function()
        {
            if($(this).prop("checked")) {
                selected.push($(this).attr("name"));
            }
        });
        var params = {
            'active' : 3,
            'selected' : selected
        };
        $.ajax({
            type: "POST",
            url: teamHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });

    //Pokemony do rezerwy z poczekalni
    $('#prawo').on('click', '.rezerwa_pocz', function()
    {
        var selected = new Array();
        $('.poczekalnia_zaz').each(function()
        {
            if($(this).prop("checked")) {
                selected.push($(this).attr("name"));
            }
        });
        var params = {
            'active' : 3,
            'selected': selected,
            'fromTeam' : 0
        };
        $.ajax({
            type: "POST",
            url: reserveHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });

    //Pokemony z rezerwy do poczekalni
    $('#prawo').on('click', '.poczekalnia_rez', function()
    {
        var selected = new Array();
        $('.rezerwa_zaz').each(function()
        {
            if($(this).prop("checked")) {
                selected.push($(this).attr("name"));
            }
        });
        var params = {
            'active' : 2,
            'selected': selected
        };
        $.ajax({
            type: "POST",
            url: waitingHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });


    $('.dropdown-menu_dr').on('click', '.przenies_rez', function()
    {
        var where = this.id.slice(0, -1);
        var selected = new Array();
        selected.push(id_konst);
        var params = {
            'active' : 2,
            'selected': selected
        };
        var href = '';
        if (where === 'druzyna') {
            href = teamHref;
        } else {
            href = waitingHref;
        }

        $.ajax({
            type: "POST",
            url: href,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
        zamknij();
    });
    $('.dropdown-menu_dr').on('click', '.przenies_pocz', function()
    {
        var where = this.id.slice(0, -1);
        var selected = new Array();
        selected.push(id_konst);
        var params = {
            'active' : 3,
            'selected': selected
        };
        var href = '';
        if (where === 'druzyna') {
            href = teamHref;
        } else {
            href = reserveHref;
        }
        $.ajax({
            type: "POST",
            url: href,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
        zamknij();
    });

    //priorytet do góry
    $('#prawo').on('click', '.up', function()
    {
        var id = $(this).attr('pok-id');
        var params = {
            'up' : 1,
            'i' : id
        };
        $.ajax({
            type: "POST",
            url: orderHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });
    //priorytet do dołu
    $('#prawo').on('click', '.down', function()
    {
        var id = $(this).attr('pok-id');
        var params = {
            'up' : 0,
            'i' : id
        };
        $.ajax({
            type: "POST",
            url: orderHref,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            table();
        });
    });















    $('#prawo').on('change', '.rezerwa_zaz', function()
    {
        var id = $(this).attr("name");
        e_rezerwa(id);
    });
    $('#prawo').on('change', '.poczekalnia_zaz', function()
    {
        var id = $(this).attr("name");
        e_poczekalnia(id);
    });
    $('#prawo').on('contextmenu', '.poczekalnia-btn', function(event)
    {
        id_konst = $(this).attr('name');
        var mousex = event.clientX + 10;
	var mousey = event.clientY + 10;
        //event.pageX + ", " + event.pageY;
        $('#menu_poczekalnia').css({ top: mousey, left: mousex }).fadeIn(200);
        $( "#menu_poczekalnia" ).each( function() 
        {
            var windowHeight = $(window).innerHeight();
            var pageScroll = $(window).scrollTop();
            var offset = $( this ).offset().top;
            var space = windowHeight - (offset - pageScroll) ;

            if( space < 220 ) {
                $( this ).addClass( "dropup" );
            } else  {
                $( this ).removeClass( "dropup" );
            }
        });
        return false;
    });
    $('#prawo').on('contextmenu', '.rezerwa-btn', function(event)
    {
        id_konst = $(this).attr('name');
        var mousex = event.clientX + 10;
	var mousey = event.clientY + 10;
        //event.pageX + ", " + event.pageY;
        $('#menu_rezerwa').css({ top: mousey, left: mousex }).fadeIn(200);
        $( "#menu_rezerwa" ).each( function() 
        {
            var windowHeight = $(window).innerHeight();
            var pageScroll = $(window).scrollTop();
            var offset = $( this ).offset().top;
            var space = windowHeight - ( offset - pageScroll );

            if( space < 180 ) {
                $( this ).addClass( "dropup" );
            } else  {
                $( this ).removeClass( "dropup" );
            }
        });
        return false;
    });
    $(document).click(function()
    {
        zamknij();
    });

    $('#prawo').on('click', '.targ-btn',function()
    {
        var url = pokemonInfoHref.replace("replace", $(this).attr("name"));
        $('.modal-body[name="pokemon_modal"]').load(url+'?modal=1');
        zamknij();
        $('#pokemon_modal').modal("show");
    });
    $('.dropdown-menu_dr').on('click', '.info', function()
    {
        var url = pokemonInfoHref.replace("replace", id_konst);
        $('.modal-body[name="pokemon_modal"]').load(url+'?modal=1');
        zamknij();
        $('#pokemon_modal').modal("show");
    });
    $('.dropdown-menu_dr').on('click', '.hodowla', function()
    {
        $('.modal-title[name="pokemon_modal"]').text('SPRZEDAŻ POKA'); 
        $('.modal-body[name="pokemon_modal"]').text('');
        $('.modal-body[name="pokemon_modal"]').load('kupiec/zaznaczone/?ajax&komunikat&'+id_konst);
        $('#content').load(URL+'pokemony/?ajax&active=3', function(){
            $('#tabelka').load(URL+'lewo');
        });
        zamknij();
        n();
        $('#pokemon_modal').modal("show");
    });
    $('.dropdown-menu_dr').on('click', '.wystaw', function()
    {
        window.location = sellPokemonHref+'?marked='+id_konst;
    });



});