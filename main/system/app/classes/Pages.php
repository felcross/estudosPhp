<?php


class Pages
{

    public function __construct(string $get)
    {

        $this->verificaArquivo($get);
    }


    private function verificaArquivo($get): void
    {

        include './system/app/config/config.php';

        if(file_exists(pages . $get . '.php')) {
            $arquivo = file_get_contents(pages . $get . '.php');
            echo $arquivo;
        } else {
            echo "Arquivo não existe";
        }
        
            
            
       
    }
}
