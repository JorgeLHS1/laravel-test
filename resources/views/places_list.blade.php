@extends('template.header')

<body>
<h1><a href="{{route('index')}}">List Places</a></h1>

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
            @foreach ($result as $page)
            @foreach ($page->results as $item)

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
            @endforeach
            @endisset
        </tbody>
    </table>

    @if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
            <li style="list-style-type: none;">{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @isset($apiError)
    @foreach ($apiError as $error)
    <div class="error">
        <ul>
            <li style="list-style-type: none;">Status: {{$error->status}}. @isset($error->error_message)Mensagem:
                {{$error->error_message}} @endisset </li>
        </ul>
    </div>
    @endforeach
    @endisset

    @show

    @extends('template.footer')
</body>

</html>
