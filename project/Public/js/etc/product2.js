// Espera o DOM estar completamente carregado para executar o script.
document.addEventListener('DOMContentLoaded', function () {
    // Seleciona o elemento do modal de edição de produto.
    var modalEditarProduto = document.getElementById('modalEditarProduto');

    // Verifica se o elemento do modal existe na página.
    if (modalEditarProduto) {
        // Adiciona um ouvinte de evento para quando o modal estiver prestes a ser exibido.
        // 'show.bs.modal' é um evento específico dos modais do Bootstrap.
        modalEditarProduto.addEventListener('show.bs.modal', function (event) {
            // 'event.relatedTarget' é o elemento que acionou o modal (neste caso, o botão "Editar").
            var button = event.relatedTarget;

            // Extrai o índice da linha da tabela armazenado no atributo 'data-row-index' do botão.
            // Este índice é crucial para saber qual linha da tabela atualizar posteriormente.
            var rowIndex = button.getAttribute('data-row-index');

            // Extrai todas as informações do produto dos atributos 'data-*' do botão.
            var produtoId = button.getAttribute('data-id_produto');
            var codigobarra = button.getAttribute('data-codigobarra');
            var qtdMaxArmazenagem = button.getAttribute('data-qtd_max_armazenagem');
            var local = button.getAttribute('data-local');
            var local2 = button.getAttribute('data-local2');
            var local3 = button.getAttribute('data-local3');
            var ref = button.getAttribute('data-referencia');
            var ref2 = button.getAttribute('data-referencia2');
            var nome = button.getAttribute('data-nome');

            // Seleciona os elementos de input e display dentro do modal onde os dados do produto serão mostrados/editados.
            var modalNomeProduto = modalEditarProduto.querySelector('#modalNomeProduto');
            var modalIdProdutoInput = modalEditarProduto.querySelector('#modalIdProduto');
            var modalCodigoInternoInput = modalEditarProduto.querySelector('#modalCodigoInterno');
            var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
            var modalQtdMaxArmazenagemInput = modalEditarProduto.querySelector('#modalQtdMaxArmazenagem');
            var modalLocalInput = modalEditarProduto.querySelector('#modalLocal');
            var modalLocal2Input = modalEditarProduto.querySelector('#modalLocal2');
            var modalLocal3Input = modalEditarProduto.querySelector('#modalLocal3');

            // Campos hidden que também precisam ser preenchidos (alguns podem ser redundantes se já extraídos).
            var modalRef = modalEditarProduto.querySelector('#modalReferencia');
            var modalRef2 = modalEditarProduto.querySelector('#modalReferencia2');
            var modalNome = modalEditarProduto.querySelector('#modalNome'); // Para o nome do produto no formulário

            // Campo hidden para armazenar o índice da linha (ADICIONADO NO PASSO 1)
            var modalRowIndexInput = modalEditarProduto.querySelector('#modalRowIndex');

            // Campos de exibição readonly.
            var modalReferenciaDisplay = modalEditarProduto.querySelector('#modalReferenciaDisplay');
            var modalReferencia2Display = modalEditarProduto.querySelector('#modalReferencia2Display');

            // === Preenche os campos do modal com os dados do produto ===

            // Atualiza o título do modal.
            if (modalNomeProduto) {
                modalNomeProduto.textContent = nome || 'Sem título';
            }

            // Preenche os campos de input visíveis.
            if (modalIdProdutoInput) modalIdProdutoInput.value = produtoId;
            if (modalCodigoInternoInput) modalCodigoInternoInput.value = produtoId; // Geralmente o ID é usado como cód. interno readonly
            if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
            if (modalQtdMaxArmazenagemInput) modalQtdMaxArmazenagemInput.value = qtdMaxArmazenagem;
            if (modalLocalInput) modalLocalInput.value = local;
            if (modalLocal2Input) modalLocal2Input.value = local2;
            if (modalLocal3Input) modalLocal3Input.value = local3;

            // Preenche os campos hidden.
            if (modalRef) modalRef.value = ref || '';
            if (modalRef2) modalRef2.value = ref2 || '';
            if (modalNome) modalNome.value = nome || 'Sem título'; // Garante que o nome seja enviado no form

            // Preenche o campo hidden com o índice da linha.
            if (modalRowIndexInput) {
                modalRowIndexInput.value = rowIndex;
            }

            // Preenche os campos de exibição readonly.
            if (modalReferenciaDisplay) modalReferenciaDisplay.value = ref || '';
            if (modalReferencia2Display) modalReferencia2Display.value = ref2 || '';
        });
    }

    // Função para exibir mensagens flash (feedback para o usuário).
    // message: A mensagem a ser exibida.
    // type: 'success' ou 'error' (ou outro tipo que seu CSS suporte).
    function showFlashMessage(message, type = 'success') {
        const flashContainer = document.getElementById('flashMessages');
        if (!flashContainer) {
            console.error('Elemento #flashMessages não encontrado.');
            return;
        }

        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        // Você pode adicionar mais classes de ícone se quiser (ex: Bootstrap Icons)
        // const iconClass = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';

        const flashHTML = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${type === 'success' ? 'Sucesso!' : 'Erro!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        flashContainer.innerHTML = flashHTML; // Substitui qualquer mensagem anterior.

        // Remove a mensagem automaticamente após 4 segundos.
        setTimeout(() => {
            const alert = flashContainer.querySelector('.alert');
            if (alert && alert.classList.contains('show')) {
                // Inicia o fade out do Bootstrap
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 4000);

        // Faz scroll suave para o topo da página para que o usuário veja a mensagem.
        // Útil se a mensagem estiver fora da área visível.
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /**
     * Função para atualizar uma linha específica na tabela HTML com novos dados.
     * @param {string|number} rowIndex - O índice da linha (TR) a ser atualizada.
     * @param {object} newData - Um objeto contendo os novos dados para a linha.
     * Ex: { CODIGOBARRA: '123', QTD_MAX_ARMAZENAGEM: 10, ... }
     */
    function updateTableRow(rowIndex, newData) {
        console.log('=== Iniciando atualização da linha da tabela ===');
        console.log('Índice da Linha (Row Index):', rowIndex);
        console.log('Novos Dados:', newData);

        // Constrói o ID do elemento da linha (<tr>) com base no índice.
        // Certifique-se de que o ID no HTML da linha seja gerado como "produto-row-X".
        const rowId = `produto-row-${rowIndex}`;
        console.log('Procurando por ID da linha:', rowId);

        // Seleciona a linha (TR) pelo seu ID.
        const row = document.getElementById(rowId);
        console.log('Elemento da linha encontrado:', row); // Se for null, o ID está errado ou a linha não existe.

        if (row) {
            // Seleciona as células (TD) dentro da linha que precisam ser atualizadas.
            // É importante que as classes CSS nas células sejam consistentes com as usadas aqui.
            const codigoInternoCell = row.querySelector('.cell-produto-codigo'); // Geralmente não muda, mas pode ser útil
            const codigoBarraCell = row.querySelector('.cell-produto-codigobarra');
            const qtdMaxCell = row.querySelector('.cell-produto-qtd_max_armazenagem');
            const localCell = row.querySelector('.cell-produto-local');
            const local2Cell = row.querySelector('.cell-produto-local2');
            const local3Cell = row.querySelector('.cell-produto-local3');

            console.log('Células encontradas para atualização:');
            console.log('- Cód. Interno:', codigoInternoCell);
            console.log('- Cód. Barras:', codigoBarraCell);
            // ... (log para outras células)

            // Atualiza o conteúdo de texto de cada célula com os novos dados.
            // Usa `newData.NOME_DA_CHAVE || ''` para evitar 'undefined' se um dado não vier.
            if (codigoInternoCell && newData.PRODUTO !== undefined) { // Se o código do produto (ID) também for retornado
                codigoInternoCell.textContent = newData.PRODUTO;
                console.log('✓ Cód. Interno atualizado para:', newData.PRODUTO);
            }
            if (codigoBarraCell && newData.CODIGOBARRA !== undefined) {
                codigoBarraCell.textContent = newData.CODIGOBARRA || '';
                console.log('✓ Código de barras atualizado para:', newData.CODIGOBARRA);
            }
            if (qtdMaxCell && newData.QTD_MAX_ARMAZENAGEM !== undefined) {
                qtdMaxCell.textContent = newData.QTD_MAX_ARMAZENAGEM || '0';
                console.log('✓ Qtd Max atualizada para:', newData.QTD_MAX_ARMAZENAGEM);
            }
            if (localCell && newData.LOCAL !== undefined) {
                localCell.textContent = newData.LOCAL || '';
                console.log('✓ Local atualizado para:', newData.LOCAL);
            }
            if (local2Cell && newData.LOCAL2 !== undefined) {
                local2Cell.textContent = newData.LOCAL2 || '';
                console.log('✓ Local2 atualizado para:', newData.LOCAL2);
            }
            if (local3Cell && newData.LOCAL3 !== undefined) {
                local3Cell.textContent = newData.LOCAL3 || '';
                console.log('✓ Local3 atualizado para:', newData.LOCAL3);
            }

            // Atualiza também os atributos 'data-*' do botão "Editar" dentro desta linha.
            // Isso é importante para que, se o usuário clicar em "Editar" novamente na mesma linha
            // sem recarregar a página, o modal seja preenchido com os dados mais recentes.
            const editButton = row.querySelector('.btn-editar-produto');
            if (editButton) {
                if (newData.CODIGOBARRA !== undefined) editButton.setAttribute('data-codigobarra', newData.CODIGOBARRA || '');
                if (newData.QTD_MAX_ARMAZENAGEM !== undefined) editButton.setAttribute('data-qtd_max_armazenagem', newData.QTD_MAX_ARMAZENAGEM || '0');
                if (newData.LOCAL !== undefined) editButton.setAttribute('data-local', newData.LOCAL || '');
                if (newData.LOCAL2 !== undefined) editButton.setAttribute('data-local2', newData.LOCAL2 || '');
                if (newData.LOCAL3 !== undefined) editButton.setAttribute('data-local3', newData.LOCAL3 || '');
                // Atualize outros data-attributes conforme necessário (referencia, nome, etc.)
                // if (newData.NOME !== undefined) editButton.setAttribute('data-nome', newData.NOME || 'Sem título');
                console.log('✓ Atributos data-* do botão editar atualizados.');
            }

            // Efeito visual para destacar a linha atualizada (opcional).
            // A linha fica com fundo verde claro por 2 segundos.
            row.style.backgroundColor = '#d1e7dd'; // Um verde suave (Bootstrap success background)
            row.style.transition = 'background-color 0.5s ease-in-out';
            setTimeout(() => {
                row.style.backgroundColor = ''; // Remove a cor de fundo, voltando ao normal.
            }, 2500); // Mantém por 2.5 segundos

            console.log('=== ATUALIZAÇÃO DA LINHA CONCLUÍDA ===');
        } else {
            console.error('❌ ERRO: Linha da tabela não encontrada com ID:', rowId);
            // Se você tiver muitos problemas com isso, pode listar todos os IDs para depuração:
            // const allRows = document.querySelectorAll('table tbody tr[id]');
            // console.log('IDs de linha disponíveis:');
            // allRows.forEach(r => console.log('-', r.id));
        }
    }

    /**
 * Função para atualizar um card específico com novos dados (versão mobile).
 * @param {string|number} rowIndex - O índice do card a ser atualizado.
 * @param {object} newData - Um objeto contendo os novos dados para o card.
 */
    function updateProductCard(rowIndex, newData) {
        console.log('=== Iniciando atualização do card ===');
        console.log('Índice do Card (Row Index):', rowIndex);
        console.log('Novos Dados:', newData);

        // Seleciona o card pelo índice (assumindo que você adicione um ID nos cards)
        const cardId = `produto-card-${rowIndex}`;
        console.log('Procurando por ID do card:', cardId);

        const card = document.getElementById(cardId);
        console.log('Elemento do card encontrado:', card);

        if (card) {
            // Atualiza código interno
            const codigoInternoElement = card.querySelector('.code-item .code-value');
            if (codigoInternoElement && newData.PRODUTO !== undefined) {
                codigoInternoElement.textContent = newData.PRODUTO;
            }

            // Atualiza código de barras
            const codigoBarrasElements = card.querySelectorAll('.code-item .code-value');
            if (codigoBarrasElements[1] && newData.CODIGOBARRA !== undefined) {
                codigoBarrasElements[1].textContent = newData.CODIGOBARRA || '';
            }

            // Atualiza quantidade máxima
            const quantityBadge = card.querySelector('.quantity-badge');
            if (quantityBadge && newData.QTD_MAX_ARMAZENAGEM !== undefined) {
                quantityBadge.textContent = newData.QTD_MAX_ARMAZENAGEM || '0';
            }

            // Atualiza locais
            const locationItems = card.querySelectorAll('.location-item');
            if (locationItems[0] && newData.LOCAL !== undefined) {
                locationItems[0].innerHTML = `<span class="location-label">Local 1</span>${newData.LOCAL || ''}`;
                locationItems[0].classList.toggle('empty', !newData.LOCAL);
            }
            if (locationItems[1] && newData.LOCAL2 !== undefined) {
                locationItems[1].innerHTML = `<span class="location-label">Local 2</span>${newData.LOCAL2 || ''}`;
                locationItems[1].classList.toggle('empty', !newData.LOCAL2);
            }
            if (locationItems[2] && newData.LOCAL3 !== undefined) {
                locationItems[2].innerHTML = `<span class="location-label">Local 3</span>${newData.LOCAL3 || ''}`;
                locationItems[2].classList.toggle('empty', !newData.LOCAL3);
            }

            // Atualiza os atributos data-* do botão editar dentro do card
            const editButton = card.querySelector('.btn-editar-produto');
            if (editButton) {
                if (newData.CODIGOBARRA !== undefined) editButton.setAttribute('data-codigobarra', newData.CODIGOBARRA || '');
                if (newData.QTD_MAX_ARMAZENAGEM !== undefined) editButton.setAttribute('data-qtd_max_armazenagem', newData.QTD_MAX_ARMAZENAGEM || '0');
                if (newData.LOCAL !== undefined) editButton.setAttribute('data-local', newData.LOCAL || '');
                if (newData.LOCAL2 !== undefined) editButton.setAttribute('data-local2', newData.LOCAL2 || '');
                if (newData.LOCAL3 !== undefined) editButton.setAttribute('data-local3', newData.LOCAL3 || '');
            }

            // Efeito visual
            card.style.backgroundColor = '#d1e7dd';
            card.style.transition = 'background-color 0.5s ease-in-out';
            setTimeout(() => {
                card.style.backgroundColor = '';
            }, 2500);

            console.log('=== ATUALIZAÇÃO DO CARD CONCLUÍDA ===');
        } else {
            console.error('❌ ERRO: Card não encontrado com ID:', cardId);
        }
    }

    // Código jQuery para a submissão AJAX do formulário de edição.
    // $(document).ready() garante que o jQuery execute após o DOM estar pronto.
    // No seu caso, como está dentro do 'DOMContentLoaded', já é seguro.
    $(document).ready(function () {
        // Delegação de evento para o botão de salvar.
        // Usamos 'on("click", selector, ...)' para botões que podem ser adicionados dinamicamente
        // ou para garantir que funcione mesmo se o modal for complexo.
        // Aqui, como o botão está no modal que já existe, um seletor direto também funcionaria.
        $(document).on("click", '#btnSalvarAlteracoes', function (e) {
            // Previne o comportamento padrão do botão (que poderia ser submeter um formulário tradicional).
            e.preventDefault();

            const btnSalvar = $(this); // O botão que foi clicado.
            const spinner = btnSalvar.find('.spinner-border');
            const btnText = btnSalvar.find('.btn-text');

            // Desabilita o botão e mostra o spinner para feedback visual durante o processamento.
            btnSalvar.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('Salvando...');

            // Coleta os dados do formulário do modal.
            // Certifique-se que os IDs (#modalIdProduto, etc.) correspondem aos seus campos no modal.
            let formData = {
                'PUT': true, // Indicador para o backend que é uma atualização
                'produto_id': $('#modalIdProduto').val(),
                'codigobarra': $('#modalCodigoBarras').val(),
                'qtd_max_armazenagem': $('#modalQtdMaxArmazenagem').val(),
                'local': $('#modalLocal').val(),
                'local2': $('#modalLocal2').val(),
                'local3': $('#modalLocal3').val(),
                'referencia': $('#modalReferencia').val(), // Campo hidden
                'referencia2': $('#modalReferencia2').val(), // Campo hidden
                'nome': $('#modalNome').val(), // Campo hidden para o nome
                // Adicione o token CSRF se seu backend o exigir.
                'csrf_token': $('#csrf_token').val() // ← ADICIONAR ESTA LINHA

            };

            // Recupera o índice da linha que está sendo editada.
            // Este valor foi definido quando o modal foi aberto.
            const rowIndex = $('#modalRowIndex').val();

            // Requisição AJAX usando jQuery.post()
            // window.location.href envia para a URL atual. Ajuste se o endpoint for diferente.
            $.ajax({
                url: window.location.href, // Ou a URL específica do seu controller de atualização
                type: 'POST', // Ou 'PUT' se seu backend estiver configurado para isso (com formData 'PUT': true é uma convenção comum para simular PUT via POST)
                data: formData,
                dataType: 'json', // Espera uma resposta JSON do servidor
                success: function (response) {
                    // Esta função é executada se a requisição for bem-sucedida.
                    // 'response' contém os dados retornados pelo servidor.
                    // É uma boa prática o servidor retornar um JSON como:
                    // { success: true, message: "...", updatedProductData: { ... } }
                    // { success: false, message: "Erro..." }

                    if (response && response.success) {
                        const nomeProduto = formData.nome || 'Produto'; // Usa o nome do formData
                        showFlashMessage(response.message || `"${nomeProduto}" foi atualizado com sucesso!`, 'success');

                        // Verifica se temos um rowIndex válido para atualizar a tabela.
                        if (rowIndex !== undefined && rowIndex !== '') {
                            // Idealmente, 'response.updatedProductData' conteria os dados atualizados
                            // retornados pelo servidor. Se não, usamos os dados do formulário.
                            const dataToUpdate = response.updatedProductData || {
                                PRODUTO: formData.produto_id, // Se o ID também for parte dos dados da linha
                                CODIGOBARRA: formData.codigobarra,
                                QTD_MAX_ARMAZENAGEM: formData.qtd_max_armazenagem,
                                LOCAL: formData.local,
                                LOCAL2: formData.local2,
                                LOCAL3: formData.local3,
                                NOME: formData.nome // Para atualizar o 'data-nome' no botão, se necessário
                                // Adicione outros campos que são exibidos na tabela e podem ter sido alterados
                            };
                            updateTableRow(rowIndex, dataToUpdate);
                            updateProductCard(rowIndex, dataToUpdate); // ADICIONE ESTA LINHA
                        } else {
                            console.warn('Row index não encontrado. A tabela não será atualizada dinamicamente.');
                            // Neste caso, você pode querer recarregar a página ou a tabela inteira
                            // se a atualização da linha específica falhar por falta do índice.
                            // Ex: location.reload(); (mas isso recarrega a página inteira)
                        }

                        // --- INÍCIO DO TRECHO CORRIGIDO ---
                        // Fecha o modal do Bootstrap e garante a limpeza do backdrop.

                        const ModalPrincipal = document.getElementById('modalEditarProduto');

                        $('.modal-header>.btn-close').click();


                        if (ModalPrincipal) {
                            ModalPrincipal.addEventListener('shown.bs.modal', function () {
                                // O evento 'shown.bs.modal' é disparado quando o modal está totalmente visível.
                                // Neste ponto, o backdrop também estará visível e com a classe 'show'.

                                const backdropElement = document.querySelector('.modal-backdrop.fade.show');

                                if (backdropElement) {

                                    console.log('Backdrop encontrado:', backdropElement);

                                    // backdropElement.className = 'modal fade';
                                    console.log('Classes do backdrop alteradas para "modal fade". Novo className:', backdropElement.className);
                                } else {
                                    console.log('Elemento .modal-backdrop.fade.show não encontrado quando o modal foi exibido.');
                                }
                            });
                        } else {
                            console.warn('Elemento do modal principal (ex: #modalEditarProduto) não encontrado. O script não será ativado.');
                        }

                        // --- FIM DO TRECHO CORRIGIDO ---

                    }
                },
                error: function (xhr, status, error) {

                    // Adicione tratamento de erro para CSRF inválido
                    if (xhr.status === 403) {
                        alert('Token de segurança inválido. Recarregue a página.');
                        location.reload();
                    } else {
                        console.error('Erro na requisição:', error);
                    }
                    // Esta função é executada se ocorrer um erro na requisição AJAX (ex: erro de servidor 500, 404, etc.).
                    console.error('Erro na requisição AJAX:', status, error);
                    console.error('Resposta do servidor (XHR):', xhr);
                    let errorMessage = 'Ocorreu um erro inesperado ao tentar salvar as alterações.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message; // Usa a mensagem de erro do servidor, se disponível
                    } else if (xhr.responseText) {
                        try {
                            const parsedError = JSON.parse(xhr.responseText);
                            if (parsedError && parsedError.message) errorMessage = parsedError.message;
                        } catch (e) { /* Não é JSON, usa o texto puro se for curto */
                            if (xhr.responseText.length < 200) errorMessage = xhr.responseText;
                        }
                    }
                    showFlashMessage(errorMessage, 'error');
                },
                complete: function () {
                    // Esta função é executada sempre, após 'success' ou 'error'.
                    // Restaura o estado original do botão de salvar.
                    btnSalvar.prop('disabled', false);
                    spinner.addClass('d-none');
                    btnText.text('Salvar Alterações');
                }
            }); // Fim da chamada $.ajax
        }); // Fim do $(document).on("click", '#btnSalvarAlteracoes', ...
    }); // Fim do $(document).ready()
}); // Fim do document.addEventListener('DOMContentLoaded', ...
