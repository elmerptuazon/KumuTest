<?php

namespace App\Services\ThirdParty\SocialMedia\Github;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class GithubService implements IGithubService
{

    public function __construct()
    {
        $this->githubUsersUrl = config('services.github.domain') . '/users';
        $this->githubClientId = config('services.github.client-id');
        $this->githubClientSecret = config('services.github.client-secret');
        $this->redisExpiration = config('database.redis.cache.expiration');
    }

    public  function process(array $data): array {
        $list = [];
        
        foreach($data['usernames'] as $val) {
            $body = $this->getUserByCache($val);
        
            array_push($list, $this->userBodyFormat($body));
        }
        return $list;
    }

    private function getUserDetails(string $username) {
        $response = Http::withBasicAuth($this->githubClientId, $this->githubClientSecret)
        ->get($this->githubUsersUrl . '/' . $username);
      
        if($response->successful())  {
            Redis::set($username, json_encode($response->json()), 'EX', $this->redisExpiration);
        
            Log::channel('kumu_log')->info('Github API call', ['data'=>$response->json()]);

            return $response->json();
        }

        return null;
    }

    private function userBodyFormat(array $data=null): array {
        $arr=[];
        if(!empty($data)) {
            $arr = [
                'name' => $data['name'],
                'login'=>$data['login'],
                'company'=>$data['company'],
                'number_of_followers'=>$data['followers'],
                'number_of_public_repositories'=>$data['public_repos'],
                'average_number_of_followers_per_public_repositories'=>($data['followers']/$data['public_repos'])
            ];
        }
    
        return  $arr;
    }

    private function getUserByCache(string $username) {
        $response = Redis::get($username);
        if($response) Log::channel('kumu_log')->info('Cache Redis call', ['data'=>$response]);
        return ($response) ? json_decode($response, true) : $this->getUserDetails($username);
    }
}
