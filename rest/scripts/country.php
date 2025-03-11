<?php

defined('CONTROL') or die('acesso negado');
//get all data 
$api = new apiConsumer();
$country = $_GET['name'] ?? null;

if(!$country) {
    header('Location: ?route=home');
    die();
}

$country_name = $api->get_country($country);


?>

<div class="container mt=5"> 
    <div class="row">
       <div class="col text-center">
             <h3>Consumindo API</h3>
       </div> 
        <div class="row justify-content-center">
                
                <div class="col-4">    <select id="select_country" class="form-select">
                        <option value="">Selecione um país</option>
                        <?php  foreach($countries as $country) :?>
                            <option value="<?= $country?>"><?= $country?></option>
                        <?php endforeach;?>
                    </select>
                
                </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded' , () => {
        // country select
  const select_country = document.querySelector("#select_country");
  select_country.addEventListener('change', () => {
     const country = select_country.value;
      window.location.href = `?route=country&name=${country}`
  })
    })

</script>
