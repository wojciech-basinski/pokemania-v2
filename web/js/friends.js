$(document).ready(function()
{
    $('#prawo').on('click', '.zaakceptuj', function()
    {
        $('#prawo').load($(this).attr('data-id'));
    });
    $('#prawo').on('click', '.usun', function()
    {
        $('#prawo').load($(this).attr('data-id'));
    });
    $('#prawo').on('click', '.nakarm', function()
    {
        var id = this.id;
        $('#karmienie').addClass('margin-top');
        $('#karmienie').laduj(URL+'pokemon/nakarm/'+id+'?ajax', 1);
    });
     $('#prawo').on('click', '.odrzuc', function()
    {
        $('#prawo').load($(this).attr('data-id'));
    });
    $('#prawo').on('click', '.anuluj', function()
    {
        $('#prawo').load($(this).attr('data-id'));
    });
});
