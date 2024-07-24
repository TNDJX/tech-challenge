<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreClientRequest;

class ClientsController extends Controller
{
    public function index()
    {
        /** @var \App\User $user */
        $user = auth()->user();

        abort_if(! $user, 403);

        $clients = $user->clients;

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $client = Client::where('id', $client)
            ->with('bookings')
            ->first();

        return view('clients.show', ['client' => $client]);
    }

    public function store(StoreClientRequest $request)
    {
        $client = new Client;
        $client->user()
            ->associate(auth()->user());
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        Client::where('id', $client)
            ->delete();

        return 'Deleted';
    }
}
