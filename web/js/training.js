$(document).ready(function()
{
    var lad = '<div class="ladowanie"><img src="/img/loader.gif" /> TRWA ŁADOWANIE</div>';
    function training(training, value, pokemonId)
    {
        var params = {
            'training'  : training,
            'value' : value,
            'pokemonId' : pokemonId
        };
        $.ajax({
            type: "POST",
            url: trainingUrl,
            data: params
        }).done(function(msg){
            $('#prawo').html(msg);
            $('#tabelka').load(leftHref);
        });
    }
    $('#prawo').on('click','.trenuj',function()
    {
        var id = this.id;
        var trening = id.slice(0, id.indexOf('_'));
        var id_poka = id.slice((id.indexOf('_') +1), id.length);
        var ile = $('#ile_'+id).val();
        training(trening, ile, id_poka);
    });
    $('#prawo').on('click','.trenuj_1',function()
    {
        var id = this.id;
        var trening = id.slice(0, id.indexOf('_'));
        var id_poka = id.slice((id.indexOf('_') +1), id.length);
        training(trening, 1, id_poka);
    });
    $('#prawo').on('keydown','.ile',function( event)
    {
        if ( event.which == 13 )
        {
            var id = this.id.substr( 4, 1 );
            var id_poka = this.id.substr(6);
            var ile = $(this).val();
            training(id, ile, id_poka);
        }
    });
    $('#prawo').on('click', '.atak', function()
    {
        if (!($(this).hasClass('disabled'))){
            var pokemonId = $(this).attr('data-id-poka');
            var nr = $('input[name=zmien_atak_'+pokemonId+']:checked').val();
            var params = {
                'id'  : pokemonId,
                'attackId' : this.id,
                'whichChange' : nr
            };
            if(nr)
            {
                $.ajax({
                    type: "POST",
                    url: changeAttackHref,
                    data: params
                }).done(function(msg){
                    $('#prawo').html(msg);
                    $('#tabelka').load(leftHref);
                });
            }
            else alert('Najpierw zaznacz, zamiast którego ataku nauczyć nowego!');



        }
        else alert('Nie możesz nauczyć pokemona tego ataku!');
    });
  
  /*$('#sala_treningowa').on('click','.naucz',function( event)
  {
      var id = this.id;
      var id_p = $('#id_poka').text();
      var zm = $('#zmien_atak_'+id).val();
      $('#sala_treningowa').html(lad).load('sala_rysuj.php?id_ataku='+id+'&zmien_atak='+zm+'&id='+id_p);
  });*/
});
