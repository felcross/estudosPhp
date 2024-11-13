<?php
require_once 'classes/Pessoa.php';
require_once 'classes/Cidade.php';

class PessoaList
{

    private $html;
    private $data;
    public function __construct()
    {
        $this->html = file_get_contents('html/list.html');
    
    }

    public function delete($param)
    {

        try {
            $id = (int) $param['id'];
            Pessoa::delete($id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function load()
    {

        try {
            $pessoas = Pessoa::all();
            //$this->data = $dados;


            // fetch_assoc retornar em vetor 
            $items = '';
           
                foreach ($pessoas as $row) {
                    //print $row['codigo'] . '-' . $row['nome'] . '<br>'

                    $item = file_get_contents('html/item.html');
                    $item = str_replace('{id}', $row['id'], $item);
                    $item = str_replace('{nome}', $row['nome'], $item);
                    $item = str_replace('{endereco}', $row['endereco'], $item);
                    $item = str_replace('{bairro}', $row['bairro'], $item);
                    $item = str_replace('{telefone}', $row['telefone'], $item);
                    $item = str_replace('{email}', $row['email'], $item);
                    $item = str_replace('{id_cidade}', $row['id_cidade'], $item);

                    $items .= $item;
                }

                $this->html = str_replace('{items}',$items,$this->html);
                 
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        print  $this->html;
    }
}
