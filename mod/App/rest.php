<?php
header('Content-type: application/json; charset=utf-8');
require_once 'autoloadApp.php';

class RestServer {

    public static function run($request)
    {
        $class = isset($request['class'])?$request['class']:'';
        $method = isset($request['method'])?$request['method']:'';

        try{
                if(class_exists($class))
                {   
                     if(method_exists($class,$method))
                     {
                        $response = call_user_func([$class,$method],$request);
                        return json_encode(['status'=>'success',
                                            'data' =>  $response ]);
                     } else 
                     {
                        return json_encode(['status'=>'error',
                                            'data' =>  'Método Não encontrado' ]);
                     }
                   
                } 
                else 
                {
                   return json_encode(['status'=>'error',
                                       'data' =>  'Classe Não encontrado' ]);
                }
               

           }
           catch(Exception $e)
           {
            return $e->getMessage();
           }
          

    }
}

print RestServer::run($_REQUEST);