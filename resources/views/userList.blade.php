<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Example GO REST API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="/css/main.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body" style="padding:0">
                <table class="table table-hover" style="margin:0">
                    <thead class="table-custom">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th style="width:fit-content"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                        <tr>
                            <td width="5%">{{$user['id']}}</td>
                            <td>{{$user['name']}}</td>
                            <td>{{$user['email']}}</td>
                            <td width="10%">{{$user['gender']}}</td>
                            <td width="10%">{{$user['status']}}</td>
                            <td width="10%"><a href={{"../../userTodos/".$user['id']}}><button class="btn btn-primary">VIEW TODO</a></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div style="float:left;margin-top:10px">
            @if($page > 1)<a href={{"/users/page/".$page-1}}><button class="btn btn-secondary">back</button></a>@endif
            @if($page < $totalPages)<a href={{"/users/page/".$page+1}}><button class="btn btn-secondary">next</button></a>@endif
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>