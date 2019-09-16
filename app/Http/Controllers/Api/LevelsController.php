<?php namespace App\Http\Controllers\Api;

use App\Repository\Api\LevelRepository;

class LevelsController
{
    public static function show($data)
    {
        return LevelRepository::show( $data['id'] );        
    }
}