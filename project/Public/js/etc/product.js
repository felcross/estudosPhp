document.addEventListener('DOMContentLoaded', function () {
    var modalEditarProduto = document.getElementById('modalEditarProduto');
    if (modalEditarProduto) {
        modalEditarProduto.addEventListener('show.bs.modal', function (event) {
            // Botão que acionou o modal
            var button = event.relatedTarget;

            // Extrai informações dos atributos data-*
            var produtoId = button.getAttribute('data-id'); // O ID original do produto
            var codigo = button.getAttribute('data-codigo');
            var descricao = button.getAttribute('data-descricao');
            var referencia = button.getAttribute('data-referencia');
            var referencia2 = button.getAttribute('data-referencia2');
            var codigobarra = button.getAttribute('data-codigobarra');
            var preco = button.getAttribute('data-preco');

            // Atualiza o conteúdo do modal
            var modalTitle = modalEditarProduto.querySelector('.modal-title');
            var modalProdutoIdInput = modalEditarProduto.querySelector('#modalProdutoId');
            var modalCodigoInput = modalEditarProduto.querySelector('#modalCodigo');
            var modalDescricaoInput = modalEditarProduto.querySelector('#modalDescricao');
            var modalReferenciaInput = modalEditarProduto.querySelector('#modalReferencia');
            var modalReferencia2Input = modalEditarProduto.querySelector('#modalReferencia2');
            var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
            var modalPrecoInput = modalEditarProduto.querySelector('#modalPreco');

            modalTitle.textContent = 'Editar Produto: ' + codigo;
            if (modalProdutoIdInput) modalProdutoIdInput.value = produtoId; // ID para submissão
            if (modalCodigoInput) modalCodigoInput.value = codigo;
            if (modalDescricaoInput) modalDescricaoInput.value = descricao;
            if (modalReferenciaInput) modalReferenciaInput.value = referencia;
            if (modalReferencia2Input) modalReferencia2Input.value = referencia2;
            if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
            if (modalPrecoInput) modalPrecoInput.value = parseFloat(preco).toFixed(2);


        });
    }


    // Replace your current AJAX code with this:
    $(document).ready(function () {
        // Existing modal code remains the same...

        // Fix the AJAX submission
        $(document).on("click", '#btnSalvarAlteracoes', function (e) {
            e.preventDefault();

            // Create a proper object with the form data
            let formData = {
                'PUT': true,
                'produto_id': $('#modalProdutoId').val(), 
                'codigo_produto': $('#modalCodigo').val(), 
                'descricao': $('#modalDescricao').val(),
                'referencia': $('#modalReferencia').val(),
                'referencia2': $('#modalReferencia2').val(),
                'codigobarra': $('#modalCodigoBarras').val(),
                'preco': $('#modalPreco').val()
            };

            // Send the AJAX request with proper content type and data format


            $.post(window.location.href, {
                ...formData,
                token: $('#token').val(),
               // action: 'product'
            },
                function (data) {
                    console.log(data);
                }

            );



        });
    });



});