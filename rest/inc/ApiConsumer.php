<?php


class apiConsumer
{


  private function api($endpoint, $method = 'GET', $fields = [])
  {
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://restcountries.com/v3.1/" . $endpoint,
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_ENCODING => "",
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_HTTPHEADER => [
        "Accept: */*",

      ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      echo "cURL Error #:" . $err;
      die(0);
    } else {
      return  json_decode($response, true);
    }
  }



  public function get_all_countries()
  {   
     //pegar todos os paises
      $results =  $this->api('all');
      $countries = [];
       
      foreach($results as $result)
      {
        $countries[]= $result['name']['common'];
        
      }
      //arsort($countries);
      return $countries;

     
      
  }

  public function get_country($country)
  {   
     //pegar todos os paises
      $country = urlencode($country);

      return $this->api("name/{$country}?fullText=true");
    
      
  }
}
