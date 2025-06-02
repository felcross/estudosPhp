document.addEventListener('DOMContentLoaded', function () {
    var modalEditarProduto = document.getElementById('modalEditarProduto');
    if (modalEditarProduto) {
        modalEditarProduto.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Botão que acionou o modal

            // Extrai informações dos atributos data-* do BOTÃO
            var produtoId = button.getAttribute('data-id_produto');
            var codigobarra = button.getAttribute('data-codigobarra');
            var qtdMaxArmazenagem = button.getAttribute('data-qtd_max_armazenagem');
            var local = button.getAttribute('data-local');
            var local2 = button.getAttribute('data-local2');
            var local3 = button.getAttribute('data-local3');
       
            // Extrai os valores dos campos hidden (referência, referência2 e nome)
            var ref = button.getAttribute('data-referencia');
            var ref2 = button.getAttribute('data-referencia2');
            var nome = button.getAttribute('data-nome');

            // Seleciona os elementos do modal
            var modalNomeProduto = modalEditarProduto.querySelector('#modalNomeProduto');
            var modalIdProdutoInput = modalEditarProduto.querySelector('#modalIdProduto');
            var modalCodigoInternoInput = modalEditarProduto.querySelector('#modalCodigoInterno');
            var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
            var modalQtdMaxArmazenagemInput = modalEditarProduto.querySelector('#modalQtdMaxArmazenagem');
            var modalLocalInput = modalEditarProduto.querySelector('#modalLocal');
            var modalLocal2Input = modalEditarProduto.querySelector('#modalLocal2');
            var modalLocal3Input = modalEditarProduto.querySelector('#modalLocal3');

            // Campos hidden para envio dos dados
            var modalRef = modalEditarProduto.querySelector('#modalReferencia');
            var modalRef2 = modalEditarProduto.querySelector('#modalReferencia2');
            var modalNome = modalEditarProduto.querySelector('#modalNome');

            // Campos de exibição readonly para mostrar referências
            var modalReferenciaDisplay = modalEditarProduto.querySelector('#modalReferenciaDisplay');
            var modalReferencia2Display = modalEditarProduto.querySelector('#modalReferencia2Display');

            // Atualiza o título do modal com o nome do produto
            if (modalNomeProduto) {
                modalNomeProduto.textContent = nome || 'Sem título';
            }

            // Preenche os campos básicos do modal
            if (modalIdProdutoInput) modalIdProdutoInput.value = produtoId;
            if (modalCodigoInternoInput) modalCodigoInternoInput.value = produtoId;
            if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
            if (modalQtdMaxArmazenagemInput) modalQtdMaxArmazenagemInput.value = qtdMaxArmazenagem;
            if (modalLocalInput) modalLocalInput.value = local;
            if (modalLocal2Input) modalLocal2Input.value = local2;
            if (modalLocal3Input) modalLocal3Input.value = local3;

            // Preenche os campos hidden
            if (modalRef) modalRef.value = ref || '';
            if (modalRef2) modalRef2.value = ref2 || '';
            if (modalNome) modalNome.value = nome || 'Sem título';

            // Preenche os campos de exibição readonly
            if (modalReferenciaDisplay) modalReferenciaDisplay.value = ref || '';
            if (modalReferencia2Display) modalReferencia2Display.value = ref2 || '';
        });
    }

    // Função para mostrar mensagens flash
    function showFlashMessage(message, type = 'success') {
        const flashContainer = document.getElementById('flashMessages');
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
        
        const flashHTML = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${type === 'success' ? 'Sucesso!' : 'Erro!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        flashContainer.innerHTML = flashHTML;
        
        // Remove a mensagem automaticamente após 5 segundos
        setTimeout(() => {
            const alert = flashContainer.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, 5000);
        
        // Faz scroll suave para o topo para mostrar a mensagem
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Função para atualizar a linha da tabela com os novos dados
    function updateTableRow(rowIndex, newData) {
        const row = document.getElementById(`produto-row-${rowIndex}`);
        if (row) {
            // Atualiza as células da tabela com os novos valores
            const codigoBarraCell = row.querySelector('.cell-produto-codigobarra');
            const qtdMaxCell = row.querySelector('.cell-produto-qtd_max_armazenagem');
            const localCell = row.querySelector('.cell-produto-local');
            const local2Cell = row.querySelector('.cell-produto-local2');
            const local3Cell = row.querySelector('.cell-produto-local3');
            
            if (codigoBarraCell) codigoBarraCell.textContent = newData.codigobarra;
            if (qtdMaxCell) qtdMaxCell.textContent = newData.qtd_max_armazenagem;
            if (localCell) localCell.textContent = newData.local;
            if (local2Cell) local2Cell.textContent = newData.local2;
            if (local3Cell) local3Cell.textContent = newData.local3;

            // Atualiza também os data-attributes do botão editar
            const editButton = row.querySelector('.btn-editar-produto');
            if (editButton) {
                editButton.setAttribute('data-codigobarra', newData.codigobarra);
                editButton.setAttribute('data-qtd_max_armazenagem', newData.qtd_max_armazenagem);
                editButton.setAttribute('data-local', newData.local);
                editButton.setAttribute('data-local2', newData.local2);
                editButton.setAttribute('data-local3', newData.local3);
            }
        }
    }

    $(document).ready(function () {
        // AJAX submission para salvar alterações
        $(document).on("click", '#btnSalvarAlteracoes', function (e) {
            e.preventDefault();

            // Mostra spinner no botão e desabilita
            const btnSalvar = $(this);
            const spinner = btnSalvar.find('.spinner-border');
            const btnText = btnSalvar.find('.btn-text');
            
            btnSalvar.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('Salvando...');

            // Coleta os dados do formulário
            let formData = {
                'PUT': true,
                'produto_id': $('#modalIdProduto').val(),
                'codigobarra': $('#modalCodigoBarras').val(),
                'qtd_max_armazenagem': $('#modalQtdMaxArmazenagem').val(),
                'local': $('#modalLocal').val(),
                'local2': $('#modalLocal2').val(),
                'local3': $('#modalLocal3').val(),


                'referencia': $('#modalReferencia').val(),
                'referencia2': $('#modalReferencia2').val(),
                'nome': $('#modalNome').val()
            };

            // Envia a requisição AJAX
            $.post(window.location.href, {
                ...formData,
                token: $('#token').val(),
            })
            .done(function (data) {
                // Sucesso - mostra mensagem e fecha modal
                const nomeProduto = $('#modalNome').val() || 'Sem título';
                showFlashMessage(`Produto "${nomeProduto}" foi atualizado com sucesso!`, 'success');
                
                // Atualiza a linha da tabela com os novos dados
                const rowIndex = $('#modalRowIndex').val();
                if (rowIndex !== undefined && rowIndex !== '') {
                    updateTableRow(rowIndex, {
                        codigobarra: formData.codigobarra,
                        qtd_max_armazenagem: formData.qtd_max_armazenagem,
                        local: formData.local,
                        local2: formData.local2,
                        local3: formData.local3
                    });
                }
                
                // Fecha o modal
                //$('#modalEditarProduto').modal('hide');

                // CORREÇÃO: Fecha o modal corretamente removendo o backdrop
                const modalElement = document.getElementById('modalEditarProduto');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
                
                // Remove manualmente o backdrop se ainda estiver presente
                setTimeout(() => {
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    // Remove a classe modal-open do body
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('overflow');
                    document.body.style.removeProperty('padding-right');
                }, 100);
            })
            .fail(function (xhr, status, error) {
                // Erro - mostra mensagem de erro
                console.error('Erro ao salvar:', error);
                showFlashMessage('Ocorreu um erro ao tentar salvar as alterações. Tente novamente.', 'error');
            })
            .always(function () {
                // Restaura o estado original do botão
                btnSalvar.prop('disabled', false);
                spinner.addClass('d-none');
                btnText.text('Salvar Alterações');
            });
        });
    });
});






// document.addEventListener('DOMContentLoaded', function () {
//     var modalEditarProduto = document.getElementById('modalEditarProduto');
//     if (modalEditarProduto) {
//         modalEditarProduto.addEventListener('show.bs.modal', function (event) {
//             var button = event.relatedTarget; // Botão que acionou o modal

//             // Extrai informações dos atributos data-* do BOTÃO
//             // Mantendo os mesmos nomes de atributos do código original
//             var produtoId = button.getAttribute('data-id_produto'); // Vem de $produto['PRODUTO']
//             var codigobarra = button.getAttribute('data-codigobarra');
//             var qtdMaxArmazenagem = button.getAttribute('data-qtd_max_armazenagem');
//             var local = button.getAttribute('data-local');
//             var local2 = button.getAttribute('data-local2');
//             var local3 = button.getAttribute('data-local3');
       
//             // Extrai os valores dos campos hidden (referência, referência2 e nome)
//             var ref = button.getAttribute('data-referencia');
//             var ref2 = button.getAttribute('data-referencia2');
//             var nome = button.getAttribute('data-nome');

//             // Atualiza o conteúdo do modal - Seleciona os inputs pelos seus IDs
//             var modalTitle = modalEditarProduto.querySelector('.modal-title');
//             var modalNomeProduto = modalEditarProduto.querySelector('#modalNomeProduto'); // Span para exibir nome no título
//             var modalIdProdutoInput = modalEditarProduto.querySelector('#modalIdProduto'); // Hidden input for ID
//             var modalCodigoInternoInput = modalEditarProduto.querySelector('#modalCodigoInterno'); // Display only

//             var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
//             var modalQtdMaxArmazenagemInput = modalEditarProduto.querySelector('#modalQtdMaxArmazenagem');
//             var modalLocalInput = modalEditarProduto.querySelector('#modalLocal');
//             var modalLocal2Input = modalEditarProduto.querySelector('#modalLocal2');
//             var modalLocal3Input = modalEditarProduto.querySelector('#modalLocal3');

//             // Campos hidden para envio dos dados
//             var modalRef = modalEditarProduto.querySelector('#modalReferencia');
//             var modalRef2 = modalEditarProduto.querySelector('#modalReferencia2');
//             var modalNome = modalEditarProduto.querySelector('#modalNome');

//             // Campos de exibição readonly para mostrar referências
//             var modalReferenciaDisplay = modalEditarProduto.querySelector('#modalReferenciaDisplay');
//             var modalReferencia2Display = modalEditarProduto.querySelector('#modalReferencia2Display');

//             // Atualiza o título do modal com o nome do produto em vez do código
//             if (modalNomeProduto) {
//                 modalNomeProduto.textContent = nome || 'Sem título'; // Usa nome do produto
//             }

//             // Preenche os campos básicos do modal
//             if (modalIdProdutoInput) modalIdProdutoInput.value = produtoId;
//             if (modalCodigoInternoInput) modalCodigoInternoInput.value = produtoId; // Código interno é o próprio ID do produto
//             if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
//             if (modalQtdMaxArmazenagemInput) modalQtdMaxArmazenagemInput.value = qtdMaxArmazenagem;
//             if (modalLocalInput) modalLocalInput.value = local;
//             if (modalLocal2Input) modalLocal2Input.value = local2;
//             if (modalLocal3Input) modalLocal3Input.value = local3;

//             // Preenche os campos hidden com os valores das referências e nome
//             if (modalRef) modalRef.value = ref || ''; // Garante que não seja null/undefined
//             if (modalRef2) modalRef2.value = ref2 || ''; // Garante que não seja null/undefined
//             if (modalNome) modalNome.value = nome || 'Sem título'; // Garante que não seja null/undefined

//             // Preenche os campos de exibição readonly para mostrar as referências
//             if (modalReferenciaDisplay) modalReferenciaDisplay.value = ref || ''; // Campo readonly para exibir referência
//             if (modalReferencia2Display) modalReferencia2Display.value = ref2 || ''; // Campo readonly para exibir referência2
//         });
//     }

//     $(document).ready(function () {
//         // AJAX submission - Alterado para seguir o padrão do que está funcionando
//         $(document).on("click", '#btnSalvarAlteracoes', function (e) {
//             e.preventDefault();

//             // Monta o objeto formData seguindo o padrão do código que funciona
//             // Inclui também os valores hidden (referência, referência2 e nome) caso sejam necessários no backend
//             let formData = {
//                 'PUT': true,
//                 'produto_id': $('#modalIdProduto').val(),
//                 'codigobarra': $('#modalCodigoBarras').val(),
//                 'qtd_max_armazenagem': $('#modalQtdMaxArmazenagem').val(),
//                 'local': $('#modalLocal').val(),
//                 'local2': $('#modalLocal2').val(),
//                 'local3': $('#modalLocal3').val(),
//                 // Adiciona os campos hidden no envio (caso o backend precise)
//               //  'referencia': $('#modalReferencia').val(),
//               //  'referencia2': $('#modalReferencia2').val(),
//               //  'nome': $('#modalNome').val()
//             };

//             // Mantém a mesma estrutura de envio que funciona
//             $.post(window.location.href, {
//                 ...formData,
//                 token: $('#token').val(),
//             },
//                 function (data) {
//                     console.log(data);
//                 });
//         });
//     });

//     /////////

//     // $(document).on("submit", 'form[type="busc"]', function (i) {

//     //     i.preventDefault();

//     //     let url = new URLSearchParams(window.location.search);

//     //     let v = '?uri=' + url.get('uri') + '&termo=' + $('input[name="termo"]').val();

//     //     location.href = v;

//     //     const ahref = setInterval(() => {

//     //         if ($('a[type="busc"]')) {
//     //             $('a[type="busc"]').attr('href', v);
//     //             clearInterval(ahref);
//     //         }

//     //     }, 1000);

//     // })

// });