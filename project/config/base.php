<?php

/**
 * Summary of nomeSistema
 * @example nomeSistema
 */
define('NomeSistema', $_SERVER['DOCUMENT_ROOT'] . "/project" . '/');

define('js', NomeSistema.'public/js/');

define('localhost', "http://localhost/project/public/js/etc/");

define('views',NomeSistema.'src/view/');


// Endpoint IP do Emauto API
define('apiEmauto', 'http://166.0.186.208:2002/');

// URL base do sistema para Mercado Livre
define('EnderecoBase', '/emsoft/emauto/');


define('dataUllProdutos', 'dataUltProdutosEdit');

/**
 * CONSTANTES DOS ENDPOINTS - EMAUTO
 * Definem os endpoints da API Emauto utilizados para interação com os serviços.
    */

// Endpoint para login no sistema Emauto
define('apiLogin', EnderecoBase . 'ServiceSistema/Login');

// Endpoint para produtos Emauto
define('apiProdutos', EnderecoBase . 'Produto');

// Endpoint para CFOP Emauto
define('apiCFOP', EnderecoBase . 'Cfop');

// Endpoint para Tabela X Emauto
define('apiTabelaX', EnderecoBase . 'TabelaX');

// Endpoint para cadastro rápido de clientes
define('apiCadClientes', EnderecoBase . 'ServiceClientes/InclusaoRapida');

// Endpoint para criar nova pré-venda
define('apiPreVenda', EnderecoBase . 'ServiceVendas/NovaPreVenda');

// Endpoint para produtos alterados no Emauto
define('apiProdutosAlterados', EnderecoBase . 'ServiceEcommerce/ProdutosAlterados');

// Endpoint para Faturamento
define('apiFaturamento', EnderecoBase . 'ServiceEcommerce/Faturamento');

// Endpoint para confirmar integração de produto no EMAuto
define('apiIntegraProduto', EnderecoBase . 'ServiceEcommerce/IntegrarProduto');

// Endpoint para confirmar integração de combo no EMAuto
define('apiIntegraCombo', EnderecoBase . 'ServiceEcommerce/IntegrarCombo');

// Endpoint para consultar anuncios
define('apiNovosAnuncios', EnderecoBase . 'ServiceEcommerce/AnunciosAlterados');



// Caminho para o arquivo de padrões de pedidos
define('padroesPedidos',  NomeSistema . 'system/config/padroesPedidos.ini');

// Caminho para o arquivo de dados das Notas Fiscais(XML)
define('dadosPastaNFE', NomeSistema . 'system/config/pastaNFE.ini');

// Caminho para o arquivo de dados das Imagens
define('dadosPastaIMG',  NomeSistema . 'system/config/pastaIMG.ini');

// Nome do arquivo que contém as chaves refresh para novo login
define('dadosChavesRefreshOutro',  NomeSistema . 'system/config/chavesOutro.ini');

// Nome do arquivo que contém o código da tabela padrão do sistema
define('dadosTabelaPadrao',  NomeSistema . 'system/config/tabCodigo.ini');

// Nome do arquivo que contém o código da unidade de distribuição do sistema
define('dadosDistribuidoraPadrao',  NomeSistema . 'system/config/undCodigo.ini');

// Caminho para o arquivo de chaves de acesso do emauto
define("chaveAcessoEMAUTO", 'emautoAcessoToken');

?>