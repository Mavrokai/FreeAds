<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier l\'annonce') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form id="updateForm" action="{{ route('annonces.update', $annonce) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">


                        <div class="mb-4">
                            <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre</label>
                            <input type="text" name="titre" id="titre" value="{{ old('titre', $annonce->titre) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            @error('titre')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>{{ old('description', $annonce->description) }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="prix" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prix (€)</label>
                            <input type="number" name="prix" id="prix" value="{{ old('prix', $annonce->prix) }}" step="0.01" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            @error('prix')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Photos actuelles</label>

                            @if($annonce->photos->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                    @foreach($annonce->photos as $photo)
                                        <div class="relative group">
                                            <img src="{{ Storage::url($photo->chemin) }}" class="w-full h-32 object-cover rounded-md" alt="Photo de l'annonce">


                                            <div class="absolute top-1 right-1 z-50">
                                                <button type="button" class="delete-photo-btn bg-red-600 text-white p-1 rounded-full hover:bg-red-700"
                                                    title="Supprimer cette photo"
                                                    data-photo-id="{{ $photo->id }}">
                                                    x
                                                </button>
                                            </div>

                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-opacity flex items-center justify-center">
                                                <div class="hidden group-hover:flex space-x-2">
                                                    @if(!$photo->is_principale)
                                                        <form method="POST" action="{{ route('photos.main', $photo) }}">
                                                            @csrf
                                                            <button type="submit" class="bg-indigo-600 text-white p-1 rounded-full hover:bg-indigo-700" title="Définir comme principale">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="bg-indigo-600 text-white p-1 rounded-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($photo->is_principale)
                                                <div class="absolute top-0 right-0 bg-indigo-600 text-white text-xs px-1 py-0.5 rounded-bl-md">
                                                    Principale
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($annonce->photo)
                                <div class="mb-4">
                                    <img src="{{ Storage::url($annonce->photo) }}" alt="Photo actuelle" class="h-40 w-auto object-cover rounded-md">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Photo actuelle</p>
                                </div>
                            @else
                                <div class="text-gray-500 dark:text-gray-400 mb-4">
                                    Aucune photo disponible pour cette annonce.
                                </div>
                            @endif

                            <label for="photos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4 mb-2">Ajouter des photos</label>
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
                                Vous pouvez sélectionner plusieurs nouvelles images à ajouter.
                                @if($annonce->photos->count() == 0)
                                    La première image sera définie comme principale.
                                @endif
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
                            <button id="submitButton" type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Mettre à jour
                            </button>
                        </div>

                        <div id="form-debug-info" class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-md hidden">
                            <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300">Informations de débogage:</h4>
                            <pre id="debug-content" class="text-xs mt-2 overflow-auto max-h-40 text-gray-600 dark:text-gray-400"></pre>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('updateForm');
            const debugInfo = document.getElementById('form-debug-info');
            const debugContent = document.getElementById('debug-content');
            const submitButton = document.getElementById('submitButton');


            document.querySelectorAll('.delete-photo-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const photoId = this.getAttribute('data-photo-id');

                    if (confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')) {


                        const csrfToken = document.querySelector('input[name="_token"]').value;


                        fetch(`/photos/${photoId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erreur lors de la suppression de la photo');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {

                                const photoElement = this.closest('.group');
                                photoElement.remove();


                                const successAlert = document.createElement('div');
                                successAlert.className = 'bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded';
                                successAlert.innerHTML = '<p>Photo supprimée avec succès !</p>';

                                const container = document.querySelector('.max-w-3xl');
                                container.insertBefore(successAlert, container.firstChild);


                                setTimeout(() => {
                                    successAlert.style.transition = 'opacity 1s';
                                    successAlert.style.opacity = '0';
                                    setTimeout(() => {
                                        successAlert.remove();
                                    }, 1000);
                                }, 3000);
                            } else {
                                alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            alert('Erreur lors de la suppression de la photo');
                        });
                    }
                });
            });


            submitButton.addEventListener('click', function(e) {
                e.preventDefault();


                let methodInputExists = false;
                for(let input of form.elements) {
                    if(input.name === '_method' && input.value === 'PUT') {
                        methodInputExists = true;
                        break;
                    }
                }


                if(!methodInputExists) {
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                }



                submitButton.textContent = 'Mise à jour en cours...';
                submitButton.disabled = true;

                try {

                    debugInfo.classList.remove('hidden');

                    const formData = new FormData(form);
                    let formValues = {};

                    for (let [key, value] of formData.entries()) {
                        if (key !== '_token' && key !== '_method') {
                            formValues[key] = value instanceof File ? value.name : value;
                        }
                    }

                    debugContent.textContent = 'Soumission du formulaire avec les données suivantes:\n' +
                                              JSON.stringify(formValues, null, 2) + '\n\n' +
                                              'URL de soumission: ' + form.action + '\n' +
                                              'Méthode HTTP: PUT (via _method)';

                    console.log('Formulaire soumis:', formValues);


                    setTimeout(() => {
                        form.submit();
                    }, 500);
                } catch (error) {
                    console.error("Erreur lors de la soumission:", error);

                    form.submit();
                }
            });


            form.addEventListener('submit', function(e) {
            });
        });
    </script>
</x-app-layout>
