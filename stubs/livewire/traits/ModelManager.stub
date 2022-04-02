<?php

namespace App\Http\Livewire;

trait ModelManager
{
    use HasModal;

    public $previousUrl;

    public $model;

    public function getEditingProperty()
    {
        return $this->model->exists;
    }

    public function hydrateModelManager()
    {
        $className = str_replace('\\', '.', str_after(static::class, 'App\Http\Livewire\\'));
        $this->listeners = array_merge($this->listeners, [
            "$className.create" => 'create',
            "$className.edit"   => 'edit',
            "$className.delete" => 'delete',
        ]);
    }

    public function create()
    {
        $this->editing = false;

        $this->model = new self::$modelName;

        $this->resetErrorBag();
        $this->open();
    }

    public function edit($id)
    {
        $this->editing = true;

        $this->model = self::$modelName::find($id);

        $this->resetErrorBag();
        $this->open();
    }

    public function delete($id)
    {
        $this->model = self::$modelName::find($id);

        // confirm delete modal

        $this->destroy();
    }

    public function submit()
    {
        $this->editing
            ? $this->update()
            : $this->store();
    }

    protected function saved()
    {
        $this->emit('saved');
    }
}
