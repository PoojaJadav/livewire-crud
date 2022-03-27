<?php

namespace App\Http\Livewire;

trait ModelManager
{
    public $previousUrl;

    public function getEditingProperty()
    {
        return $this->model->exists;
    }

    public function submit()
    {
        $this->resetErrorBag();

        return $this->editing ? $this->update() : $this->store();
    }

    protected function saved()
    {
        $this->emit('saved');
    }
}
