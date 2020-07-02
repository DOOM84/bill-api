<?php


namespace App\Repositories\Contracts;


use Illuminate\Http\Request;

interface IDish
{
    public function applyImage($filename, $status/*, $hall*//*, $path*/);

}
