<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreJournalRequest;
use App\Http\Resources\JournalResource;
use App\Journal;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class JournalsController extends Controller
{
    /**
     * Get all journals for client
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Client $client): AnonymousResourceCollection
    {
        return JournalResource::collection($client->journals);
    }

    /**
     * Store journal
     *
     * @param  \App\Http\Requests\StoreJournalRequest  $request
     * @param  \App\Client  $client
     * @return \App\Http\Resources\JournalResource
     */
    public function store(StoreJournalRequest $request, Client $client): JournalResource
    {
        $journal = new Journal();
        $journal->fill($request->validated());
        $journal->client()
            ->associate($client);
        $journal->save();

        return JournalResource::make($journal);
    }

    /**
     * Delete journal
     *
     * @param  \App\Client  $client
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, Journal $journal): Response
    {
        $journal->delete();

        return response()->noContent();
    }
}
