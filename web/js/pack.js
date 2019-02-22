function select()
{
    $(function() {
        $.widget( "custom.iconselectmenu", $.ui.selectmenu, {
            _renderItem: function( ul, item ) {
                var li = $( "<li>", { text: item.label } );

                if ( item.disabled ) {
                    li.addClass( "ui-state-disabled" );
                }
                $( "<span>", {
                    style: item.element.attr( "data-style" ),
                    "class": "ui-icon " + item.element.attr( "data-class" )
                })
                    .appendTo( li );

                return li.appendTo( ul );
            }
        });

        $( "#cookie_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#bar_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#food_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#ogniste_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#wodne_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#gromu_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#ksiezycowe_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#roslinne_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Cheri_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Wiki_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Pecha_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Aguav_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Leppa_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Oran_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Persim_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Lum_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Sitrus_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#Figy_Berry_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
        $( "#candy_pok" )
            .iconselectmenu()
            .iconselectmenu( "menuWidget" )
            .addClass( "ui-menu-icons customicons" );
    });
}

$(document).ready(function()
{
    select();

    function packLoad(quantity, item, active, pokemon)
    {
        var params = {
            'item'  : item,
            'value' : quantity,
            'active' : active,
            'pokemon' : pokemon
        };
        $.ajax({
            type: "POST",
            url: packUse,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    }

    function drink(item, active)
    {
        var quantity = 1;
        var pokemon = 0;
        if(item != 'lemonade') {
             quantity = $('#'+item+'_ilosc').val();
        }
        if(quantity == '')quantity = 1;
        if(item == 'food' || item == 'bar' || item == 'cookie')
        {
             pokemon = $('#'+item+'_pok').val();
        }
        if(item == 'candy')
        {
            pokemon = $('#'+item+'_pok').val();
        }
        packLoad(quantity, item, active, pokemon);
    }

    $('#prawo').on('click', '.wypij', function()
    {
        var item =  $(this).attr('data-what');
        var active = $(this).attr('data-active');
        $("#" + item + '_opis').modal("hide");
        $("#" + item + '_opis').on('hidden.bs.modal', function () {
            drink(item, active);
        });
    });

    $('#prawo').on('click', '.wypij_all', function()
    {
        var item =  $(this).attr('data-what');
        var active = $(this).attr('data-active');
        $("#" + item + '_opis').modal("hide");
        $("#" + item + '_opis').on('hidden.bs.modal', function () {
            packLoad('all', item, active, 0);
        });
    });

    $('#prawo').on('click', '.jagoda', function()
    {
        var item =  $(this).attr('data-what');
        var active = $(this).attr('data-active');
        var value = $('#'+item+'_ilosc').val();
        if (value == 0) value = 1;
        var pokemon = $('#'+item+'_pok').val();
        if (!pokemon) pokemon = 0;
        $("#" + item + '_opis').modal("hide");
        $("#" + item + '_opis').on('hidden.bs.modal', function () {
            packLoad(value, item, active, pokemon);
        });
    });


  function kamien(co)
  {
   co += '/' + $('#'+co+'_pok').val();
   laduj('plecak/kamien/'+co+'/?ajax&active=4');
  }

  function jagoda_all(co)
  {
   laduj('plecak/jagoda/'+co+'/all/?active=3&ajax');
  }
  function jagoda_max(co)
  {
    if($('#'+co+'_pok').length)
    {
      co += '/max/' + $('#'+co+'_pok').val();
    } else {
        co += '/all';
    }
   laduj('plecak/jagoda/'+co+'/?active=3&ajax');
  }
  $('#prawo').on('click', '.confirmDrink', function()
  {
      var href = packUse + $(this).attr('data-add');
      $('#prawo').load(href);
      $('#tabelka').load(leftHref);
  });
  $('#prawo').on('click', '.karta', function()
  {
      var co =  this.id;
    var adres =  $(this).attr('name');
    $("#" + co + '_opis').modal("hide");
    $("#" + co + '_opis').on('hidden.bs.modal', function () {
     laduj(adres+'/?active=7');
     });
   
  });



  $('#prawo').on('click', '.jagoda_all', function()
  {
   var co =  this.id;
   $("#" + co + '_opis').modal("hide");
   $("#" + co + '_opis').on('hidden.bs.modal', function () {
    jagoda_all(co);
    });
  });
    $('#prawo').on('click', '.jagoda_max', function()
    {
        var item =  $(this).attr('data-what');
        var active = $(this).attr('data-active');
        var value = 'max';
        var pokemon = $('#'+item+'_pok').val();
        if (!pokemon) pokemon = 0;
        $("#" + item + '_opis').modal("hide");
        $("#" + item + '_opis').on('hidden.bs.modal', function () {
            packLoad(value, item, active, pokemon);
        });
    });
    $('#prawo').on('click', '.kamien', function()
    {
        var item =  $(this).attr('data-what');
        var active = $(this).attr('data-active');
        var pokemon = $('#'+item+'_pok').val();
        $("#" + item + '_opis').modal("hide");
        $("#" + item + '_opis').on('hidden.bs.modal', function () {
            packLoad(1, item, active, pokemon);
        });
    });
  $('#prawo').on('shown.bs.modal', function()
  {
      $(this).find('input').focus();
  });
  $('#prawo').on('keydown','.ilosc_jagoda',function( event)
  {
    if ( event.which == 13 )
    {
      var id = this.id.slice( 0, -6 );
      $("#" + id + '_opis').modal("hide");
      $("#" + id + '_opis').on('hidden.bs.modal', function () {
      jagoda(id);
    });
     
    }
  });
  $('#prawo').on('keydown','.ilosc_wypij',function( event)
  {
    if ( event.which == 13 )
    {
      var id = this.id.slice( 0, -6 );
      $("#" + id + '_opis').modal("hide");
      $("#" + id + '_opis').on('hidden.bs.modal', function () {
    wypij(id);
    });
      
    }
  });
  $('#prawo').on('click', '.wymien', function()
  { 
      var active = $(this).attr('name');
      window.location= $(this).attr('data-href') + '?active='+active;
  });
});