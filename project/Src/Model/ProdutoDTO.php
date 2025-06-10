<?php
namespace model;

class ProdutoDTO 
{
    private $data;
    
    public function __construct(array $data = []) {
        $this->data = $data;
    }
    
    public function __set($props, $value) {
        $this->data[$props] = $value;
    }
    
    public function __get($props) {
        return $this->data[$props] ?? null;
    }
    
    public function __isset($props) {
        return isset($this->data[$props]);
    }
    
    public function __unset($props) {
        unset($this->data[$props]);
    }
    
    // Métodos específicos para formatação/validação
    public function getPrecoFormatado(): string {
        $preco = $this->data['PRECO'] ?? 0;
        return 'R$ ' . number_format((float)$preco, 2, ',', '.');
    }
    
    public function getNomeLimpo(): string {
        return htmlspecialchars($this->data['PRODUTO'] ?? '');
    }
    
    public function temEstoque(): bool {
        return ($this->data['ESTOQUE'] ?? 0) > 0;
    }
}