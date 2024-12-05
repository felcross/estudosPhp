<?php
namespace Web\Core;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Exception;

/**
 * Carrega a classe da aplicação
 * @author Pablo Dall'Oglio
 */
class AppLoader
{
    protected $directories;
    
    /**
     * Adiciona um diretório a ser vasculhado
     */
    public function addDirectory($directory)
    {
        $directory = realpath($directory);
     if ($directory && is_dir($directory)) {
    $this->directories[] = $directory;
}

    }
    
    /**
     * Registra o AppLoader
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }
    
    /**
     * Carrega uma classe
     */
    public function loadClass($class)
    {
        //file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/mod/Lib/web/Log/teste.txt',$class);

        $folders = $this->directories;
        
        foreach ($folders as $folder)
        {
            if (file_exists("{$folder}/{$class}.php"))
            {   
             //   $class = str_replace('{','', $class);

             file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/mod/Lib/web/Log/teste.txt',"{$folder}" . "\{$class}.php");
                return require_once "{$folder}/{$class}.php";
                return TRUE;
            }
            else
            {
                if (file_exists($folder))
                {
                    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder),
                                                           RecursiveIteratorIterator::SELF_FIRST) as $entry)
                    {
                        if (is_dir($entry))
                        {
                            if (file_exists("{$entry}/{$class}.php"))
                            {
                                require_once "{$entry}/{$class}.php";
                                return TRUE;
                            }
                        }
                    }
                }
            }
        }
    }
}

