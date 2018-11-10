var zal = '<img class="img-resnponsive" src="./img/kolko.png" />';
var lad = '<img src=' + URL + '"public/img/loader.gif" />';
var sch = 'Schowaj przebieg walki';
var pok = 'Wyświetl przebieg walki';
var kon_w = 1;
var tr = 0;
var poke = 0;
var dzicz = $('#dzicz_ajax').text();

function dziczz() {
    dzicz = $('#dzicz_ajax').text();
    if (dzicz == "dom_strachow") dzicz = "dom_strachów";
    else if (dzicz == "gory") dzicz = "góry";
    else if (dzicz == "laka") dzicz = "łąka";
    else if (dzicz == "mokradla") dzicz = "mokradła";
    dzicz = dzicz.replace("_", " ");
    return dzicz;
}

function kontynuuj(id) {
    tr = 0;
    poke = 0;
    $('.ladowanie').html(lad);
    //$.scrollTo('0%', 300);
    var url = continueHref.replace("replace", id);
    $('#prawo').load(url, function () {
        kon_w = 1;
        $('.ladowanie').html(zal);
        $('#tabelka').load(leftHref, function () {
            tooltip_f();
        });
    });
    history.replaceState(null, null, url);

}

$(document).ready(function () {
    //var klucz = klucz_polowanie;
    //$(document).on('keydown', function(e){klucz(e);});
    $('.ladowanie').html(zal);

    //$('#dzicz_panel').html("POLOWANIE - " + dziczz());
    /*$('#polowanie_glowny_div').on('click','#wyswietl_walke_trener',function()
    {
      if(tr == 0)
      {
        $('#wyswietl_walke_trener').text(sch);
        $('#walka').html(lad).load('wyswietl_walke.php?trener');
      }
      else if(tr & 1)
      {
        $('#wyswietl_walke_trener').text(pok);
        $('#walka').hide();
      }
      else
      {
        $('#wyswietl_walke_trener').text(sch);
        $('#walka').show();
      }
      tr++;
    });*/

    $('#prawo').on('click', '#wyswietl_walke_pokemon', function () {
        if (poke == 0) {
            $('#wyswietl_walke_pokemon').text(sch);
            $('#walka').html(lad);
            $.ajax({
                type: "POST",
                url: showBattleHref
            }).done(function (msg) {
                $('#walka').html(msg);
            });
        }
        else if (poke & 1) {
            $('#wyswietl_walke_pokemon').text(pok);
            $('#walka').hide();
        }
        else {
            $('#wyswietl_walke_pokemon').text(sch);
            $('#walka').show();
        }
        poke++;
    });
    $('#prawo').on('click', '#wyswietl_walke_trener', function () {
        if (tr == 0) {
            $('#wyswietl_walke_trener').text(sch);
            $.ajax({
                type: "POST",
                url: showBattleTrainerHref
            }).done(function (msg) {
                $('#walka').html(msg);
            });
        } else if (tr & 1) {
            $('#wyswietl_walke_trener').text(pok);
            $('#walka').hide();
        } else {
            $('#wyswietl_walke_trener').text(sch);
            $('#walka').show();
        }
        tr++;
    });
    $('.dzicz_img').click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-place');
        if (id != '') kontynuuj(id);
    });
    $('#prawo').on('click', '.button_kontynuuj', function () {
        var id = $(this).attr('data-place');
        if (id != '') kontynuuj(id);
    });

    $('#prawo').on('click', '.polowanie_wlasny_pok', function () {
        var id_poka = $(this).attr('data-id');
        if (id_poka) {
            $('.ladowanie').html(lad);
            //$.scrollTo('0%', 300);
            var params = {
                'pokemonId': id_poka,
                'place': $('#dzicz_ajax').text()
            };
            $.ajax({
                type: "POST",
                url: battleHref,
                data: params
            }).done(function (msg) {
                $('#prawo').html(msg);
                $('#tabelka').load(leftHref);
            });
        }


        /*$('#prawo').load(URL+'polowanie/walka/'+id_poka+'/?ajax', function()
        {
           $('#dzicz_panel').html("POLOWANIE - " + dziczz());
           $('.ladowanie').html(zal);
           $('#tabelka').load(URL+'lewo', function(){tooltip_f();});
           kon_w = 1;
        });
        setTimeout(function()
        {
          var a = $('#wyloguj');
          if(a.length)
          {
            window.location='wyloguj/wyloguj/2';
          }
        }, 300);
     }*/
    });


    $('#prawo').on('click', '.pokeball', function () {
        var pokeball = $(this).attr('data-pokeball');
        var dzicz = $('#dzicz_ajax').text();
        if (pokeball !== '' && dzicz !== '') {
            $('.ladowanie').html(lad);
            //$.scrollTo('0%', 300);
            var params = {
                'pokeball': pokeball,
                'place': $('#dzicz_ajax').text()
            };
            $.ajax({
                type: "POST",
                url: catchHref,
                data: params
            }).done(function (msg) {
                $('#prawo').html(msg);
            });
        }
    });

    $('#prawo').on('click', '.wydarzenie', function () {
        var name = $(this).attr('name');
        $('.ladowanie').html(lad);
        //$.scrollTo('0%', 300);
        var url = continueHref.replace("replace", $('#dzicz_ajax').text());
        var params = {
            'mode': name
        };
        $.ajax({
            type: "GET",
            url: url,
            data: params
        }).done(function (msg) {
            $('#prawo').html(msg);
        });
    });
});
