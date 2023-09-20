<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FavouriteNotificationEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_title' => $this->event_title,
            'event_date' => $this->event_date,
            'event_time' => $this->event_time,
            'link_to_event_stream' => $this->link_to_event_stream,
            'event_duration' => $this->event_duration,
            'event_status' => $this->event_status,
            'event_count' => $this->event_count,
            'event_image' =>  $this->event_image?asset('eventimages/'.$this->event_image):Null,
            'genre' => $this->genre,
            'event_description' =>$this->event_description
        ];
    }
}
