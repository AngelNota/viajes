<?php

namespace App\Livewire;

use Livewire\Component;

class SidebarMenu extends Component
{
    public $open = false;

    protected $listeners = [
        'toggleSidebar' => 'toggle',
    ];

    public function toggle()
    {
        $this->open = ! $this->open;
    }

    public function render()
    {
        return view('livewire.sidebar-menu');
    }
}
