<?php
namespace App\Http\Controllers\WpApi;
use Illuminate\Http\Request;

class PostController{

    public function all(Request $request){
            $client = new \GuzzleHttp\Client();

            $url = config('services.wp_api.url').'/wp-json/wp/v2/posts';
            $data = [];

            $params = [
                'form_params' => $data,
                'headers' => [
                    'Accept' => 'application/json',
                    'authorization' => 'Bearer '.session('access-token'),
                    'cache-control' => 'no-cache'
                ]
            ];

            try {
                $response = $client->request('GET', $url, $params);
                $decodedBody = json_decode($response->getBody()->getContents(), true);
                dd($decodedBody);
            }
            catch (\GuzzleHttp\Exception\RequestException $e) {
                //dd($client->request('POST', $url, $params));
                $errors = $e->getResponse()->getBody();
                return response($errors,$e->getCode());
            }
        }//end of all

}
