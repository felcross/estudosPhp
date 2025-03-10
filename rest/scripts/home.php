<?php

defined('CONTROL') or die('acesso negado');
//get all data 
$api = new apiConsumer();
$countries = $api->get_all_countries();

//get especific data 
//$country = $api->get_country('Brazil');


?>

<div class="container mt=5"> 
    <div class="row">
       <div class="col text-center">
   <h3>Consumindo API</h3>
    <pre>
        <?php 
           print_r($countries);
      
        ?>
    </pre>

       </div> 
    </div>
</div>
