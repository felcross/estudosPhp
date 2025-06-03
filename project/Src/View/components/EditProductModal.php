<?php
// src/view/components/EditProductModal.php
/**
 * Este componente não precisa de props específicas pois é populado via JavaScript
 */
?>

<div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="modalEditarProdutoLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarProdutoLabel">
                    Editar Produto - <span id="modalNomeProduto"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarProduto" method="POST"> 
                    <input type="hidden" id="modalIdProduto" name="id_produto">
                    <input type="hidden" id="modalRowIndex" name="row_index">
                    <input type="hidden" id="modalReferencia" name="referencia">
                    <input type="hidden" id="modalReferencia2" name="referencia2">
                    <input type="hidden" id="modalNome" name="nome">
        
                    <div class="mb-3">
                        <label for="modalCodigoInterno" class="form-label">Código Interno (Produto)</label>
                        <input type="text" class="form-control" id="modalCodigoInterno" name="id_produto" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modalReferenciaDisplay" class="form-label">Referência</label>
                        <input type="text" class="form-control" id="modalReferenciaDisplay" name="referencia" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modalReferencia2Display" class="form-label">Referência 2</label>
                        <input type="text" class="form-control" id="modalReferencia2Display" name="referencia2" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modalCodigoBarras" class="form-label">Código de Barras</label>
                        <input type="text" class="form-control" id="modalCodigoBarras" name="CODIGOBARRA">
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalQtdMaxArmazenagem" class="form-label">Qtd. Máx. Armazenagem</label>
                        <input type="number" class="form-control" id="modalQtdMaxArmazenagem"
                               name="QTD_MAX_ARMAZENAGEM" min="0" value="0" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="modalLocal" class="form-label">Local</label>
                            <input type="text" class="form-control" id="modalLocal" name="LOCAL">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="modalLocal2" class="form-label">Local 2</label>
                            <input type="text" class="form-control" id="modalLocal2" name="LOCAL2">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="modalLocal3" class="form-label">Local 3</label>
                            <input type="text" class="form-control" id="modalLocal3" name="LOCAL3">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="btnSalvarAlteracoes">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span class="btn-text">Salvar Alterações</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>