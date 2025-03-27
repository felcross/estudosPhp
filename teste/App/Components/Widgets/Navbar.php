<?php
namespace Components\Widgets;


class Nav {

    private $name,$action,$fields,$title; 

    public function __construct($name)
    {
        $this->name = $name;
        $this->fields = [];
        $this->title = '';
    }

    public function setTitle($title) {
         $this->title = $title;
    }

    public function addField($label,$name,$type,$value, $class ='') 
    {
        $this->fields[] = ['label' => $label ,
                           'name' =>  $name , 
                           'type' => $type, 
                           'value' =>  $value,
                           'class' =>  $class]; 


    }

    public function setAction($action) 
    {
         $this->action = $action;

    }

    public function show() {

         echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>White Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://images.unsplash.com/photo-1618477247222-acbdb0e159b3?w=50&h=50&fit=crop" alt="Brand Logo" width="40" height="40" class="d-inline-block align-text-middle rounded-circle me-2">
                Brand
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
';

    }
    
}


