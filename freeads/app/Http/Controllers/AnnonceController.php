<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AnnonceController extends Controller
{
    use AuthorizesRequests;


    public function index()
    {
        $annonces = Annonce::with('photos')->latest()->paginate(12);
        return view('liste-annonces', compact('annonces'));
    }


    public function create()
    {
        return view('annonces.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);


        $annonce = new Annonce([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'prix' => $validated['prix'],
            'user_id' => Auth::id(),
        ]);

        $annonce->save();


        if ($request->hasFile('photos')) {
            $this->savePhotos($request->file('photos'), $annonce);
        }

        return redirect()->route('annonces.show', $annonce)
            ->with('success', 'Annonce créée avec succès !');
    }



    public function show(Annonce $annonce)
    {
        $annonce->load('photos', 'user');
        return view('annonces.show', compact('annonce'));
    }



    public function edit(Annonce $annonce)
    {
        $this->authorize('update', $annonce);
        return view('annonces.edit', compact('annonce'));
    }



    public function update(Request $request, Annonce $annonce)
    {
        $this->authorize('update', $annonce);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);


        $annonce->update([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'prix' => $validated['prix'],
        ]);


        if ($request->hasFile('photos')) {
            $this->savePhotos($request->file('photos'), $annonce);
        }

        return redirect()->route('annonces.show', $annonce)
            ->with('success', 'Annonce mise à jour avec succès !');
    }



    public function destroy(Annonce $annonce)
    {
        $this->authorize('delete', $annonce);


        foreach ($annonce->photos as $photo) {
            if (Storage::exists($photo->chemin)) {
                Storage::delete($photo->chemin);
            }
        }


        $annonce->delete();

        return redirect()->route('liste-annonces')
            ->with('success', 'Annonce supprimée avec succès !');
    }



    private function savePhotos($photos, Annonce $annonce)
    {
        $firstPhoto = true;


        if ($annonce->photos()->count() > 0) {
            $firstPhoto = false;
        }

        foreach ($photos as $photo) {

            $filename = uniqid() . '_' . $photo->getClientOriginalName();


            $path = $photo->storeAs('photos/annonces', $filename, 'public');


            $photoModel = new Photo([
                'chemin' => $path,
                'is_principale' => $firstPhoto,
                'ordre' => $annonce->photos()->count() + 1,
                'annonce_id' => $annonce->id,
            ]);

            $photoModel->save();


            $firstPhoto = false;
        }
    }
}
