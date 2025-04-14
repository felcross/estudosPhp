<?php

namespace Controller;

class App
{
    

    public function __construct(array $get)
    {   var_dump($get);
        if (isset($get["class"])) {

            if (class_exists($get["class"])) {
                $page = new $get["class"];

                $rota = $this->getRouters($get["class"]);

                print ($this->layout()['header']);
                $page->view($get, $rota);
                print ($this->layout()['footer']);

            }

        }

    }


    private function getRouters(string $class)
    {

        $array = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/routers/rota.json');
        $decod = json_decode($array, true);

        $rota = $decod[$class];

        return $rota;

    }

    private function layout(): array
    {
        return [
            'header' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/sidebar.php'),
            'footer' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/footer.php'),
        ];

    } 


}