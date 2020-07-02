<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\adminPriceResource;
use App\Repositories\Contracts\IPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class PriceController extends Controller
{
    protected $prices;

    public function __construct(IPrice $prices)
    {
        $this->prices = $prices;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'prices' => adminPriceResource::collection($this->prices->all())
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
        $this->validate($request, [
            'term' => 'required',
            'rus' => 'required',
            'pool' => 'required',
            'hall' => 'required',
        ]);

        $price = $this->prices->create([
            'term' => $request->term,
            'rus' => $request->rus,
            'pool' => $request->pool,
            'hall' => $request->hall,
        ]);

        return response()->json([
            'success' => 'Информация успешно создана',
            'price' => new adminPriceResource($price),
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
        $this->validate($request, [
            'term' => 'required',
            'rus' => 'required',
            'pool' => 'required',
            'hall' => 'required',
        ]);

        $price = $this->prices->update($id, [
            'term' => $request->term,
            'rus' => $request->rus,
            'pool' => $request->pool,
            'hall' => $request->hall
        ]);

        return response()->json([
            'success' => 'Прайс успешно изменен',
            'price' => new adminPriceResource($price),
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
        $price = $this->prices->find($id);

        $this->prices->delete($price->id);

        return response()->json(['success' => 'Прайс успешно удален'], Response::HTTP_ACCEPTED);
    }
}
