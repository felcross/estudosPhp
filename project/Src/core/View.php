<?php

namespace Core;


class View
{


    public static function render(string $path, array $attributes = [], string|null $js = null): void
    {

        extract($attributes);
        

     //   print (self::layout()['header']);
        file_exists(views . $path) && include views . $path;
       // print (self::layout()['footer']);


        $js !== null && self::js($js);


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

    
    private static function  layout(): array
    {
        return [
            'header' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/sidebar.php'),
            'footer' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/project/src/view/template/footer.php'),
        ];

    } 

}





?>