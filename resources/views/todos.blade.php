<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="/css/main.css" rel="stylesheet">
</head>

<body>
    <div id="notification"></div>
    <div class="container-fluid" style="padding:0">
        <form id="filterForm" action="{{ route('filter') }}" method="POST">
            <div id="filterResult"></div>
            @csrf
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <input type="hidden" class="token" id="token" value="{{ @csrf_token() }}">
                        <input type="text" class="form-control" name="user id" id="user_id" placeholder="User ID">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <select class="form-control" name="type" id="type">
                            <option selected disabled>User's What?</option>
                            <option value="profile">profile</option>
                            <option value="todos">todos</option>
                            <option value="posts">posts</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">FILTER</button>
                </div>
            </div>
        </form>
        <div style="float:right;margin-bottom:10px;width:100%;display:block">
            <button class="btn btn-secondary" style="float:right" data-bs-toggle="modal" data-bs-target="#AddTodoModal">ADD TODO FOR THIS USER</button>
        </div>
        @if(empty($data))
        <br><br>
        <div class="alert alert-danger">This user does not have any todos.</div>
        <a href="../../users/page/1"><button class="btn btn-primary">View User List</button></a>
        @else

        <div class="card">
            <div class="card-body" style="padding:0">
                <div class="table-responsive">
                    <table class="table table-hover" id="userTodo_list" style="margin:0">
                        <thead class="table-custom">
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Title</th>
                                <th>Due On</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0
                            @endphp
                            @foreach ($data as $todos)
                            <tr>
                                <td width="5%">{{$todos['id']}}</td>
                                <td>{{$todos['user_id']}}</td>
                                <td>{{$todos['title']}}</td>
                                <td>{{$todos['due_on']}}</td>
                                <td width="10%">{{$todos['status']}}</td>
                                <td width="10%"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditTodoModal{{$i}}">EDIT</a></button></td>
                                <td width="10%"><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#DeleteTodoModal{{$i}}">DELETE</button></td>
                            </tr>
                            @php
                            $i = $i+1;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="deleteModal">
                    @php
                    $x = 0
                    @endphp
                    @foreach ($data as $todo)
                    <!-- Delete User Modal -->
                    <div class="modal fade DeleteModal" id="DeleteTodoModal{{$x}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="todoResult"></div>
                                    <form class="deleteTodo_form" action="{{ route('deletetodo') }}" method="POST">
                                        @csrf
                                        <input type="hidden" class="token" id="token" value="{{ @csrf_token() }}">
                                        <input type="hidden" class="id" name="id" id="id" value="{{$todo['id']}}">
                                        <p>Are you sure you want to delete this User?
                                        <p>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">DELETE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Todos Modal -->
                    <div class="modal fade EditTodoModal" id="EditTodoModal{{$x}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Todo</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="todoResult" style="font-size:16px;font-weight:lighter"></div>
                                    <form class="editTodo_form" action="{{ route('edittodo') }}" method="POST">
                                        @csrf
                                        <input type="hidden" class="token" id="token" value="{{ @csrf_token() }}">
                                        <input type="hidden" class="id" name="id" id="id" value="{{$todo['id']}}">
                                        <input type="hidden" class="user_id" name="user_id" id="user_id" value="{{$todo['user_id']}}">
                                        <div class="form-group">
                                            <input type="text" class="form-control title" name="title" id="title" value="{{$todo['title']}}" placeholder="Title">
                                        </div>
                                        <div class="form-group">
                                            <input type="datetime-local" class="form-control due_on" name="due_on" id="due_on" value="{{ date('Y-m-d\TH:i', strtotime($todo['due_on'])) }}">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control status" name="status" id="status">
                                                <option disabled>-- select status --</option>
                                                @if($todo['status']=='pending')
                                                <option selected value="pending">pending</option>
                                                <option value="completed">completed</option>
                                                @else
                                                <option value="pending">pending</option>
                                                <option selected value="completed">completed</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-light">RESET</button>
                                            <button type="submit" class="btn btn-secondary">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $x = $x+1;
                    @endphp
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <div class="paginationButton">
            @if($page > 1)<a href={{"/todos/".$user_id."/".$page-1}}><button class="btn btn-secondary">back</button></a>@endif
            @if($page < $totalPages)<a href={{"/todos/".$user_id."/".$page+1}}><button class="btn btn-secondary">next</button></a>@endif
        </div>

        <!-- Add Todos Modal -->
        <div class="modal fade" id="AddTodoModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Todo for #{{$user_id}}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="todoResult"></div>
                        <form id="todo_form" action="{{ route('addtodo') }}" method="POST">
                            @csrf
                            <input type="hidden" id="token" value="{{ @csrf_token() }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <input type="datetime-local" class="form-control" name="due_on" id="due_on">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="status" id="status2">
                                    <option selected disabled>-- select status --</option>
                                    <option value="pending">pending</option>
                                    <option value="completed">completed</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="reset" class="btn btn-light">RESET</button>
                                <button type="submit" class="btn btn-secondary submit">ADD</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        $(document).on('submit', '#filterForm', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response) {
                    if (response.code == 400) {
                        let error = '<span style="color:#b34045">' + response.msg + '</span>';
                        $('#filterResult').html(error);
                    }
                    if (response.code == '200') {
                        window.location = response.url;
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('#filterResult').html(error);
                    }
                },
            });
        });
    </script>

    <script>
        $(document).on('submit', '#todo_form', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response) {
                    if (response.code == 400) {
                        let error = '<span style="color:#b34045">' + response.msg + '</span>';
                        $('#todoResult').html(error);
                    }
                    if (response.code == 200) {
                        $('.container-fluid').load(' .container-fluid');
                        $('#AddTodoModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-danger').addClass('alert alert-success');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('#todoResult').html(error);
                    }
                },
            });
        });
    </script>

    <script>
        $(document).on('submit', '.editTodo_form', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response) {
                    if (response.code == 400) {
                        let error = '<span style="color:#b34045">' + response.msg + '</span>';
                        $('.todoResult').html(error);
                    }
                    if (response.code == 200) {
                        $('.container-fluid').load(' .container-fluid');
                        $('.EditTodoModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-danger').addClass('alert alert-success');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('.todoResult').html(error);
                    }
                },
            });
        });
    </script>

    <script>
        $(document).on('submit', '.deleteTodo_form', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response) {
                    if (response.code == '200') {
                        $('.container-fluid').load(' .container-fluid');
                        $('.DeleteModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-success').addClass('alert alert-danger');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('#todoResult').html(error);
                    }
                },
            });
        });
    </script>
</body>

</html>