    $(document).ready(function () {
        const modalEditarProdutoEl = document.getElementById('modalEditarProduto');
        const flashContainer = $('#flashMessageContainer'); // Definido no HTML para exibir mensagens

        // Função para exibir mensagens flash com jQuery
        function showFlashMessage(message, type = 'success') {
            const alertDiv = $(`
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            // flashContainer.html(''); // Descomente se quiser apenas uma msg por vez
            flashContainer.append(alertDiv);

            // Remove a mensagem após 5 segundos
            setTimeout(() => {
                // Para Bootstrap 5, o método de fechar é 'dispose' se criado dinamicamente,
                // ou usar .alert('close') se já existia e foi apenas mostrado.
                // Como estamos criando e adicionando, o 'close' event do botão é suficiente
                // ou podemos tentar fechar o alerta programaticamente.
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alertDiv[0]);
                if (bsAlert) {
                    bsAlert.close();
                }
            }, 5000);
        }


        // Popula o modal quando ele é aberto (usando os data-attributes do HTML)
        if (modalEditarProdutoEl) {
            modalEditarProdutoEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Botão que acionou o modal

                $('#modalIdProduto').val($(button).data('id_produto'));
                $('#modalRowIndex').val($(button).data('row-index')); // Para saber qual linha atualizar
                $('#modalCodigoInterno').val($(button).data('id_produto')); // O 'PRODUTO' original
                $('#modalDescricao').val($(button).data('descricao'));
                $('#modalCodigoBarras').val($(button).data('codigobarra'));
                $('#modalQtdMaxArmazenagem').val($(button).data('qtd_max_armazenagem'));
                $('#modalLocal').val($(button).data('local'));
                $('#modalLocal2').val($(button).data('local2'));
                $('#modalLocal3').val($(button).data('local3'));
            });
        }


        // Ação de salvar alterações - adaptado do seu jQuery
        $(document).on("click", '#btnSalvarAlteracoes', function (e) {
            e.preventDefault();
            const $thisButton = $(this);
            const originalButtonText = $thisButton.html();
            const rowIndex = $('#modalRowIndex').val();

            // Objeto com os dados do formulário do modal
            let formData = {
                'PUT': true, // Sua flag para indicar uma atualização
                'id_produto': $('#modalIdProduto').val(),
                // 'codigo_interno': $('#modalCodigoInterno').val(), // O código interno é o id_produto, não precisa enviar de novo se for o mesmo
                'descricao': $('#modalDescricao').val(),
                'CODIGOBARRA': $('#modalCodigoBarras').val(),
                'QTD_MAX_ARMAZENAGEM': $('#modalQtdMaxArmazenagem').val(),
                'LOCAL': $('#modalLocal').val(),
                'LOCAL2': $('#modalLocal2').val(),
                'LOCAL3': $('#modalLocal3').val()
            };

            // Adicionar token se existir o input #token
            if ($('#token').length) {
                formData.token = $('#token').val();
            } else {
                console.warn("Elemento #token não encontrado. Se o backend requer um token, a requisição pode falhar.");
            }

            $thisButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...');

            $.post(window.location.href, formData)
                .done(function (response) {
                    // Tenta parsear a resposta como JSON.
                    // Seu backend DEVE retornar JSON para isso funcionar bem.
                    // Ex: header('Content-Type: application/json'); echo json_encode($responseData); exit;
                    let data;
                    try {
                        data = typeof response === 'string' ? JSON.parse(response) : response;
                    } catch (error) {
                        console.error("Erro ao parsear JSON da resposta:", error, "Resposta recebida:", response);
                        showFlashMessage('Erro de comunicação: Resposta inválida do servidor.', 'danger');
                        return; // Sai da função .done()
                    }

                    if (data && data.success) {
                        showFlashMessage(data.message || 'Produto atualizado com sucesso!', 'success');

                        // Atualiza a linha da tabela no frontend
                        const $row = $('#produto-row-' + rowIndex);
                        if ($row.length) {
                            $row.find('.cell-produto-descricao').text(formData.descricao);
                            $row.find('.cell-produto-codigobarra').text(formData.CODIGOBARRA);
                            $row.find('.cell-produto-qtd_max_armazenagem').text(formData.QTD_MAX_ARMAZENAGEM);
                            $row.find('.cell-produto-local').text(formData.LOCAL);
                            $row.find('.cell-produto-local2').text(formData.LOCAL2);
                            $row.find('.cell-produto-local3').text(formData.LOCAL3);

                            // Atualiza os data-attributes do botão de editar para consistência
                            const $editButton = $row.find('.btn-editar-produto');
                            $editButton.data('descricao', formData.descricao);
                            $editButton.data('codigobarra', formData.CODIGOBARRA);
                            $editButton.data('qtd_max_armazenagem', formData.QTD_MAX_ARMAZENAGEM);
                            $editButton.data('local', formData.LOCAL);
                            $editButton.data('local2', formData.LOCAL2);
                            $editButton.data('local3', formData.LOCAL3);
                        }

                        // Fecha o modal do Bootstrap
                        const modalInstance = bootstrap.Modal.getInstance(modalEditarProdutoEl);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    } else {
                        showFlashMessage(data.message || 'Erro ao atualizar o produto. Verifique os dados.', 'danger');
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX request failed:", textStatus, errorThrown, jqXHR.responseText);
                    let errorMessage = 'Erro na comunicação com o servidor.';
                    if (jqXHR.responseText){
                        try {
                            const errorData = JSON.parse(jqXHR.responseText);
                            if (errorData && errorData.message) {
                                errorMessage = errorData.message;
                            }
                        } catch(e) {
                             // Se não for JSON, pode ser um erro HTML do servidor
                            errorMessage = `Erro do servidor: ${textStatus} (ver console para detalhes)`;
                        }
                    }
                    showFlashMessage(errorMessage, 'danger');
                })
                .always(function () {
                    $thisButton.prop('disabled', false).html(originalButtonText);
                });
        });

        // Limpa o formulário do modal quando ele é fechado (opcional, mas bom para UX)
        if (modalEditarProdutoEl) {
            modalEditarProdutoEl.addEventListener('hidden.bs.modal', function () {
                $('#formEditarProduto')[0].reset();
            });
        }
    });
