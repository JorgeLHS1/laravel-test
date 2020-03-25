@extends('template.header')

<body>
    <h1>List Places</h1>

    @section('form')
    <form action="{{ route('list') }}" method="POST">
        @csrf
        <label for="text_query">Query de Consulta</label>
        <input type="text" name="text_query" placeholder="Dentista" />

        <label for="api_key">API KEY(Google Maps)</label>


    <input type="text" name="api_key" @isset($apiKey) placeholder="{{$apiKey}}" value="{{$apiKey}}" @endisset />

        <input type="submit" name="submit" value="Buscar lugares" />
    </form>
    @show

    @section('list')
    <table class="styledTable" cellspacing=0>
        <thead>
            <tr>
                <th>Nome</th>
                <th>ID</th>
                <th>Endereço</th>
                <th>Vila</th>
                <th>Nota</th>
                <th>Avaliações</th>
                <th>Categorias</th>
            </tr>
        </thead>
        <tbody>
            @isset($result)
            @foreach ($result->results as $item)
            <tr>
                <td>{{$item->name}}</td>
                <td>{{$item->place_id}}</td>
                <td>{{$item->formatted_address}}</td>
                <td>{{$item->plus_code->compound_code}}</td>
                <td>{{$item->rating}}</td>
                <td>{{$item->user_ratings_total}}</td>
                <td><?php echo (implode(", ", $item->types)); ?></td>
            </tr>
            @endforeach
            @endisset
        </tbody>
    </table>
    @isset($error)
    <div class="error">
        {{$error}}
    </div>
    @endisset
    @show

    @extends('template.footer')
</body>

</html>
