<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FavouriteNotificationEventResource;

class EventBookingCancelNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        // $current_date = now()->format('Y-m-d');
        // $artist_id = $this->favourite->artist_id;
        // $event_list = Event::where('user_id',$artist_id)->where('event_date','>=',$current_date)->get();

        //$items = FavouriteNotificationEventResource::collection($event_list);
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->first_name.' '.optional($this->user)->last_name,
            'user_type' => optional($this->user)->user_type,
            'status' => $this->status,
            'notify_status' => $this->status?'Sended':'Not Send',
            'type' => $this->type,
            'booking_cancel' => [
                'id' =>$this->eventBooking->id,
                'artist_id' =>$this->eventBooking->artist_id,
                'artist_name' => optional($this->eventBooking->artist)->first_name.' '.optional($this->eventBooking->artist)->last_name,
                'event_id' =>$this->eventBooking->event_id,
                'amount'=> $this->eventBooking->amount,
                'status'=> $this->eventBooking->status,
                'event' => [
                        'id' => $this->eventBooking->event->id,
                        'event_title' => $this->eventBooking->event->event_title,
                        'event_date' => $this->eventBooking->event->event_date,
                        'event_time' => $this->eventBooking->event->event_time,
                        'link_to_event_stream' => $this->eventBooking->event->link_to_event_stream,
                        'event_duration' => $this->eventBooking->event->event_duration,
                        'event_status' => $this->eventBooking->event->event_status,
                        'event_count' => $this->eventBooking->event->event_count,
                        'event_image' =>  $this->eventBooking->event->event_image?asset('eventimages/'.$this->eventBooking->event->event_image):Null,
                        'genre' => $this->eventBooking->event->genre,
                        'event_description' =>$this->eventBooking->event->event_description
                ]
            ]
            
           
        ];
    }
}
