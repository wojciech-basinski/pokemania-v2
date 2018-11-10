$(document).ready(function()
{
    var u = 0;
    $('#prawo').on('click', '.usun', function()
    {
        u = 1;
        $.getJSON($(this).attr('data-href'), function(json)
        {
            if (json.status) {
                $("#info").html('<div class="alert alert-success"><span>Poprawnie usunięto raport</span></div>');
                $("div[data-id='" + parseInt(json.id) + "']").remove();
            } else {
                $("#info").html('<div class="alert alert-danger"><span>Niepowodzenie podczas usuwania raportu</span></div>');
            }
        });

        setTimeout( function(){u = 0;}, 1000);
    });
    $('#prawo').on('click', '.usun_w', function()
    {
        $("#info").laduj(URL+'raporty/usunAll/?ajax', 1);
    });
    $('#prawo').on('click', '.tak', function()
    {
        $("#info").load(URL+'raporty/usunAll/?ajax&potw=1', function (){
            $('.panel-body').load(URL+'poczta/?ajax');
        });
    });
    $('#prawo').on('click', '.nie', function()
    {
        $("#info").text('');
    });
    $('#prawo').on('click', '.wiadomosc', function()
    {
        if(u == 0)
        {
            $(this).find('span.new-report').remove();
            $(this).find('div.col-xs-6').removeClass('pogrubienie');
            $('.modal-body').text("ŁADOWANIE");
            $('.modal-title').text("");
            $.getJSON($(this).attr('data-href'), function(json)
            {
                if (json.status) {
                    $('.modal-title').text(json.title);
                    $('.modal-body').html(json.body);
                } else {
                    $('.modal-title').text('Nie znaleziono raportu');
                    $('.modal-body').text('Nie znaleziono raportu');
                }
            });
            $("#raport_modal").modal("show");
        }
    });
    
});