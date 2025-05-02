<?php

namespace App\Livewire\Annonces;

use App\Models\Annonce;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormulaireAnnonce extends Component
{
    use WithFileUploads;

    public $annonce;
    public $titre = '';
    public $description = '';
    public $prix = '';
    public $photo;
    public $photoActuelle;
    public $tag = '';

    public function mount(?Annonce $annonce = null)
    {
        if ($annonce->exists) {
            $this->annonce = $annonce;
            $this->titre = $annonce->titre;
            $this->description = $annonce->description;
            $this->prix = $annonce->prix;
            $this->photoActuelle = $annonce->photo;
            $this->tag = $annonce->tag;
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'tag' => 'nullable|string|max:255',
            'photo' => $this->annonce && $this->annonce->exists
                ? 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                : 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $photoPath = $this->photoActuelle;

        if ($this->photo) {

            if ($this->annonce && $this->annonce->exists && $this->annonce->photo) {
                Storage::disk('public')->delete($this->annonce->photo);
            }

            $photoPath = $this->photo->store('annonces/images', 'public');
        }

        $data = [
            'titre' => $this->titre,
            'description' => $this->description,
            'prix' => $this->prix,
            'tag' => $this->tag,
            'user_id' => Auth::id(),
        ];

        if ($photoPath) {
            $data['photo'] = $photoPath;
        }

        if ($this->annonce && $this->annonce->exists) {
            $this->annonce->update($data);
            session()->flash('success', 'Annonce mise à jour avec succès!');
        } else {
            Annonce::create($data);
            session()->flash('success', 'Annonce créée avec succès!');
        }

        return redirect()->route('livewire.annonces.liste');
    }

    public function render(): View
    {
        return view('livewire.annonces.formulaire-annonce');
    }
}
