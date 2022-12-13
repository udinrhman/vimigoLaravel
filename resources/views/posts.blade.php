<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts List</title>
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
                            <option value="comments">comments</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">FILTER</button>
                </div>
            </div>
        </form>
        <div style="float:right;margin-bottom:10px;width:100%;display:block">
            <button class="btn btn-secondary" style="float:right" data-bs-toggle="modal" data-bs-target="#AddPostModal">ADD POST FOR THIS USER</button>
        </div>
        @if(empty($data))
        <br><br>
        <div class="alert alert-danger">This user does not have any posts.</div>
        <a href="../../users/page/1"><button class="btn btn-primary">View User List</button></a>
        @else

        <div class="card">
            <div class="card-body" style="padding:0">
                <table class="table table-hover" id="userPost_list" style="margin:0">
                    <thead class="table-custom">
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 0
                        @endphp
                        @foreach ($data as $posts)
                        <tr>
                            <td width="5%">{{$posts['id']}}</td>
                            <td>{{$posts['user_id']}}</td>
                            <td>{{$posts['title']}}</td>
                            <td>{{$posts['body']}}</td>
                            <td width="10%"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditPostModal{{$i}}">EDIT</a></button></td>
                            <td width="10%"><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#DeletePostModal{{$i}}">DELETE</button></td>
                        </tr>
                        @php
                        $i = $i+1;
                        @endphp
                        @endforeach
                    </tbody>
                </table>

                <div id="deleteModal">
                    @php
                    $x = 0
                    @endphp
                    @foreach ($data as $post)
                    <!-- Delete Posts Modal -->
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
                                        <input type="hidden" class="id" name="id" id="id" value="{{$post['id']}}">
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
                                        <input type="hidden" name="id" id="id" value="{{ $post['id'] }}">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{$post['title']}}">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="body" id="body" placeholder="Body" rows="5">{{$post['body']}}</textarea>
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
            @if($page > 1)<a href={{"/posts/".$user_id."/".$page-1}}><button class="btn btn-secondary">back</button></a>@endif
            @if($page < $totalPages)<a href={{"/posts/".$user_id."/".$page+1}}><button class="btn btn-secondary">next</button></a>@endif
        </div>

        <!-- Add Posts Modal -->
        <div class="modal fade" id="AddPostModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Post for #{{$user_id}}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="postResult"></div>
                        <form id="post_form" action="{{ route('addpost') }}" method="POST">
                            @csrf
                            <input type="hidden" id="token" value="{{ @csrf_token() }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
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
        $(document).on('submit', '#post_form', function(e) {
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
                        $('#postResult').html(error);
                    }
                    if (response.code == 200) {
                        $('.container-fluid').load(' .container-fluid');
                        $('#AddPostModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-danger').addClass('alert alert-success');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('#postResult').html(error);
                    }
                },
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
                        $('.container-fluid').load(' .container-fluid');
                        $('.EditPostModal').modal('hide');
                        $(".modal-backdrop").remove();
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
                        $('.container-fluid').load(' .container-fluid');
                        $('.DeleteModal').modal('hide');
                        $(".modal-backdrop").remove();
                        $('#notification').html(response.status);
                        $("#notification").removeClass('alert alert-success').addClass('alert alert-danger');
                        $("#notification").show().delay(700).addClass("in").fadeOut(1000);
                    } else if (response.status == 'fail') {
                        let error = '<span class="error-msg">Error: ' + response.restmsg + '</span>';
                        $('#postResult').html(error);
                    }
                },
            });
        });
    </script>
</body>

</html>