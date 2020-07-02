<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\adminInfoResource;
use App\Repositories\Contracts\IInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class InfoController extends Controller
{
    protected $infos;

    public function __construct(IInfo $infos)
    {
        $this->infos = $infos;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'info' =>  new adminInfoResource($this->infos->findFirst())
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $info = $this->infos->create([
            'general' => $request->general,
            'rus' => $request->rus,
            'pool' => $request->pool,
            'halls' => $request->halls,
            'other' => $request->other,
        ]);

        return response()->json([
            'success' => 'Информация успешно создана',
            'info' => new adminInfoResource($info),
        ], Response::HTTP_ACCEPTED);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $info = $this->infos->update($id, [
            'general' => $request->general,
            'rus' => $request->rus,
            'pool' => $request->pool,
            'halls' => $request->halls,
            'other' => $request->other,
        ]);

        return response()->json([
            'success' => 'Информация успешно изменена',
            'info' => new adminInfoResource($info),
        ], Response::HTTP_ACCEPTED);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */


    public function destroy($id)
    {
        //
    }
}
