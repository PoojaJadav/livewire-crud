<?php

namespace App\Http\Livewire;

trait HasModal
{
    public $show = false;

    public function hydrateHasModal()
    {
        $className = str_replace('\\', '.', str_after(static::class, 'App\Http\Livewire\\'));
        $this->listeners = array_merge($this->listeners, [
            "$className.modal.toggle" => 'toggle',
        ]);
    }

    public function toggle()
    {
        $this->show = ! $this->show;
    }

    public function open()
    {
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }
}
