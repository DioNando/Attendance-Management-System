<?php

namespace App\Livewire\Pages\Guests;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentScan extends Component
{
    public $event;
    public $recentScans = [];
    public $limit = 10;

    protected $listeners = ['scanProcessed' => 'loadRecentScans'];

    public function mount($event = null)
    {
        $this->event = $event;
        $this->loadRecentScans();
    }

    public function loadRecentScans()
    {
        if (!$this->event) {
            $this->recentScans = [];
            return;
        }

        $this->recentScans = Attendance::where('event_id', $this->event->id)
            ->with(['guest', 'checkedInBy'])
            ->latest()
            ->take($this->limit)
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'guest' => [
                        'first_name' => $attendance->guest->first_name,
                        'last_name' => $attendance->guest->last_name,
                        'qr_code' => $attendance->guest->qr_code,
                    ],
                    'created_at' => $attendance->created_at->diffForHumans(),
                    'scanned_by_name' => $attendance->checkedInBy->first_name . ' ' . $attendance->checkedInBy->last_name ?? 'N/A',
                ];
            });
    }

    public function render()
    {
        return view('livewire.pages.guests.recent-scan');
    }
}
