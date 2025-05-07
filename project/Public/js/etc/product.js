// $(document).ready(function() {
//     // Quando o botão buscar for clicado
//     $("#buscar").click(function(e) {
//         e.preventDefault(); // Previne o envio padrão do formulário
        
//         // Pega o valor do campo de busca
//         var termo = $("input[name='termo']").val();
        
//         // Redireciona para a URL com o parâmetro de busca
//         window.location.href = "index.php?" + encodeURIComponent(termo);
//     });

// });


$(document).ready(function() {
    // Quando o formulário for submetido
    $("form").submit(function(e) {
        e.preventDefault(); // Previne o envio padrão do formulário
        
        // Pega o valor do campo de busca
        var termo = $("input[name='termo']").val();
        
        // Faz a requisição POST via jQuery AJAX
        $.post("index.php?", { termo: termo }, function(data) {

        
       
           
            window.location.reload();
        });
    });
});