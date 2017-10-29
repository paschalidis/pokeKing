<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>PokeKing</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <!-- Content here -->
    <div class="row">
            <table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead class="thead-inverse">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Height</th>
                        <th>Weight</th>
                        <th>Base Exp</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pokemons as $pokemon)
                    <tr>
                        <td><img src="{{ $pokemon->image }}" alt="{{ $pokemon->name }}" class="img-fluid"></td>
                        <td>{{ $pokemon->name }}</td>
                        <td>{{ $pokemon->height }}</td>
                        <td>{{ $pokemon->weight }}</td>
                        <td>{{ $pokemon->base_experience }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
</div>
<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>