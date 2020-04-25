<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Category;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;


class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified'])->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = $this->getUser();
        $events = Event::with('user','categories')
            ->orderBy('event_start_date','desc')
            ->paginate(10);
        return view('event.index', compact('events','current_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('event.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $eventRequest)
    {
        $event = Event::create($this->inputNameChange($eventRequest));
        if ($event && $event instanceof Event) {
            $categories = $eventRequest->get('categories');
            if(is_array($categories) && count($categories)>0){
                $event->categories()->attach($categories);
            }
        }

        return redirect('/event')->with('status','Event Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $redis_event_views = Redis::get('event:id:'.$event->event_id);
        $event_views = (isset($redis_event_views))?(int)$redis_event_views+1:1;
        Redis::set('event:id:'.$event->event_id,$event_views);
        $current_user = $this->getUser();
        return view('event.show',compact('event','current_user','event_views'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        $eventCategories = $event->categories->pluck('category_id')->toArray();
        $images = array();
        if(File::exists($path = public_path('images\events\e' . $event->event_id))) {
            $files = File::files($path);
            foreach ($files as $file) {
                $images[] = $file->getFilename();
            }
        }

        return view('event.edit',compact('event','eventCategories','categories','images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $eventRequest,Event $event)
    {
        if( $event->user_id != $this->getUser()['id'] && $this->getUser()['role'] != 'admin')
            abort(403,'Permission denied for this action!');

        $updateResult = $event->update($this->inputNameChange($eventRequest));
        if ($updateResult) {
            $categories = $eventRequest->get('categories');
            if(is_array($categories) && count($categories)>0){
                $event->categories()->attach($categories);
            }
        }

        return back()->with('status','Event Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if( $event->user_id != $this->getUser()['id'] && $this->getUser()['role'] != 'admin')
            abort(403,'Permission denied for this action!');

        $event->delete();
        return back()->with('status','Event Deleted Successfully');
    }

    /**
     * Return Clean Data
     *
     */
    protected function inputNameChange($eventRequest){
        return [
            'user_id' => $this->getUser()['id'],
            'event_title' => $eventRequest->get('title'),
            'event_start_date' => $eventRequest->get('start_date'),
            'event_end_date' => $eventRequest->get('end_date'),
            'event_location' => $eventRequest->get('location'),
            'event_price' => $eventRequest->get('price'),
            'event_description' => $eventRequest->get('description'),
        ];
    }

    protected function getUser(){
        return array(
            'id'   => isset(auth()->user()->id)?auth()->user()->id:'',
            'role' => isset(auth()->user()->role)?auth()->user()->role:'',
        );
    }
}
