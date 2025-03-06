<?php


function api(string $endPoint, string $metodo, array $post = [], string|null $token = null): array
{

    $header = [
        'Content-Type: application/json',
    ];

    if ($token) {
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ];
    }


    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'http://166.0.186.208:2002/emsoft/emauto/' . $endPoint);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_CUSTOMREQUEST, $metodo);
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);

    if ($metodo == 'POST' || $metodo == 'PUT') {
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($post));
    }


    $resutl = curl_exec($c);

    $resultado = [
        'status' => curl_getinfo($c, CURLINFO_HTTP_CODE),
        'response' => json_decode($resutl)
    ];

    curl_close($c);

    return $resultado;
}
