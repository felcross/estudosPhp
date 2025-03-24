<?php

defined('CONTROL') or die('acesso negado');
//get all data 
$api = new apiConsumer();
$country = $_GET['name'] ?? null;

if(!$country) {
    header('Location:?route=home');
    die();
}

$country_name = $api->get_country($country);

?>

<div class="container mt=5"> 
    <div class="d-flex">
         <div class="card p-2 shadow">
            <img src="<?=$country_name[0]['flags']['png']?>">
         </div>
         <div class="ms-5 align-self-center">
         <p class="display-3"> <strong><?=  $country_name[0]['name']['common'] ?></strong></p>
         <p class="display-5">Capital:</p>
         <p class="display-5"><?=  $country_name[0]['capital'][0] ?></p>
       </div>
        
    </div>
</div>
