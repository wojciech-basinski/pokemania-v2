$.getScript('//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js');
$(document).ready(function() {
    var zaz = 0;
    var id_konst = 0;
    var war = 0;
    function e(a)
    {
        var w = $('#'+a+'_wartosc').text();
        w = w.replace('.', '');
        w = parseInt(w);
        if($('input[name="'+a+'"]').is(":checked"))
        {
            zaz++;
            war = war + w;
        }
        else
        {
            zaz--;
            war = war - w;
        }
        $('#zaznaczonych').html('Zaznaczono '+zaz+' Pokemonów.');
        $('#wartosc_zaznaczonych').html('Wartość zaznaczonych Pokemonów '+numeral(war).format('0,0').replace(',', '.')+' &yen;');
    }
    function zamknij()
    {
        $('#menu_hodowla').hide();
        id_konst = 0;
    }
    $('#zaznaczonych').html('Zaznaczono '+zaz+' Pokemonów.');
    $('#wartosc_zaznaczonych').html('Wartość zaznaczonych Pokemonów '+war+' &yen;');
    $('#prawo').on('contextmenu', '.hodowla-btn', function(event)
    {
        id_konst = $(this).attr('name');
        var mousex = event.clientX + 10;
	    var mousey = event.clientY + 10;
        //event.pageX + ", " + event.pageY;
        $('#menu_hodowla').css({ top: mousey, left: mousex }).fadeIn(200);
        $( "#menu_hodowla" ).each( function() 
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
    $(document).click(function()
    {
        zamknij();
    });
    $('.dropdown-menu_dr').on('click', '.info', function()
    {
        $.getJSON('pokemon/id/'+id_konst+'?ajax&modal&t', function(json)
        {
            $('.modal-title[name="pokemon_modal"]').text(json.title);
            $('.modal-body[name="pokemon_modal"]').html(json.body);
        });
        zamknij();
        $('#pokemon_modal').modal("show");
    });
    $('#prawo').on('click', '#zaznacz_wszystkie', function()
    {
        $('.hodowla-btn').addClass('active');
        $('.hodowla').each(function() 
        {
            var a = $(this).prop("checked");
            if(!a)
            {
                $(this).prop("checked", "true");
                e($(this).attr("name"));
            }
        });
        
    });
    $('#prawo').on('change', '.hodowla', function()
    {
        var id = $(this).attr("name");
        e(id);      
    });
    $('#prawo').on('click', '#wszystkie', function()
    {
        var params = {
            'all' : 1
        };
        $.ajax({
            type: "POST",
            url: sellUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            war = 0;
            zaz = 0;
            $('#zaznaczonych').html('Zaznaczono '+zaz+' Pokemonów.');
            $('#wartosc_zaznaczonych').html('Wartość zaznaczonych Pokemonów '+war+' &yen;');
            $('#tabelka').load(leftHref);
        });
    });
    $('#prawo').on('click', '.potwierdz', function()
    {
        var params = {
            'all' : 1
        };
        $.ajax({
            type: "POST",
            url: sellUrl+"?confirm=1",
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            war = 0;
            zaz = 0;
            $('#zaznaczonych').html('Zaznaczono '+zaz+' Pokemonów.');
            $('#wartosc_zaznaczonych').html('Wartość zaznaczonych Pokemonów '+war+' &yen;');
            $('#tabelka').load(leftHref);
        });
    });
    $('#prawo').on('click', '#zaznaczone', function()
    {
        var selected = new Array();
        $('.hodowla').each(function()
        {
            var a = $(this).prop("checked");
            if(a)
            {
                selected.push($(this).attr("name"));
            }
        });
        var params = {
            'all' : 0,
            'selected' : selected
        };
        $.ajax({
            type: "POST",
            url: sellUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            war = 0;
            zaz = 0;
            $('#zaznaczonych').html('Zaznaczono '+zaz+' Pokemonów.');
            $('#wartosc_zaznaczonych').html('Wartość zaznaczonych Pokemonów '+war+' &yen;');
            $('#tabelka').load(leftHref);
        });
    });
    $('.dropdown-menu_dr').on('click', '.sprzedaj_jeden', function()
    {
        $('#hodowla_panel').load(URL+"kupiec/zaznaczone/?ajax", id_konst , function()
        {
            zamknij();
            war = 0;
            zaz = 0;
            $('#zaznaczonych').html('Zaznaczono '+zaz+' Pokemonów.');
            $('#wartosc_zaznaczonych').html('Wartość zaznaczonych Pokemonów '+war+' &yen;');
            $('#tabelka').load(URL+'lewo');
        });
    });
});
