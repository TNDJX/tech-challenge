<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index(): View
    {
        /** @var \App\User $user */
        $user = auth()->user();

        abort_if(! $user, 403);

        $clients = $user->clients;

        return view('clients.index', ['clients' => $clients]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $user = auth()->id();
        /**
         * TODO: Question re bookings orders do we want newest first as in the readme?
         *  or we would like to see bookings ordered by their start date
         */
        $client = Client::where('id', $client)
            ->with([
                'bookings' => function (HasMany $query) {
                    $query->latest();
                }
            ])
            ->first();

        abort_if($client->user_id !== $user, 403);

        return view('clients.show', ['client' => $client]);
    }

    public function store(StoreClientRequest $request): Client
    {
        $client = new Client;
        $client->user()
            ->associate(auth()->user());
        $client->fill($request->validated());
        $client->save();

        return $client;
    }

    public function destroy($client): Response
    {
        Client::where('id', $client)
            ->delete();

        return response()->noContent();
    }
}
