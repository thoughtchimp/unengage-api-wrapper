<?php
namespace Unengage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class API extends Client
{
    protected $base_url = 'http://api.unengage.com';
    protected $curlOptions = [];
    protected $api_key;

    public function __construct($api_key)
    {
        if(!empty(env('UNENGAGE_API_URL'))) {
            $this->base_url = env('UNENGAGE_API_URL');
        }
        
        $this->api_key = $api_key;
        parent::__construct();
    }
    
    public function streams(array $params=[])
    {
        return $this->_get("/streams", $params);
    }

    public function createStream($name, array $params=[])
    {
        return $this->_post("/streams/create", array_merge([
            'name'  => $name
        ], $params));
    }

    public function updateStream($stream_id, $name, array $params=[])
    {
        return $this->_post("/streams/$stream_id/update", array_merge([
            'name'  => $name
        ], $params));
    }

    public function stream($stream_id)
    {
        return $this->_get("/streams/$stream_id");
    }

    public function deleteStream($stream_id)
    {
        return $this->_post("/streams/$stream_id/delete");
    }

    public function streamSocialPosts($stream_id, array $params=[])
    {
        if(isset($params['page_token']) && !empty($params['page_token'])) {
            $params['page_token'] = urldecode($params['page_token']);
        }
        
        return $this->_get("/streams/$stream_id/social_posts", $params);
    }

    public function updateStreamSocialPosts($stream_id, array $post_ids, array $params)
    {
        return $this->_post("/streams/$stream_id/social_posts/update", array_merge([
            'ids' => json_encode($post_ids)
        ], $params));
    }

    public function deleteStreamSocialPosts($stream_id, array $post_ids)
    {
        return $this->_post("/streams/$stream_id/social_posts/delete", [
            'ids' => json_encode($post_ids)
        ]);
    }

    public function pinStreamSocialPost($stream_id, $post_id)
    {
        return $this->_post("/streams/$stream_id/social_posts/$post_id/pin");
    }

    public function streamSocialFeeds($stream_id, array $params=[])
    {
        return $this->_get("/streams/$stream_id/social_feeds", $params);
    }

    public function createStreamSocialFeed($stream_id, $feed, $platform, array $params=[])
    {
        return $this->_post("/streams/$stream_id/social_feeds/create", array_merge([
            'searchterm.term' => $feed,
            'platform'        => $platform,
        ], $params));
    }

    public function streamSocialFeed($stream_id, $feed_id)
    {
        return $this->_get("/streams/$stream_id/social_feeds/$feed_id");
    }

    public function updateStreamSocialFeed($stream_id, $feed_id, array $params)
    {
        return $this->_post("/streams/$stream_id/social_feeds/$feed_id/update", $params);
    }

    public function deleteStreamSocialFeed($stream_id, $feed_id)
    {
        return $this->_post("/streams/$stream_id/social_feeds/$feed_id/delete");
    }

    public function refreshStreamSocialFeed($stream_id, $feed_id)
    {
        return $this->_post("/streams/$stream_id/social_feeds/$feed_id/refresh");
    }

    public function streamSocialAccounts($stream_id, array $params=[])
    {
        return $this->_get("/streams/$stream_id/social_accounts", $params);
    }

    public function createStreamSocialAccount($stream_id, $name, $username, $uid, $platform, $token, array $params=[])
    {
        return $this->_post("/streams/$stream_id/social_accounts/create", array_merge([
            'name'          => $name,
            'username'      => $username,
            'platform'      => $platform,
            'uid'           => $uid,
            'auth.token'    => $token
        ], $params));
    }

    public function testWebhook($type, array $params=[])
    {
        return $this->_post('/webhook_test', array_merge([
            'type' => $type,
        ],$params));
    }

    public function _get($endpoint, array $params=[])
    {
        return $this->_request('GET', $endpoint, [
            'query' => $params
        ]);

        /*$url = $this->base_url.$endpoint.'?'.http_build_query($params);
        return collection(json_decode(file_get_contents($url), true));*/
    }

    public function _post($endpoint, array $params=[])
    {
        return $this->_request('POST', $endpoint, [
            'form_params'  => $params
        ]);
    }

    public function _request($method, $endpoint, array $options=[])
    {
        $url = $this->base_url.$endpoint;

        try {
            $request = $this->request($method, $url, array_merge([
                'curl'  => $this->curlOptions, 'headers' => [
                    'api-key'      => $this->api_key,
                ]
            ], $options));

            return json_decode($request->getBody(),true);
        } catch(ClientException $e) {
            throw new UnengageApiException($e->getCode(), $e->getResponse()->getBody()->getContents());
        }
    }
}