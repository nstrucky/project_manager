<?php

namespace App\Listeners;

use App\Events\TestNoteCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestNotes
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestNoteCreated  $event
     * @return void
     */
    public function created(TestNoteCreated $event)
    {
        //do something with $event->note
        return response()->json(['note' => $event->note]);
    }
}
