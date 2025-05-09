// $(document).ready(function () {

//     $(document).on("click", "#buscar", function (e) {

//         e.preventDefault();

//         var termo = $("input[name='termo']").val();


//         $.post('../public/index.php?', {
//             termo: termo,
//             token: $('#token').val(),
//             ajax: true // Adicionar um indicador que é uma requisição AJAX

//         },
//             function (data) {
//                 console.log(termo);
//             },

//         );


//     })
// });


// $(document).ready(function(){
//     $('#buscar').on('click', function(e){
//       e.preventDefault();
  
//       const termo = $("input[name='termo']").val();
//       const token = $('#token').val();
//       const parcial = $("input[name='buscaParcial']").is(':checked') ? 1 : 0;
  
//       $.ajax({
//         url: '../public/index.php?product/search',
//         method: 'POST',
//         dataType: 'json',
//         data: {
//           termo: termo,
//           token: token,
//           buscaParcial: parcial,
//           ajax: true
//         },
//         success: function(produtos){
//           // limpa e renderiza cards ou lista
//           let html = '';
//           if (produtos.length === 0) {
//             html = '<p>Nenhum produto encontrado.</p>';
//           } else {
//             produtos.forEach(p => {
//               html += `
//                 <div class="card mb-2">
//                   <div class="card-body">
//                     <h5 class="card-title">${p.nome}</h5>
//                     <p class="card-text">Código: ${p.codigo}</p>
//                     <!-- ajuste conforme o retorno da sua API -->
//                   </div>
//                 </div>
//               `;
//             });
//           }
//           $('#resultados').html(html);
//         },
//         error: function(xhr){
//           console.error('Erro AJAX:', xhr.responseText);
//         }
//       });
//     });
//  });
  



