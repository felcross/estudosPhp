<?php

namespace model;
use api\ApiServiceEmauto;
use utils\Temp;
use api\TokensControl;
use utils\Erros;
use utils\DadosINI;

class ProdutoApi extends TokensControl
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
        parent::__construct();
        $this->apiServiceEmauto = new ApiServiceEmauto;
        $this->temp = new Temp;
        $this->dadosINI = new DadosINI;
    }

    public function getProduto($qtd)
    {     // "http://166.0.186.208:2002/emsoft/emauto/Produto?%24filter=WEB%20eq%20'S'&%24top={$qtd}"


        $exec = function (string $data, int $pagina): array {
            $this->apiServiceEmauto->set(
                apiProdutos,
                'GET',
                "%24filter=WEB%20eq%20'S'&%24top={$data}",
                useLineCounts: false
            );
            return [
                'status' => $this->apiServiceEmauto->getStatus(),
                'data' => $this->apiServiceEmauto->getConteudo()['Data'] ?? []
            ];
        };
        $pagina = 0;
        
        do {

            try {
                $resultado = $exec($qtd, $pagina);
                if ($resultado['status'] < 200 || $resultado['status'] > 250 || empty($resultado['data'])) {
                    break;
                }

               // Adicione os produtos ao array
            foreach ($resultado['data'] as $item) {
                $produtos[] = $item;
            }
            } catch (\Throwable $th) {
                Erros::salva("ProdutosAlterados - Erro ao tentar baixar produtos no EMAUTO", error_get_last());
            }


            $pagina++;
        } while (!empty($resultado['data']));

        $this->temp->setDataUltUpdateProdutos('dataUllProdutos');

        return $produtos;
    } 
}

    