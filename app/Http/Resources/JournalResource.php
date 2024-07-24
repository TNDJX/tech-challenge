<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var \App\Journal $journal */
        $journal = $this->resource;

        return [
            'id' => $journal->id,
            'date' => $journal->date->format('Y-m-d'),
            'content' => $journal->content,
        ];
    }
}
