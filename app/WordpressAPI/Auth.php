<?php
namespace App\WordpressAPI;

class Auth{

    public function getAccessToken(){
        $client = new \GuzzleHttp\Client();

        $url = config('services.wp_api.url').'/wp-json/jwt-auth/v1/token';

        $data = [
        'username' => env('WP_USERNAME'),
        'password' => env('WP_PASSWORD')
        ];

        $params = [
            'form_params' => $data,
            'headers' => [
            ]
        ];

        try {
            $response = $client->request('POST', $url, $params);
            $decodedBody = json_decode($response->getBody()->getContents(), true);
            $auth_info = (object)$decodedBody['data'];

            session(['auth_info' => $auth_info]);
            return $auth_info;
        }
        catch (\GuzzleHttp\Exception\RequestException $e) {
            //$errors = $e->getResponse()->getBody();
            return null;
        }
    }


}// end Auth
