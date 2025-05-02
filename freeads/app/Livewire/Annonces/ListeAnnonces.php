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

    public $filters = [
        'min_price' => null,
        'max_price' => null,
        'tag' => null,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilters()
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
            ->when($this->filters['min_price'], function ($query, $minPrice) {
                return $query->where('prix', '>=', $minPrice);
            })
            ->when($this->filters['max_price'], function ($query, $maxPrice) {
                return $query->where('prix', '<=', $maxPrice);
            })
            ->when($this->filters['tag'], function ($query, $tag) {
                return $query->where('tag', $tag);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.annonces.liste-annonces', [
            'annonces' => $annonces,
        ]);
    }
}
