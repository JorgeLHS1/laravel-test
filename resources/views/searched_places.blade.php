@extends('layouts.app')

@section('content')

<body>

    @section('list')
    <table id="queryTable" class="styledTable" cellspacing=0>
        <thead>
            <tr>
                <th>Email</th>
                <th>Nome</th>
                <th>Query</th>
            </tr>
        </thead>
        <tbody>
            @isset($result)
            @foreach ($result as $item)

            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
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

    @if(isset($apiError))
    <div class="error">
        <ul>
            <li style="list-style-type: none;">Erro: {{$apiError}} </li>
        </ul>
    </div>
    @endif

    @show

    <script>
        function insertQuery(query, userEmail, userName) {
        var tableBody = document.getElementById("queryTable").getElementsByTagName("tbody")[0];

            var row = tableBody.insertRow(-1);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.innerHTML = userEmail;
            cell2.innerHTML = userName;
            cell3.innerHTML = query;
    }

    </script>
    @endsection

</body>

</html>
