$(document).ready(function() {

    var lad = 0;
    function laduj(adres, params)
    {
      if(lad == 0 && $('.alert').width) $('.alert').hide();
      lad++;
        $.ajax({
            type: "POST",
            url: adres,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    }
 
    function kup_pokeball(id)
    {
        var ilosc = $('#'+id+'_ilosc').val();
        if(ilosc == '')ilosc = 1;
        var params = {
            'item' : id,
            'quantity' : ilosc
        };
        laduj(buyHref, params);
    }
    function kup_przedmiot(id)
    {
        var ilosc = 0;
        if($('#'+id+'_ilosc').length)
        {
            ilosc = $('#'+id+'_ilosc').val();
            if(ilosc == '')ilosc = 1;
            ilosc = ilosc;
        }
        var params = {
            'item' : id,
            'quantity' : ilosc
        };
        laduj(buyHref + '?active=2', params);
        //history.replaceState(null, null, URL+'sklep/kup/'+id+'/'+ilosc+'/?active=2');
    }
    $('#prawo').on('click', '.kup_pokeball', function()
    {
        var co =  this.id;
        $("#" + co + '_opis').modal("hide");
        $("#" + co + '_opis').on('hidden.bs.modal', function () {
           kup_pokeball(co);
        });
    });
    $('#prawo').on('click', '.kup_przedmiot', function()
    {
        var co =  this.id;
        $("#" + co + '_opis').modal("hide");
        $("#" + co + '_opis').on('hidden.bs.modal', function () {
        kup_przedmiot(co);
        });
    });
    $('#prawo').on('keydown','.ilosc_kup',function( event)
    {
        if ( event.which == 13 )
        {
          var id = this.id.slice( 0, -6 );
          $("#" + id + '_opis').modal("hide");
          $("#" + id + '_opis').on('hidden.bs.modal', function () {
                kup_pokeball(id);
        });
        }
    });
    $('#prawo').on('keydown','.ilosc_kup_przedmiot',function( event)
    {
        if ( event.which == 13 )
        {
          var id = this.id.slice( 0, -6 );
          $("#" + id + '_opis').modal("hide");
          $("#" + id + '_opis').on('hidden.bs.modal', function () {
        kup_przedmiot(id);
        });
    }
    });
    $('#prawo').on('shown.bs.modal', function()
    {
      $(this).find('input').focus();
    });
});
