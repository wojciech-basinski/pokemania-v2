$(document).ready(function() {
  $('.stow').click(function()
  {
  	window.location=$('.stow').attr('href');
  });
  $(document).on('click', '.pok_modal', function()
  {
      var url = pokemonInfoHref.replace("replace", $(this).attr("data-id"));
      $('.modal-body').load(url+'?modal=1');
      $('#pokemon_modal').modal("show");
  });
  $('#prawo').on('click', '.um', function()
  {
      var params = {
        'i' : $(this).attr('data-skill')
      };
      $.ajax({
          type: "POST",
          url: pointsHref,
          params: params
      }).done(function(msg) {
          $('#prawo').html(msg);
          $('#tabelka').load(leftHref);
      });
  });
  $('#prawo').on('click', '.dodaj', function()
  {
      $('#zaproszenie').load($(this).attr('data-href'));
  });
});