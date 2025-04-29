<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>
    <form method="POST" action="{{ route('register') }}">

    <input name="name"     placeholder="Nom"     value="{{ old('name') }}" required>
    <input name="email"    placeholder="Email"    value="{{ old('email') }}" required>
    <input name="password" type="password"        placeholder="Mot de passe" required>
    <input name="password_confirmation" type="password" placeholder="Confirmer mot de passe" required>
    <button type="submit">S’inscrire</button>
</form>
    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
</body>

</html>
