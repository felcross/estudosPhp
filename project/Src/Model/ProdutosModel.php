<?php

namespace model;
use api\ApiServiceEmauto;
use utils\Temp;
use utils\Crypto;
use utils\Erros;
use utils\DadosINI;

class ProdutosModel
{
    /**
     * Class apiServiceEmauto
     * @var ApiServiceEmauto
     */
    private ApiServiceEmauto $apiServiceEmauto;

    /**
     * Class temp
     * @var Temp
     */
    private Temp $temp;

    /**
     * Class dadosINI
     * @var DadosINI
     */
    private DadosINI $dadosINI;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->apiServiceEmauto = new ApiServiceEmauto;
        $this->temp = new Temp;
        $this->dadosINI = new DadosINI;
    }

    /**
     * Obtém produtos alterados desde a última atualização e processa os dados em lotes paginados.
     *
     * O método consulta uma API para buscar produtos modificados a partir de uma data específica,
     * percorrendo todas as páginas disponíveis até que não haja mais registros a serem processados.
     *
     * @throws \Exception Se a requisição à API retornar um status inválido (fora do intervalo 200-250).
     * @throws \Throwable Captura erros inesperados durante a execução.
     */
    public function getProduct($id)
    {


        $exec = function (string $data, int $pagina): array {
            $this->apiServiceEmauto->set(
                apiProdutosAlterados,
                'GET',
                "pData=$data&pIntegrados=S&pRegistros=100&pPagina=$pagina",
                useLineCounts: false
            );
            return [
                'status' => $this->apiServiceEmauto->getStatus(),
                'data' => $this->apiServiceEmauto->getConteudo()['Data'] ?? []
            ];
        };


    }

    /**
     * Função que formata o layout do estoque
     * @access private
     * @param array $dados
     * @return void
     */
    private function layoutEstoque(array $dados): void
    {
        try {

            $distri = Crypto::descriptografar(
                $this->dadosINI->getDistribuicao()['codigo'] ?? 0
            );

            $conteudo = [
                'sku' => $dados['PRODUTO'],
                'conteudo' => [
                    "StorageId" => (int) $distri,
                    "Quantidade" => $dados['QTDATUAL'],
                    "QuantidadeMínima" => $dados['QTDMINIMA']
                ]
            ];
            $this->temp->salvaJSON(tempListEstoque, $conteudo);
        } catch (\Throwable $th) {
            Erros::salva("ProdutosAlterados - Erro ao tentar modelar em formato Estoque", $th);
        }

    }

    /**
     * Função que formata o layout do preço unitário
     * @access private
     * @param array $dados
     * @return void
     */
    private function layoutPrecoUnitario(array $dados)
    {

        try {
            $tabPreco = Crypto::descriptografar(
                $this->dadosINI->getTabelaPreco()['codigo'] ?? 0
            );

            $conteudo = [
                'sku' => $dados['PRODUTO'],
                'conteudo' => [
                    "PriceTableId" => (int) $tabPreco,
                    "ListPrice" => $dados['QTDATUAL'],
                    "SalePrice" => $dados['QTDMINIMA']
                ]
            ];
            $this->temp->salvaJSON(tempListPrecosUnit, $conteudo);
        } catch (\Throwable $th) {
            Erros::salva("ProdutosAlterados - Erro ao tentar modelar em formato Preços Unitários", $th);
        }

    }



    /**
     * Remove um item do JSON com base no SKU fornecido.
     *
     * @param string $sku O identificador do produto a ser removido.
     * @param string $metodo - "cad" ou "edit" - Informa qual o tipo de arquivo deve ser analisado
     * @return void
     */
    public function excluirItemEstoque(string $sku): void
    {
       
        $dados = $this->temp->recuperaJson(tempListEstoque);
        if (!empty($dados) && is_array($dados)) {
            $dados = array_values(array_filter($dados, fn($item) => isset($item['sku']) && $item['sku'] !== $sku));
            $this->temp->salvaJSON(tempListEstoque, $dados, false, true);
        }
    }


    public function excluirItemPreco(string $sku): void
    {
       
        $dados = $this->temp->recuperaJson(tempListPrecosUnit);
        if (!empty($dados) && is_array($dados)) {
            $dados = array_values(array_filter($dados, fn($item) => isset($item['sku']) && $item['sku'] !== $sku));
            $this->temp->salvaJSON(tempListPrecosUnit, $dados, false, true);
        }
    }




}
