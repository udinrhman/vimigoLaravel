<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="/css/main.css" rel="stylesheet">
</head>

<body>
    @if(!empty($user['id']))
    <div id="notification"></div>
    <div class="container-fluid">
        <div class="row" style="height:auto;">
            <div class="card profile" style="border-bottom: none">
                <div class="card-body" style="padding:0">
                    <div class="twPc-div">
                        <div class="twPc-bg " style="background-image: url('https://wallpaperaccess.com/full/6548582.jpg');"></div>
                        <div class="avatarLink">
                            <div id="icon">
                                @if($user['gender'] == 'male')
                                <!-- profile icon change according to gender -->
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkfF6nBhidhIzL330CYtg70I8tpDBGJ2YjBPnE9D9gY0iLmGu563WBIab4KBexSDv7kG8&usqp=CAU" width="100%" height="100%" style="object-fit:cover;" class="profilePic">
                                @else
                                <img src="https://www.kindpng.com/picc/m/163-1636340_user-avatar-icon-avatar-transparent-user-icon-png.png" width="100%" height="100%" style="object-fit:cover;" class="profilePic">
                                @endif
                            </div>
                        </div>
                        <div class="User">
                            <span class="name">{{$user['name']}}</span>&nbsp&nbsp<span class="username">#{{$user['id']}}</span><button style="float:right;margin-right:10px" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditUserModal">EDIT USER</button>
                        </div><br>
                        <div class="info">
                            <div id="info-details">
                                <span style="color:#B1B2FF;font-weight:600">Email:</span> {{$user['email']}} <br>
                                <span style="color:#B1B2FF;font-weight:600">Gender:</span> {{$user['gender']}} <br>
                                <span style="color:#B1B2FF;font-weight:600">Status:</span> {{$user['status']}}
                            </div>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="container-fluid" style="padding:0;padding-bottom:10px;">
                    <div class="card-body" style="width:100%">
                        <button class="btn btn-secondary" style="margin-bottom:10px" data-bs-toggle="modal" data-bs-target="#AddPostModal">ADD POSTS</button>
                        <div class="posts">
                            <div id="user_posts">
                                <div class="resultTotal">
                                    Total Posts: <span style="font-weight:600">{{$totalPost}}</span>
                                </div>
                                @php
                                $x = 0;
                                @endphp
                                @if($totalPost == 0)
                                <p style="color:#FFFFFF">This user doesn't have any posts.</p>
                                @else
                                @foreach($post as $posts)
                                <div style="float:right;margin:10px;">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditPostModal{{$x}}">EDIT</button> <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#DeletePostModal{{$x}}">DELETE</button>
                                </div>

                                <div class="post">
                                    <p><span style="font-weight:600">Title: </span>{{$posts['title']}}</p>
                                    <p><span style="font-weight:600">Body: </span>{{$posts['body']}}</p>
                                    <p style="text-align:right;font-size:15px;margin-bottom:0;">posted by #{{$posts['user_id']}}</p>
                                </div>

                                <!-- Edit Post Modal -->
                                <div class="modal fade EditPostModal" id="EditPostModal{{$x}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Post</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="postResult" style="font-size:16px;font-weight:lighter"></div>
                                                <form class="editPost_form" action="{{ route('editpost') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="token" id="token" value="{{ @csrf_token() }}">
                                                    <input type="hidden" name="id" id="id" value="{{ $posts['id'] }}">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{$posts['title']}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="body" id="body" placeholder="Body" rows="5">{{$posts['body']}}</textarea>
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

                                <!-- Delete Post Modal -->
                                <div class="modal fade DeleteModal" id="DeletePostModal{{$x}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="postResult"></div>
                                                <form class="deletePost_form" action="{{ route('deletepost') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="token" id="token" value="{{ @csrf_token() }}">
                                                    <input type="hidden" class="id" name="id" id="id" value="{{$posts['id']}}">
                                                    <p>Are you sure you want to delete this Post?
                                                    <p>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">DELETE</button>
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid" style="padding:0;padding-bottom:10px;">
                    <div class="card-body" style="width:100%">
                        <button class="btn btn-secondary" style="margin-bottom:10px" data-bs-toggle="modal" data-bs-target="#AddTodoModal">ADD TODOS</button>
                        <div class="posts">
                            <div id="user_todos">
                                <div class="resultTotal">
                                    Total Todos: <span style="font-weight:600">{{$totalTodo}}</span>
                                </div>
                                @if($totalTodo == 0)
                                <p style="color:#FFFFFF">This user doesn't have any todo list.</p>
                                @else
                                @php
                                $i = 0;
                                @endphp
                                @foreach($todo as $todos)

                                <div class="post">
                                    <div class="row">
                                        <div class="col">
                                            <p><span style="font-weight:600">Title: </span>{{$todos['title']}}</p>
                                        </div>
                                        <div class="col">
                                            <p><span style="font-weight:600">Due on: </span>{{$todos['due_on']}}</p>
                                        </div>
                                        <div class="col-sm-2" style="text-align:left">
                                            <p><span style="font-weight:600">Status: </span>{{$todos['status']}}</p>
                                        </div>
                                        <div class="col-sm-2" style="text-align:right">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditTodoModal{{$i}}">EDIT</button> <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#DeleteTodoModal{{$i}}">DELETE</button>
                                        </div>
                                    </div>

                                </div>

                                <!-- Edit Todos Modal -->
                                <div class="modal fade EditTodoModal" id="EditTodoModal{{$i}}" aria-hidden="true">
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
                                                    <input type="hidden" class="id" name="id" id="id" value="{{$todos['id']}}">
                                                    <input type="hidden" class="user_id" name="user_id" id="user_id" value="{{$todos['user_id']}}">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control title" name="title" id="title" value="{{$todos['title']}}" placeholder="Title">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="datetime-local" class="form-control due_on" name="due_on" id="due_on" value="{{ date('Y-m-d\TH:i', strtotime($todos['due_on'])) }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control status" name="status" id="status">
                                                            <option disabled>-- select status --</option>
                                                            @if($todos['status']=='pending')
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

                                <!-- Delete Todos Modal -->
                                <div class="modal fade DeleteModal" id="DeleteTodoModal{{$i}}" aria-hidden="true">
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
                                                    <input type="hidden" class="id" name="id" id="id" value="{{$todos['id']}}">
                                                    <p>Are you sure you want to delete this todo?
                                                    <p>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">DELETE</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $i = $i+1;
                                @endphp
                                @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="EditUserModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="userResult"></div>
                    <form id="editUser_form" action="{{ route('edituser') }}" method="POST">
                        @csrf
                        <input type="hidden" class="token" id="token" value="{{ @csrf_token() }}">
                        <input type="hidden" class="id" name="id" id="id" value="{{$user['id']}}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{$user['name']}}">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{$user['email']}}">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="gender" id="gender">
                                <option disabled>-- select gender --</option>
                                @if($user['gender'] == 'male')
                                <option selected value="male">male</option>
                                <option value="female">female</option>
                                @else
                                <option value="male">male</option>
                                <option selected value="female">female</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="status" id="status">
                                <option disabled>-- select status --</option>
                                @if($user['status'] == 'active')
                                <option selected value="active">active</option>
                                <option value="inactive">inactive</option>
                                @else
                                <option value="active">active</option>
                                <option selected value="inactive">inactive</option>
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

    <!-- Add Posts Modal -->
    <div class="modal fade" id="AddPostModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Post</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="postResult"></div>
                    <form id="post_form" action="{{ route('addpost') }}">
                        <input type="hidden" id="token" value="{{ @csrf_token() }}">
                        <input type="hidden" name="user_id" id="user_id" value="{{ $user['id'] }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="body" id="body" placeholder="Body" rows="7"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="reset" class="btn btn-light">RESET</button>
                            <button type="submit" class="btn btn-secondary">ADD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Todos Modal -->
    <div class="modal fade" id="AddTodoModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Todo</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="todoResult"></div>
                    <form id="todo_form" action="{{ route('addtodo') }}">
                        <input type="hidden" id="token2" value="{{ @csrf_token() }}">
                        <input type="hidden" name="user_id" id="user_id2" value="{{ $user['id'] }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" id="title2" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <input type="datetime-local" class="form-control" name="due_on" id="due_on2">
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

    <!--Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        $(document).on('submit', '#editUser_form', function(e) {
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
                        $('.userResult').html(error);
                    }
                    if (response.code == '200') {
                        $('#icon').load(' #icon'); //change profile image depending on updated gender
                        $('.name').load(' .name');
                        $('#info-details').load(' #info-details');
                        $('#EditUserModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-danger').addClass('alert alert-success');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('.userResult').html(error);
                    }
                },
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#post_form').submit(function(e) {
                e.preventDefault();
                let url = $(this).attr('action');

                $.post(url, {
                        '_token': $('#token').val(),
                        user_id: $('#user_id').val(),
                        title: $('#title').val(),
                        body: $('#body').val(),
                    },
                    function(response) {
                        if (response.code == 400) {
                            let error = '<span style="color:#b34045">' + response.msg + '</span>';
                            $('#postResult').html(error);
                        }
                        if (response.code == 200) {
                            $('#AddPostModal').modal('hide');
                            $(".modal-backdrop").remove();
                            $('#user_posts').load(' #user_posts');
                            $('#notification').html(response.status);
                            $("#notification").removeClass('alert alert-danger').addClass('alert alert-success');
                            $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                        } else if (response.status == 'fail') {
                            let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                            $('#postResult').html(error);
                        }
                    });
            });
        });
    </script>

    <script>
        $(document).on('submit', '.editPost_form', function(e) {
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
                        $('.postResult').html(error);
                    }
                    if (response.code == 200) {
                        $('.EditPostModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#user_posts').load(' #user_posts');
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-danger').addClass('alert alert-success');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('.postResult').html(error);
                    }
                },
            });
        });
    </script>

    <script>
        $(document).on('submit', '.deletePost_form', function(e) {
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
                        $('.DeleteModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#user_posts').load(' #user_posts');
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-success').addClass('alert alert-danger');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('.postResult').html(error);
                    }
                },
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#todo_form').submit(function(e) {
                e.preventDefault();
                let url = $(this).attr('action');

                $.post(url, {
                        '_token': $('#token2').val(),
                        user_id: $('#user_id2').val(),
                        title: $('#title2').val(),
                        due_on: $('#due_on2').val(),
                        status: $('#status2').val(),
                    },
                    function(response) {
                        if (response.code == 400) {
                            let error = '<span style="color:#b34045">' + response.msg + '</span>';
                            $('#todoResult').html(error);
                        }
                        if (response.code == 200) {
                            $('#AddTodoModal').modal('hide');
                            $(".modal-backdrop").remove();
                            $('#user_todos').load(' #user_todos');
                            $('#notification').html(response.status);
                            $("#notification").removeClass('alert alert-danger').addClass('alert alert-success');
                            $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                        } else if (response.status == 'fail') {
                            let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                            $('#todoResult').html(error);
                        }
                    });
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
                        $('.EditTodoModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#user_todos').load(' #user_todos');
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
                        $('.DeleteModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#user_todos').load(' #user_todos');
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-success').addClass('alert alert-danger');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('.todoResult').html(error);
                    }
                },
            });
        });
    </script>
    @else
        <div class="alert alert-danger">This user does not <b>exist</b> or has been <b>deleted</b>.</div>
        <a href="../users/page/1"><button class="btn btn-primary" >View User List</button></a>
    @endif
</body>

</html>