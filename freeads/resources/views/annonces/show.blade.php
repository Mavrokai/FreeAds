<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $annonce->titre }}
            </h2>
            <a href="{{ route('livewire.annonces.liste') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Retour aux annonces
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            @if($annonce->photos->count() > 0)
                                <div class="mb-4">
                                    @php
                                        $mainPhoto = $annonce->photoPrincipale() ?? $annonce->photos->first();
                                    @endphp
                                    <img id="main-photo" src="{{ Storage::url($mainPhoto->chemin) }}" alt="{{ $annonce->titre }}" class="w-full h-auto object-cover rounded-lg">
                                </div>

                                @if($annonce->photos->count() > 1)
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach($annonce->photos->filter(fn($photo) => $photo->id !== $mainPhoto->id) as $photo)
                                            <img src="{{ Storage::url($photo->chemin) }}"
                                                 alt="Photo de l'annonce"
                                                 class="w-full h-16 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity"
                                                 onclick="document.getElementById('main-photo').src='{{ Storage::url($photo->chemin) }}'">
                                        @endforeach
                                    </div>
                                @endif
                            @elseif($annonce->photo)
                                <img src="{{ Storage::url($annonce->photo) }}" alt="{{ $annonce->titre }}" class="w-full h-auto object-cover rounded-lg">
                            @else
                                <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-lg">
                                    <span class="text-gray-500 dark:text-gray-400">Pas d'image</span>
                                </div>
                            @endif

                            <div class="mt-4 bg-indigo-600 text-white font-bold px-4 py-2 rounded-lg text-xl text-center">
                                {{ number_format($annonce->prix, 2, ',', ' ') }} €
                            </div>
                        </div>

                        <div>
                            <div class="mb-6">
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $annonce->titre }}</h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Publiée le {{ $annonce->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>

                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Description</h2>
                                <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ $annonce->description }}
                                </div>
                            </div>

                            <div class="mt-8 flex space-x-4">
                                @if(Auth::id() === $annonce->user_id)
                                    <a href="{{ route('annonces.edit', $annonce) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('annonces.destroy', $annonce) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                                <a href={{ route('livewire.annonces.liste') }}  class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Retour Au Annonces
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
