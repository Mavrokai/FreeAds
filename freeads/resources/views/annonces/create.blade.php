<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Créer une annonce') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data" id="createAnnonceForm">
                        @csrf
                        <input type="hidden" name="tags" id="tagsInput" value="{{ old('tags') }}">

                        <div class="mb-4">
                            <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                            <input type="text" name="titre" id="titre" value="{{ old('titre') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            @error('titre')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="prix" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prix (€)</label>
                            <input type="number" name="prix" id="prix" value="{{ old('prix') }}" step="0.01" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            @error('prix')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
                            <div id="selected-tags" class="flex flex-wrap gap-2 mb-2">

                            </div>
                            <select id="tags" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Choisir un tag</option>
                                <option value="informatique">Informatique</option>
                                <option value="numérique">Numérique</option>
                                <option value="animaux">Animaux</option>
                                <option value="outils">Outils</option>
                            </select>
                            @error('tags')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="photos" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photos</label>
                            <input type="file" name="photos[]" id="photos" multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                dark:file:bg-indigo-900 dark:file:text-indigo-300">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Formats acceptés: jpeg, png, jpg, gif, webp. Max: 2MB par image. <br>
                                Vous pouvez sélectionner plusieurs images. La première image sera définie comme principale.
                            </p>
                            @error('photos')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                            @error('photos.*')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('livewire.annonces.liste') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Annuler
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagsSelect = document.getElementById('tags');
            const selectedTagsContainer = document.getElementById('selected-tags');
            const tagsInput = document.getElementById('tagsInput');

            tagsSelect.addEventListener('change', function() {
                const selectedValue = tagsSelect.value;

                if (selectedValue && !Array.from(selectedTagsContainer.children).some(tag => tag.dataset.value === selectedValue)) {
                    const tagElement = document.createElement('div');
                    tagElement.className = 'bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full flex items-center gap-2';
                    tagElement.dataset.value = selectedValue;

                    const tagText = document.createElement('span');
                    tagText.textContent = selectedValue;

                    const removeButton = document.createElement('button');
                    removeButton.className = 'text-red-500 hover:text-red-700';
                    removeButton.textContent = '×';
                    removeButton.addEventListener('click', function() {
                        tagElement.remove();
                        updateTagsInput();
                    });

                    tagElement.appendChild(tagText);
                    tagElement.appendChild(removeButton);
                    selectedTagsContainer.appendChild(tagElement);

                    tagsSelect.value = '';
                    updateTagsInput();
                }
            });

            function updateTagsInput() {
                const selectedTags = Array.from(selectedTagsContainer.children).map(tag => tag.dataset.value);
                tagsInput.value = selectedTags.join(',');
            }
        });
    </script>
</x-app-layout>
