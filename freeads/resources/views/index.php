<?php

use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreeAds - Trouvez près de chez vous</title>


    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0f172a',
                        accent: '#1e293b',
                        highlight: '#3b82f6'
                    }
                }
            }
        }
    </script>


    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-primary text-gray-200 flex flex-col min-h-screen">





    <nav class="bg-primary shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-8">
                <a href="/" class="text-2xl font-bold text-white">FreeAds</a>
                <a href="<?= route('livewire.annonces.liste') ?>" class="text-gray-300 hover:text-white transition">Annonces</a>
            </div>
            <div class="flex items-center space-x-4">
                <?php if (!Auth::check()): ?>
                    <a href="<?= route('login') ?>" class="text-gray-300 hover:text-white transition">Connexion</a>
                    <a href="<?= route('register') ?>" class="px-4 py-2 bg-highlight text-white rounded-lg hover:bg-opacity-90 transition">Créer un compte</a>
                <?php else: ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none text-gray-300">
                            <span><?= Auth::user()->name ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 bg-accent rounded-lg shadow-lg py-2 w-48">
                            <a href="<?= route('settings.profile') ?>" class="block px-4 py-2 text-gray-200 hover:bg-primary">Profil</a>
                            <form method="POST" action="<?= route('logout') ?>" class="mt-1">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-200 hover:bg-primary">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>



    <header class="flex-1 bg-cover bg-center" style="background-image: url('https://source.unsplash.com/1600x900/?night,marketplace');">
        <div class="container mx-auto px-6 py-32 text-center">
            <h1 class="text-5xl lg:text-6xl font-bold text-white drop-shadow-lg mb-4">Trouvez ce dont vous avez besoin<br>près de chez vous</h1>
            <p class="text-xl text-gray-300 mb-8">Rejoignez notre communauté et découvrez des opportunités locales</p>
            <a href="#" class="px-8 py-4 bg-highlight text-white rounded-full text-lg font-semibold hover:bg-opacity-90 transition">Commencer maintenant</a>
        </div>
    </header>



    <section class="container mx-auto px-6 py-16">
        <div class="grid gap-8 md:grid-cols-3 text-center">
            <div class="p-6 bg-accent rounded-xl shadow-lg hover:shadow-2xl transition">
                <svg class="h-12 w-12 mx-auto mb-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2s-3 1.343-3 3 1.343 3 3 3zM6 22h12a2 2 0 002-2v-5a4 4 0 00-4-4H8a4 4 0 00-4 4v5a2 2 0 002 2z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-white">Simplicité & Rapidité</h3>
                <p class="text-gray-400">Publiez vos annonces en quelques minutes seulement.</p>
            </div>
            <div class="p-6 bg-accent rounded-xl shadow-lg hover:shadow-2xl transition">
                <svg class="h-12 w-12 mx-auto mb-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3c0 2-3 4-3 4s-3-2-3-4zM12 11V2m0 0L9 5m3-3l3 3" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-white">Sécurité</h3>
                <p class="text-gray-400">Transactions protégées et vérifiées.</p>
            </div>
            <div class="p-6 bg-accent rounded-xl shadow-lg hover:shadow-2xl transition">
                <svg class="h-12 w-12 mx-auto mb-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13 21.314l-4.657-4.657a8 8 0 1111.314 0z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-white">Localité</h3>
                <p class="text-gray-400">Découvrez des offres près de chez vous.</p>
            </div>
        </div>
    </section>




    <section class="py-16 text-center text-white bg-primary">
        <h2 class="text-3xl font-bold mb-4">Prêt à commencer ?</h2>
        <p class="mb-6">Rejoignez-nous dès maintenant et explorez des milliers d'annonces locales.</p>
        <a href="<?= route('register') ?>" class="px-10 py-4 bg-highlight text-white font-semibold rounded-full hover:bg-opacity-90 transition">Créer un compte</a>
    </section>




    <footer class="mt-auto bg-primary py-6">
        <div class="container mx-auto px-6 text-center text-gray-500">
            © <?= date('Y') ?> FreeAds. Tous droits réservés.
        </div>
    </footer>


</body>

</html>
