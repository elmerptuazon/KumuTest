<?php
namespace App\Services\ThirdParty\SocialMedia\Github;

interface IGithubService 
{
    
    public  function process(array $data): array;
}
