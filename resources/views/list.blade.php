<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>PokeKing</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container">
    <!-- Content here -->
    <div class="row">
        <h1>Pokemon Profiles</h1>
    </div>
    <div class="row">
        <div class="table-responsive" style="overflow-x: hidden;">
            <table id="pokemon_list" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead class="thead-inverse">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Base Exp</th>
                        <th>Height</th>
                        <th>Weight</th>
                    </tr>
                </thead>
                <tfoot class="thead-inverse">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Base Exp</th>
                    <th>Height</th>
                    <th>Weight</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($pokemons as $pokemon)
                    <tr>
                        <td><img src="{{ $pokemon->image }}" alt="{{ $pokemon->name }}" class="img-fluid"></td>
                        <td>{{ $pokemon->name }}</td>
                        <td>{{ $pokemon->base_experience }}</td>
                        <td>{{ $pokemon->height }}</td>
                        <td>{{ $pokemon->weight }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <button id="pokeKing" type="button" class="btn btn-info btn-lg">PokeKing</button>
    </div>
    <div class="row justify-content-md-center" style="padding: 50px;">
        <div class="card hidden-xl-down" style="width: 20rem;">
            <div class="card-header">
                PokeKing
            </div>
            <div class="card-block">
                <img id="pokeKingImage" class="card-img-top" style="width: -moz-fit-content;" src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/10007.png" alt="Card image cap">
            </div>
            <div class="card-block">
                <h4 id="pokeKingName" class="card-title">giratina-origin</h4>
            </div>
            <ul class="list-group list-group-flush">
                <li id="pokeKingStats" class="list-group-item">Stats: 343</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
        $('#pokemon_list').DataTable(
            {
                "pageLength": 5,
                "lengthMenu": [ 5, 10, 15, 20 ],
                "scrollX": false
            }
        );

        $("#pokeKing").click(function(e) {
            $.ajax({
                type: "GET",
                url: "/king/",
                success: function(response){

                    $('.card').removeClass("hidden-xl-down");

                    $('#pokeKingImage').attr("src", response.image);
                    $('#pokeKingName').text(response.name);
                    $('#pokeKingStats').text("Stats: " + response.stats);
                }
            });
        });
    });
</script>