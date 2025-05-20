document.addEventListener('DOMContentLoaded', function () {
    var modalEditarProduto = document.getElementById('modalEditarProduto');
    if (modalEditarProduto) {
        modalEditarProduto.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Botão que acionou o modal

            // Extrai informações dos atributos data-* do BOTÃO
            // Estes nomes devem corresponder EXATAMENTE aos data-* no HTML do botão
            var produtoId = button.getAttribute('data-id_produto'); // Vem de $produto['PRODUTO']
            var descricao = button.getAttribute('data-descricao');
            var codigobarra = button.getAttribute('data-codigobarra');
            var qtdMaxArmazenagem = button.getAttribute('data-qtd_max_armazenagem');
            var local = button.getAttribute('data-local');
            var local2 = button.getAttribute('data-local2');
            var local3 = button.getAttribute('data-local3');
            // var rowIndex = button.getAttribute('data-row-index'); // Se precisar atualizar a linha na tabela depois

            // Atualiza o conteúdo do modal - Seleciona os inputs pelos seus IDs
            var modalTitle = modalEditarProduto.querySelector('.modal-title');
            var modalIdProdutoInput = modalEditarProduto.querySelector('#modalIdProduto'); // Hidden input for ID
            var modalCodigoInternoInput = modalEditarProduto.querySelector('#modalCodigoInterno'); // Display only
            var modalDescricaoInput = modalEditarProduto.querySelector('#modalDescricao');
            var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
            var modalQtdMaxArmazenagemInput = modalEditarProduto.querySelector('#modalQtdMaxArmazenagem');
            var modalLocalInput = modalEditarProduto.querySelector('#modalLocal');
            var modalLocal2Input = modalEditarProduto.querySelector('#modalLocal2');
            var modalLocal3Input = modalEditarProduto.querySelector('#modalLocal3');
            // var modalRowIndexInput = modalEditarProduto.querySelector('#modalRowIndex');


            modalTitle.textContent = 'Editar Produto: ' + produtoId; // Usa produtoId que é o código interno
            if (modalIdProdutoInput) modalIdProdutoInput.value = produtoId;
            if (modalCodigoInternoInput) modalCodigoInternoInput.value = produtoId; // Código interno é o próprio ID do produto
            if (modalDescricaoInput) modalDescricaoInput.value = descricao;
            if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
            if (modalQtdMaxArmazenagemInput) modalQtdMaxArmazenagemInput.value = qtdMaxArmazenagem;
            if (modalLocalInput) modalLocalInput.value = local;
            if (modalLocal2Input) modalLocal2Input.value = local2;
            if (modalLocal3Input) modalLocal3Input.value = local3;
            // if (modalRowIndexInput) modalRowIndexInput.value = rowIndex;
        });
    }

    $(document).ready(function () {
    // AJAX submission
    $(document).on("click", '#btnSalvarAlteracoes', function (e) {
        e.preventDefault();

        // Monta o objeto formData. As chaves aqui DEVEM CORRESPONDER
        // aos atributos 'name' dos inputs no modal E ao que o PHP espera em $_POST.
        let formData = {
            'PUT': true, // Sinalizador para o controller
            'id_produto': $('#modalIdProduto').val(), // ID do produto para atualização
            'descricao': $('#modalDescricao').val(),
            'CODIGOBARRA': $('#modalCodigoBarras').val(), // Note a capitalização, conforme 'name' no HTML
            'QTD_MAX_ARMAZENAGEM': $('#modalQtdMaxArmazenagem').val(), // Note a capitalização
            'LOCAL': $('#modalLocal').val(), // Note a capitalização
            'LOCAL2': $('#modalLocal2').val(), // Note a capitalização
            'LOCAL3': $('#modalLocal3').val()  // Note a capitalização
            // 'codigo_interno' não é enviado pois é readonly e o 'id_produto' já é o identificador.
        };

         $.post(window.location.href, {
                ...formData,
                token: $('#token').val(),},
                function (data) {
                    console.log(data);
                }

            );


      
    });
})});