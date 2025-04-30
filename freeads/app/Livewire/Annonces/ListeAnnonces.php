<?php

namespace App\Livewire\Annonces;

use App\Models\Annonce;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ListeAnnonces extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $annonces = Annonce::query()
            ->with('photos')
            ->when($this->search, function ($query, $search) {
                return $query->where('titre', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.annonces.liste-annonces', [
            'annonces' => $annonces,
        ]);
    }
}
