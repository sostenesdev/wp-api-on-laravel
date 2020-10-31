<?php
namespace App\WordpressAPI;

use Illuminate\Http\Request;

class Post{

    public function list(Request $request){
        $client = new \GuzzleHttp\Client();

        $url = config('services.wp_api.url').'/wp-json/wp/v2/posts';
        $data = [];

        $params = [
            'form_params' => $data,
            'headers' => [
                'Accept' => 'application/json',
                'authorization' => 'Bearer '.session('auth_info')->token,
                'cache-control' => 'no-cache'
            ]
        ];

        try {
            $response = $client->request('GET', $url, $params);
            $decodedBody = json_decode($response->getBody()->getContents(), true);
            dd($decodedBody);
            return $decodedBody;
        }
        catch (\GuzzleHttp\Exception\RequestException $e) {
            //$errors = $e->getResponse()->getBody();
            //return response($errors,$e->getCode());
            return null;
        }
}//end of list

public function create(Request $request, $post){
    $client = new \GuzzleHttp\Client();

    $url = config('services.wp_api.url').'/wp-json/wp/v2/posts';
    $data = [
        'slug'=> $post->slug,
        'title'=> $post->title,
        'content'=> $post->content,
        'author'=> $post->author, //integer
        'excerpt'=> $post->excerpt,
        'featured_media'=> $post->featured_media , // integer 23
        'status'=> $post->status, //publish, future, draft, pending, private
        'comment_status'=> $post->comment_status, // open, closed
        'ping_status'=> $post->ping_status, // open, closed
        'format'=> $post->format,//standard, aside, chat, gallery, link, image, quote, status, video, audio
    ];

    $params = [
        'form_params' => $data,
        'headers' => [
            'Accept' => 'application/json',
            'authorization' => 'Bearer '.session('auth_info')->token,
            'cache-control' => 'no-cache'
        ]
    ];

    try {
        $response = $client->request('POST', $url, $params);
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
