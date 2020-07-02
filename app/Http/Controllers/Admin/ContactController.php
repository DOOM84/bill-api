<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\adminContactResource;
use App\Repositories\Contracts\IContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    protected $contacts;

    public function __construct(IContact $contacts)
    {
        $this->contacts = $contacts;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'contact' =>  new adminContactResource($this->contacts->findFirst())
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
        $contact = $this->contacts->create([
            'address' => $request->address,
            'phone' => $request->phone,
            'terms' => $request->terms,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => 'Информация успешно создана',
            'contact' => new adminContactResource($contact),
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
        $contact = $this->contacts->update($id, [
            'address' => $request->address,
            'phone' => $request->phone,
            'terms' => $request->terms,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => 'Информация успешно изменена',
            'contact' => new adminContactResource($contact),
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
