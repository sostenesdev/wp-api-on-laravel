<?php
namespace App\Http\Controllers\WpApi;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller{

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
            return redirect()->route('wpapi.posts.insert')->with('message', 'Access token has been updated');
        }
        catch (\GuzzleHttp\Exception\RequestException $e) {
            //dd($client->request('POST', $url, $params));
            $errors = $e->getResponse()->getBody();
            return response($errors,$e->getCode());
        }
    }

}
