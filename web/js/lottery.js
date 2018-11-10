$(document).ready(function()
{
    $('#prawo').on('click', '.losuj', function(event)
    {
        $.getJSON($(this).attr('data-href'), function(json)
        {
            if (json.status) {
                $('#tickets').text(json.tickets);
                $('#wynik').html('<div class="alert alert-success"><span>' + json.info + '</span></div>');
            } else {
                $('#wynik').html('<div class="alert alert-warning"><span>Nie posiadasz losów na loterię.</span></div>');
            }
            $('#tabelka').load(leftHref);
        });
    });
});
