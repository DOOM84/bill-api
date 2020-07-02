<?php


namespace App\Repositories\Contracts;


use Illuminate\Http\Request;

interface IPicture
{
    public function applyImage($filename, $hall, $status/*, $path*/);

}
