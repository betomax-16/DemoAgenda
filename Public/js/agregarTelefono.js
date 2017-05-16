$(document).ready(function () {
  $('#Add').click(function (event) {
    event.preventDefault();
    $( "tbody" ).append('<tr><td><input type="tel" name="telefonosN[]"></td><td><input type="text" name="descripcionesN[]"></td><td><a class="temporal" href="#">Eliminar</a></td></tr>');
  });

  $('tbody').on('click', '.temporal', function (event) {
    event.preventDefault();
    $(this).parent().parent().remove();
  });
});
