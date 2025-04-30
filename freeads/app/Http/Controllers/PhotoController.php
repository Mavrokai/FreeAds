<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PhotoController extends Controller
{
    use AuthorizesRequests;


    public function setMain(Photo $photo)
    {

        $this->authorize('update', $photo->annonce);


        Photo::where('annonce_id', $photo->annonce_id)
            ->update(['is_principale' => false]);


            $photo->is_principale = true;
        $photo->save();

        return back()->with('success', 'Photo principale définie avec succès');
    }



    public function destroy(Photo $photo)
    {

        $this->authorize('update', $photo->annonce);


        $annonce = $photo->annonce;


        if ($photo->is_principale && $annonce->photos->count() > 1) {

            $newMainPhoto = $annonce->photos->where('id', '!=', $photo->id)->first();
            if ($newMainPhoto) {
                $newMainPhoto->is_principale = true;
                $newMainPhoto->save();
            }
        }


        if (Storage::exists($photo->chemin)) {
            Storage::delete($photo->chemin);
        }


        $photo->delete();


        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Photo supprimée avec succès'
            ]);
        }


        return back()->with('success', 'Photo supprimée avec succès');
    }
}
