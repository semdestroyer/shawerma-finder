<?php

namespace App\Http\Controllers;

use App\Models\Shawerma;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        return json_encode(Shawerma::all());
    }
    public function store()
    {

    }
    public function update()
    {

    }


    public function create($name,$photo,$lattitude,$longtitude,$rating,$telegram)
    {
        $shawerma = new Shawerma();
        $shawerma->name = $name;
        $shawerma->cover_photo = $photo;
        $shawerma->rating = $rating;
        $shawerma->latitude = $lattitude;
        $shawerma->longtitude = $longtitude;
        $shawerma->author_telegram_id = $telegram;
        $shawerma->save();
    }




}
