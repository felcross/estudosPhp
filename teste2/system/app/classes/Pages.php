<?php
 

class Pages
{

    public function __construct(string $get)
    {    
        if(Login::is_logado()) {

            $this->verificaArquivo($get);
        } else {
            $this->verificaArquivo('login');
        }
         

        
    }


    private function verificaArquivo($get): void
    {

        include './system/app/config/config.php';

        if(file_exists(pages . $get . '.php')) {
            $arquivo = file_get_contents(pages . $get . '.php');
            echo $arquivo;
            $this->includeJs($get);
        } else {
            echo "Arquivo não existe";
        }  
    }

    private function includeJs($param):void {
        $endJS = './system/public/JS/'. $param . '.js';

        if(file_exists($endJS)){
          echo "<script src='$endJS'>   </script>";
        }
    }
}
