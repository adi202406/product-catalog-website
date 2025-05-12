<?php

namespace App\Livewire;

use App\Models\Queue;
use Livewire\Component;
use Illuminate\Support\Carbon;

class QueueListToday extends Component
{
    public $queues;

    public function mount()
    {
        $this->queues = Queue::withCount('items')
            ->with('items')
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.queue-list-today');
    }
}

