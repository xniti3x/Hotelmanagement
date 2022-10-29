<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api
{    
    private $BASE_URL = 'https://ob.nordigen.com/api/v2/';
    
    //Step 1: Get Access Token
    public function requstNewToken($secret_id, $secret_key){     
        $client = new \GuzzleHttp\Client();
        $response=$client->request('POST', $this->BASE_URL.'token/new/', [
            'json' => [
                'secret_id'     => $secret_id,
                'secret_key'    => $secret_key
            ]
        ]);      
        return array('result'=>json_decode($response->getBody(),true),'code'=>$response->getStatusCode());
    }

    //Step 2: Show all banks
    public function requestAllInstituts($accessToken,$country){

        $client = new \GuzzleHttp\Client();
        $response=$client->request('GET', $this->BASE_URL.'institutions/?country='.$country, [
            'headers' => [
                'accept'        =>"application/json",
                'Content-Type'        =>"application/json",
                'Authorization'     => 'Bearer '.$accessToken,
            ]
        ]);  
        return array('result'=>json_decode($response->getBody(),true),'code'=>$response->getStatusCode());
    }


    //Step 3: Choose your Bank by its institution_id
    public function requestInstitut($accessToken,$institution_id,$redirect_url){

        $body=array(
            'redirect'    => $redirect_url,
            'institution_id'    => $institution_id
        );

        $client = new \GuzzleHttp\Client();
        $response=$client->request('POST', $this->BASE_URL.'requisitions/', [
            'headers' => [
                'accept'        =>"application/json",
                'Content-Type'        =>"application/json",
                'Authorization'     => 'Bearer '.$accessToken,
            ],
            'body'=>json_encode($body)
        ]);  
        return array('result'=>json_decode($response->getBody(),true),'code'=>$response->getStatusCode());
    }
    
     //Step 3: Choose Your Acc by giving institution_id
    public function listAccounts($accessToken,$institution_id){
        $client = new \GuzzleHttp\Client();
        $response=$client->request('GET', $this->BASE_URL.'requisitions/'.$institution_id, [
            'headers' => [
                'accept'        =>"application/json",
                'Content-Type'        =>"application/json",
                'Authorization'     => 'Bearer '.$accessToken,
            ]
        ]);  
        return array('result'=>json_decode($response->getBody(),true),'code'=>$response->getStatusCode());
    }

    //Step 4: Show your Acc Transactions by giving account_id
    public function getAllTransactions($accessToken,$account_id){
        $client = new \GuzzleHttp\Client();
        $response=$client->request('GET', $this->BASE_URL.'accounts/'.$account_id.'/transactions/', [
            'headers' => [
                'accept'        =>"application/json",
                'Content-Type'        =>"application/json",
                'Authorization'     => 'Bearer '.$accessToken,
            ]
        ]); 
        return array('result'=>json_decode($response->getBody(),true),'code'=>$response->getStatusCode());
    }
    // oly if needed
    public function refreshToken($accessToken){
        $client = new \GuzzleHttp\Client(); 
        $response=$client->request('POST', $this->BASE_URL.'token/refresh/', [ 'json' => [ 'refresh' => $accessToken] ]);      
        return array('result'=>json_decode($response->getBody(),true),'code'=>$response->getStatusCode());
    }
}