<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Annonces</h2>
                <div class="flex space-x-4">
                    <div>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher..."
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>
                    <a href="{{ route('annonces.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Nouvelle annonce
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($annonces as $annonce)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <div class="relative h-48">
                            @if ($annonce->photoPrincipale)
                                <img src="{{ Storage::url($annonce->photoPrincipale) }}" alt="{{ $annonce->titre }}" class="w-1/3 h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-500 dark:text-gray-400">Pas d'image</span>
                                </div>
                            @endif
                            <div class="absolute top-0 right-0 p-2 bg-indigo-600 text-white font-bold rounded-bl-lg">
                                {{ number_format($annonce->prix, 2, ',', ' ') }} €
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white truncate">{{ $annonce->titre }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 line-clamp-3">{{ $annonce->description }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $annonce->created_at->format('d/m/Y') }}
                                </span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('annonces.show', $annonce) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Détails
                                    </a>
                                    @can('update', $annonce)
                                        <a href="{{ route('annonces.edit', $annonce) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                            Modifier
                                        </a>
                                    @endcan
                                    @can('delete', $annonce)
                                        <button type="button"
                                            x-data="{}"
                                            x-on:click="$dispatch('open-modal', 'confirm-annonce-deletion-{{ $annonce->id }}')"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Supprimer
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>

                    @can('delete', $annonce)
                        <x-modal name="confirm-annonce-deletion-{{ $annonce->id }}" focusable>
                            <form method="post" action="{{ route('annonces.destroy', $annonce) }}" class="p-6">
                                @csrf
                                @method('delete')
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Êtes-vous sûr de vouloir supprimer cette annonce ?
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Cette action est irréversible. Toutes les données liées à cette annonce seront supprimées définitivement.
                                </p>
                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        Annuler
                                    </x-secondary-button>
                                    <x-danger-button class="ml-3">
                                        Supprimer l'annonce
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    @endcan
                @empty
                    <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <p class="text-gray-500 dark:text-gray-400">Aucune annonce trouvée</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $annonces->links() }}
            </div>
        </div>
    </div>
</div>
