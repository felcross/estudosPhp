
$(document).ready(function() {
  $('#busca').on('keyup', function() {
    var valorBusca = $(this).val().toLowerCase();
    $('#tabelaProdutos tbody tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(valorBusca) > -1)
    });
  });
});