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
            {{-- @foreach ($result as $page)--}}
            @foreach ($result as $item)

            <tr>
                <td>{{$item->name}}</td>
                <td>{{$item->id}}</td>
                <td>{{$item->address}}</td>
                <td>{{$item->explicit_location}}</td>
                <td>{{$item->rating}}</td>
                <td>{{$item->reviews}}</td>
                <td>@php echo (str_replace('_', ' ',implode(", ", json_decode($item->types)))) @endphp </td>
            </tr>
            {{-- @endforeach --}}
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
    <div class="error">
        <ul>
            <li style="list-style-type: none;">Erro: {{$apiError}} </li>
        </ul>
    </div>
    @endisset

    @show

    @extends('template.footer')
</body>

</html>
