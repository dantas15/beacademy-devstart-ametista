<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <title>{{$user->name}}</title>
</head>
<body>
    <h1 class= "container">{{$user->name}}</h1>
    <table class="table container" >
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">e-mail</th>
                    <th scope="col">Data Cadastro</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{date('d/m/Y', strtotime($user->created_at))}}</td>
                        <td>
                            <a href="" class="btn btn-warning text-white">Editar</a>
                            <a href="" class="btn btn-danger text-white">Deletar</a>
                        </td>
                    </tr>
            </tbody>
        </table>
    
</body>
</html>