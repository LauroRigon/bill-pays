<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClient;
use App\Http\Requests\Client\UpdateClient;
use App\Http\Requests\Client\DeleteClient;
use App\Domains\Clients\Client;
use App\Domains\Clients\Repositories\ClientRepository;
use Illuminate\Database\Eloquent\Collection;

class ClientController extends Controller
{
    public function __construct(ClientRepository $repository)
    {
        $this->clientRep = $repository;
    }

    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = $this->clientRep->all();

        return response()->json($clients, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        $this->clientRep->create($request->input());

        return response()->json(null, 200);
    }

    /**
     * Return Client data to edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return response()->json($client, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClient $request, Client $client)
    {
        $this->clientRep->update($request->input(), $client->id);

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteClient $request, Client $client)
    {
        $this->clientRep->delete($client->id);

        return response()->json(null, 200);
    }

    /**
     * Remove many resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(DeleteClient $request)
    {
        $this->clientRep->deleteMany($request->all());

        return response()->json(null, 200);
    }
}
