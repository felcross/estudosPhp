document.addEventListener('DOMContentLoaded', function () {
    var modalEditarProduto = document.getElementById('modalEditarProduto');
    if (modalEditarProduto) {
        modalEditarProduto.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Botão que acionou o modal

            // Extrai informações dos atributos data-* do BOTÃO
            // Mantendo os mesmos nomes de atributos do código original que não funciona
            var produtoId = button.getAttribute('data-id_produto'); // Vem de $produto['PRODUTO']

            var codigobarra = button.getAttribute('data-codigobarra');
            var qtdMaxArmazenagem = button.getAttribute('data-qtd_max_armazenagem');
            var local = button.getAttribute('data-local');
            var local2 = button.getAttribute('data-local2');
            var local3 = button.getAttribute('data-local3');

            // Atualiza o conteúdo do modal - Seleciona os inputs pelos seus IDs
            var modalTitle = modalEditarProduto.querySelector('.modal-title');
            var modalIdProdutoInput = modalEditarProduto.querySelector('#modalIdProduto'); // Hidden input for ID
            var modalCodigoInternoInput = modalEditarProduto.querySelector('#modalCodigoInterno'); // Display only

            var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
            var modalQtdMaxArmazenagemInput = modalEditarProduto.querySelector('#modalQtdMaxArmazenagem');
            var modalLocalInput = modalEditarProduto.querySelector('#modalLocal');
            var modalLocal2Input = modalEditarProduto.querySelector('#modalLocal2');
            var modalLocal3Input = modalEditarProduto.querySelector('#modalLocal3');

            modalTitle.textContent = 'Editar Produto: ' + produtoId; // Usa produtoId que é o código interno
            if (modalIdProdutoInput) modalIdProdutoInput.value = produtoId;
            if (modalCodigoInternoInput) modalCodigoInternoInput.value = produtoId; // Código interno é o próprio ID do produto

            if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
            if (modalQtdMaxArmazenagemInput) modalQtdMaxArmazenagemInput.value = qtdMaxArmazenagem;
            if (modalLocalInput) modalLocalInput.value = local;
            if (modalLocal2Input) modalLocal2Input.value = local2;
            if (modalLocal3Input) modalLocal3Input.value = local3;
        });
    }

    $(document).ready(function () {
        // AJAX submission - Alterado para seguir o padrão do que está funcionando
        $(document).on("click", '#btnSalvarAlteracoes', function (e) {
            e.preventDefault();

            // Monta o objeto formData seguindo o padrão do código que funciona
            let formData = {
                'PUT': true,
                'produto_id': $('#modalIdProduto').val(),

                'codigobarra': $('#modalCodigoBarras').val(),
                'qtd_max_armazenagem': $('#modalQtdMaxArmazenagem').val(),
                'local': $('#modalLocal').val(),
                'local2': $('#modalLocal2').val(),
                'local3': $('#modalLocal3').val()
            };

            // Mantém a mesma estrutura de envio que funciona
            $.post(window.location.href, {
                ...formData,
                token: $('#token').val(),
            },
                function (data) {
                    console.log(data);
                });
        });
    });
});











































// document.addEventListener('DOMContentLoaded', function () {
//     var modalEditarProduto = document.getElementById('modalEditarProduto');
//     if (modalEditarProduto) {
//         modalEditarProduto.addEventListener('show.bs.modal', function (event) {
//             // Botão que acionou o modal
//             var button = event.relatedTarget;

//             // Extrai informações dos atributos data-*
//             var produtoId = button.getAttribute('data-id'); // O ID original do produto
//             var codigo = button.getAttribute('data-codigo');
//             var descricao = button.getAttribute('data-descricao');
//             var referencia = button.getAttribute('data-referencia');
//             var referencia2 = button.getAttribute('data-referencia2');
//             var codigobarra = button.getAttribute('data-codigobarra');
//             var preco = button.getAttribute('data-preco');

//             // Atualiza o conteúdo do modal
//             var modalTitle = modalEditarProduto.querySelector('.modal-title');
//             var modalProdutoIdInput = modalEditarProduto.querySelector('#modalProdutoId');
//             var modalCodigoInput = modalEditarProduto.querySelector('#modalCodigo');
//             var modalDescricaoInput = modalEditarProduto.querySelector('#modalDescricao');
//             var modalReferenciaInput = modalEditarProduto.querySelector('#modalReferencia');
//             var modalReferencia2Input = modalEditarProduto.querySelector('#modalReferencia2');
//             var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
//             var modalPrecoInput = modalEditarProduto.querySelector('#modalPreco');

//             modalTitle.textContent = 'Editar Produto: ' + codigo;
//             if (modalProdutoIdInput) modalProdutoIdInput.value = produtoId; // ID para submissão
//             if (modalCodigoInput) modalCodigoInput.value = codigo;
//             if (modalDescricaoInput) modalDescricaoInput.value = descricao;
//             if (modalReferenciaInput) modalReferenciaInput.value = referencia;
//             if (modalReferencia2Input) modalReferencia2Input.value = referencia2;
//             if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
//             if (modalPrecoInput) modalPrecoInput.value = parseFloat(preco).toFixed(2);


//         });
//     }


//     // Replace your current AJAX code with this:
//     $(document).ready(function () {
//         // Existing modal code remains the same...

//         // Fix the AJAX submission
//         $(document).on("click", '#btnSalvarAlteracoes', function (e) {
//             e.preventDefault();

//             // Create a proper object with the form data
//             let formData = {
//                 'PUT': true,
//                 'produto_id': $('#modalProdutoId').val(),
//                 'codigo_produto': $('#modalCodigo').val(),
//                 'descricao': $('#modalDescricao').val(),
//                 'referencia': $('#modalReferencia').val(),
//                 'referencia2': $('#modalReferencia2').val(),
//                 'codigobarra': $('#modalCodigoBarras').val(),
//                 'preco': $('#modalPreco').val()
//             };

//             // Send the AJAX request with proper content type and data format


//             $.post(window.location.href, {
//                 ...formData,
//                 token: $('#token').val(),},
//                 function (data) {
//                     console.log(data);
//                 }

//             );



//         });
//     });



// });