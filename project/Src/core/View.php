<?php

namespace Core;

class View 
{
    public static function render(string $path, array $attributes = [], string|null $js = null): void
    {
        extract($attributes);
        
        print(self::layout()['header']);
        file_exists(views . $path) && include views . $path;
        print(self::layout()['footer']);
        
        $js !== null && self::js($js);
    }

    /**
     * Renderiza um componente específico
     */
    public static function component(string $componentName, array $props = []): string
    {
        $componentPath = $_SERVER['DOCUMENT_ROOT'] . '/project/src/view/components/' . $componentName . '.php';
        
        if (!file_exists($componentPath)) {
            throw new \Exception("Componente '{$componentName}' não encontrado em: {$componentPath}");
        }
        
        // Extrai as props para ficarem disponíveis no componente
        extract($props);
        
        // Captura a saída do componente
        ob_start();
        include $componentPath;
        return ob_get_clean();
    }

    /**
     * Renderiza e exibe um componente diretamente
     */
    public static function renderComponent(string $componentName, array $props = []): void
    {
        echo self::component($componentName, $props);
    }

    private static function js(string $name)
    {
        $file = localhost . $name . '.js';
        echo <<<HTML
            <script src="{$file}"></script>
        HTML;
    }

    private static function template()
    {
    }

    private static function page()
    {
    }

    private static function layout(): array
    {
        return [
            'header' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/sidebar.php'),
            'footer' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/footer.php'),
        ];
    }
}































































// class View
// {


//     public static function render(string $path, array $attributes = [], string|null $js = null): void
//     {

//         extract($attributes);
        

//         print (self::layout()['header']);
//         file_exists(views . $path) && include views . $path;
//         print (self::layout()['footer']);


//         $js !== null && self::js($js);


//     }




//     private static function js(string $name)
//     {
//         $file = localhost . $name . '.js';
//         echo <<<HTML
//                 <script src="{$file}"></script>
//                HTML;
//     }

//     private static function template()
//     {

//     }

//     private static function page()
//     {

//     }

    
//     private static function  layout(): array
//     {
//         return [
//             'header' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/sidebar.php'),
//             'footer' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/footer.php'),
//         ];

//     } 

// }





// ?>