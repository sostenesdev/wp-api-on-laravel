<?php
namespace App\Http\Controllers\WpApi;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller{

    public function getToken()
    {
        $url = config('services.wp_api.url').'/oauth/authorize/?client_id='.config('services.wp_api.client_id').'&response_type=code';
        return redirect()->away($url);
    }

    public function processToken(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $url = config('services.wp_api.url').'/oauth/token';

        $data = [
        'grant_type' => 'authorization_code',
        'code' => $request->code,
        'client_id' => config('services.wp_api.client_id'),
        'client_secret' => config('services.wp_api.client_secret')
        ];

        $params = [
            'form_params' => $data,
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];

        try {
            $response = $client->request('POST', $url, $params);
            $decodedBody = json_decode($response->getBody()->getContents(), true);

            $accessToken = $decodedBody['access_token'];

            if ($accessToken) {
                session(['acess-token'=> $accessToken]);
            }

            return redirect()->route('wpapi.posts')->with('message', 'Access token has been updated');
        }
        catch (\GuzzleHttp\Exception\RequestException $e) {
            //dd($client->request('POST', $url, $params));
            $errors = $e->getResponse()->getBody();
            return response($errors,$e->getCode());
        }
    }//end of processToken

}
