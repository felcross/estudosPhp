<?php

namespace Core;

class View 
{
    /**
     * Renderiza uma view com controle de layout
     */
    public static function render(string $path, array $attributes = [], string|null $js = null, bool $withSidebar = true, array $extraScripts = []): void
    {
        extract($attributes);
        
        // Carrega header com ou sem sidebar baseado no parâmetro
        print(self::layout($withSidebar, $extraScripts)['header']);
        
        // Inclui a view solicitada
        file_exists(views . $path) && include views . $path;
        
        // Carrega footer
        print(self::layout($withSidebar, $extraScripts)['footer']);
        
        // Inclui JavaScript se especificado
        $js !== null && self::js($js);
    }

    /**
     * Renderiza uma view sem sidebar (para login, etc)
     */
    public static function renderWithoutSidebar(string $path, array $attributes = [], string|null $js = null, array $extraScripts = []): void
    {
        self::render($path, $attributes, $js, false, $extraScripts);
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

    /**
     * Retorna o layout com controle condicional do sidebar
     */
    private static function layout(bool $withSidebar = true, array $extraScripts = []): array
    {
        $headerFile = $withSidebar 
            ? $_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/sidebar2.php'
            : $_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/sidebar.php';
        
        // Carrega o conteúdo do header
        $headerContent = file_get_contents($headerFile);
        
        // Se houver scripts extras, adiciona antes do </head>
        if (!empty($extraScripts)) {
            $scriptsHtml = '';
            foreach ($extraScripts as $script) {
                $scriptsHtml .= "<script src='{$script}'></script>\n    ";
            }
            $headerContent = str_replace('</head>', "    {$scriptsHtml}</head>", $headerContent);
        }
            
        return [
            'header' => $headerContent,
            'footer' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/footer.php'),
        ];
    }
}































































//namespace Core; 

// class View 
// {
//     public static function render(string $path, array $attributes = [], string|null $js = null): void
//     {
//         extract($attributes);
        
//         print(self::layout()['header']);
//         file_exists(views . $path) && include views . $path;
//         print(self::layout()['footer']);
        
//         $js !== null && self::js($js);
//     }

//     /**
//      * Renderiza um componente específico
//      */
//     public static function component(string $componentName, array $props = []): string
//     {
//         $componentPath = $_SERVER['DOCUMENT_ROOT'] . '/project/src/view/components/' . $componentName . '.php';
        
//         if (!file_exists($componentPath)) {
//             throw new \Exception("Componente '{$componentName}' não encontrado em: {$componentPath}");
//         }
        
//         // Extrai as props para ficarem disponíveis no componente
//         extract($props);
        
//         // Captura a saída do componente
//         ob_start();
//         include $componentPath;
//         return ob_get_clean();
//     }


//     public static function renderComponent(string $componentName, array $props = []): void
//     {
//         echo self::component($componentName, $props);
//     }

//     private static function js(string $name)
//     {
//         $file = localhost . $name . '.js';
//         echo <<<HTML
//             <script src="{$file}"></script>
//         HTML;
//     }

//     private static function template()
//     {
//     }

//     private static function page()
//     {
//     }

//     private static function layout(): array
//     {
//         return [
//             'header' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/sidebar.php'),
//             'footer' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/footer.php'),
//         ];
//     }
//}

















































