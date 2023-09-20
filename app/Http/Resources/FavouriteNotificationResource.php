<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FavouriteNotificationEventResource;

class FavouriteNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $current_date = now()->format('Y-m-d');
        $artist_id = $this->favourite->artist_id;
        $event_list = Event::where('user_id',$artist_id)->where('event_date','>=',$current_date)->get();

        $items = FavouriteNotificationEventResource::collection($event_list);
        return [
            'id' => $this->id,
            'description' => $this->description,
            'favourite_id' => $this->favourite_id,
            'status' => $this->status,
            'notify_status' => $this->status?'Sended':'Not Send',
            'type' => $this->type,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->first_name.' '.optional($this->user)->last_name,
            'user_type' => optional($this->user)->user_type,
            'event_list' => $items,
        ];
    }
}
