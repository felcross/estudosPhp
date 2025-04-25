$(document).ready(function () {


   $(document).on('submit', 'form', function (e) {

      e.preventDefault();
      let valores = {};
      $(this).find('input').each(function (index, element) {
         valores[$(element).attr('id')] = $(element).val();
      });


      $.post("/project/Src/Model/post.php",
         valores,
         function (data, textStatus) {
           alert("Sucesso");
         }
      );


   })



});