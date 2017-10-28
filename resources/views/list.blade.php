<!doctype html>
<html>
    <body>
        <h1>Hello, The name</h1>
        @foreach ($pokemons as $pokemon)
            <p>This is pokemon {{ $pokemon->name }}</p>
        @endforeach
    </body>
</html>