<?php

namespace App\Http\Livewire;

trait WithSorting
{
    public $sort_by;
    public $sort_direction = 'asc';

    protected $queryStringWithSorting = [
        'sort_direction' => ['except' => 'asc'],
    ];

    public function hydrateWithSorting()
    {
        $this->queryString = array_merge($this->queryString, [
            'sort_by', 'sort_direction',
        ]);
    }

    public function sortBy($field)
    {
        $this->sort_direction = $this->sort_by === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sort_by = $field;
    }

    private function reverseSort()
    {
        return $this->sort_direction === 'asc'
            ? 'desc'
            : 'asc';
    }
}
