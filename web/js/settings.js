$(document).ready(function()
{
    $('#prawo').on('click', '.change', function() {
        var params = {
            'what'  : $(this).attr('data-what'),
            'value' : $(this).attr('data-value'),
            'active' : $(this).attr('data-active')
        };
        $.ajax({
            type: "POST",
            url: settingsUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });

    $('#prawo').on('click', '#add-description', function() {
        var params = {
            'what'  : 'description',
            'value' : $(document).find('textarea[name="user-description"]').val()
        };
        $.ajax({
            type: "POST",
            url: settingsUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });

    $('#prawo').on('click', '#dodaj_avatar', function() {
        var params = {
            'what'  : 'avatar',
            'value' : $(document).find('input[name="link_a"]').val()
        };
        $.ajax({
            type: "POST",
            url: settingsUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });

    $('#prawo').on('click', '#usun_avatar', function() {
        var params = {
            'what'  : 'deleteAvatar'
        };
        $.ajax({
            type: "POST",
            url: settingsUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });

    $('#prawo').on('click', '#zmien_haslo', function(){
        var params = {
            'what'  : 'password',
            'old' : $('input[name="stare"]').val(),
            'new2' : $('input[name="haslo2"]').val(),
            'new' : $('input[name="haslo"]').val(),
            'active' : 2
        };
        $.ajax({
            type: "POST",
            url: settingsUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });

    $('#prawo').on('click', '#color', function() {
        var params = {
            'what'  : 'background',
            'value' : $('#colorpicker').val(),
            'active' : 3
        };
        $.ajax({
            type: "POST",
            url: settingsUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
        });
    });


    /*$('#prawo').on('click', '.btn', function(){
        var co = this.id;
        
        if(co == 'dodaj_avatar' || co == 'usun_avatar')
        {
            var l = '';
            if(co == 'dodaj_avatar' && $(document).find('input[name="link_a"]').width())
            {
                l = $(document).find('input[name="link_a"]').val();
            }
            else if(co == 'usun_avatar') l = 'usun';
            $.ajax
            ({
                url: URL+"ustawienia/zmien/avatar/?ajax",
                data: {link_a: l},
                type: "post"
            })
            .done(function(lad)
            {
                $( ".tab-content" ).html( lad );
            });
        }
        else if(co == 'color')
        {
            var coo = $('#colorpicker').val();
            coo = encodeURIComponent(coo);
            $.ajax
            ({
                url: URL+'ustawienia/zmien/tlo/?ajax&active=3',
                data: {tlo: coo},
                type: "post"
            })
            .done(function(lad)
            {
                $( ".tab-content" ).html( lad );
            });
        }
        else if(co != 'zmien_haslo')
        {
            $('.tab-content').load(URL+'ustawienia/' + co +'&ajax', function()
            {
                $('#tabelka').load(URL+'lewo');
            });
            history.replaceState(null, null, URL+'ustawienia/' + co);
        }
        else
        {
            var stare = $(document).find('input[name="stare"]').val();
            var nowe = $(document).find('input[name="haslo"]').val();
            var pot = $(document).find('input[name="haslo2"]').val();
            $.ajax
            ({
                url: URL+"ustawienia/zmien/haslo/?ajax=1&active=2",
                data: {stare: stare, haslo: nowe, haslo2: pot },
                type: "post"
            })
            .done(function(lad)
            {
                $( ".tab-content" ).html( lad );
            })
            ;
        }
    });
    $('#prawo').on('change', '#colorpicker', function()
    {
        var color = $(this).val();
        $('.container-fluid').css("background-color", color);
    });
    
    /*hasło
     * $.ajax({
    url: "test.html",
    data: {name: "John", location: "Boston"}
  })
    .done(function( html ) {
      $( "#results" ).append( html );
    });
     * 
     */
});


