<div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-8">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ $annonce && $annonce->exists ? 'Modifier l\'annonce' : 'Créer une annonce' }}
                </h2>
            </div>

            <form wire:submit="save" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <div class="mb-4">
                    <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                    <input type="text" id="titre" wire:model="titre"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    @error('titre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea id="description" wire:model="description" rows="5"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="prix" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prix (€)</label>
                    <input type="number" id="prix" wire:model="prix" step="0.01" min="0"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    @error('prix') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="tag" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tag</label>
                    <select id="tag" wire:model="tag" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Choisir un tag</option>
                        <option value="informatique">Informatique</option>
                        <option value="numérique">Numérique</option>
                        <option value="animaux">Animaux</option>
                        <option value="outils">Outils</option>
                    </select>
                    @error('tag') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photo</label>

                    @if ($photoActuelle)
                        <div class="mt-2 mb-4">
                            <img src="{{ Storage::url($photoActuelle) }}" alt="Photo actuelle" class="h-40 w-auto object-cover rounded-md">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Photo actuelle</p>
                        </div>
                    @endif

                    <input type="file" id="photo" wire:model="photo" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100
                        dark:file:bg-indigo-900 dark:file:text-indigo-300" />

                    @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    <div wire:loading wire:target="photo" class="mt-2">
                        <span class="text-sm text-indigo-600 dark:text-indigo-400">Chargement de l'image...</span>
                    </div>

                    @if ($photo)
                        <div class="mt-2">
                            <img src="{{ $photo->temporaryUrl() }}" alt="Aperçu" class="h-40 w-auto object-cover rounded-md">
                        </div>
                    @endif
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('livewire.annonces.liste') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Annuler
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ $annonce && $annonce->exists ? 'Mettre à jour' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
