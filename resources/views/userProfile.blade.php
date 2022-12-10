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
    <div class="container-fluid">
        <div class="row" style="height:auto;">

            <div class="card profile" style="border-bottom: none">
                <div class="card-body" style="padding:0">
                    <div class="twPc-div">
                        <div class="twPc-bg " style="background-image: url('https://wallpaperaccess.com/full/6548582.jpg');"></div>
                        <div class="avatarLink">
                            @if($user['gender'] == 'male')
                            <!-- profile icon change according to gender -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkfF6nBhidhIzL330CYtg70I8tpDBGJ2YjBPnE9D9gY0iLmGu563WBIab4KBexSDv7kG8&usqp=CAU" width="100%" height="100%" style="object-fit:cover;" class="profilePic">
                            @else
                            <img src="https://www.kindpng.com/picc/m/163-1636340_user-avatar-icon-avatar-transparent-user-icon-png.png" width="100%" height="100%" style="object-fit:cover;" class="profilePic">
                            @endif
                        </div>
                        <div class="User">
                            <span class="name">{{$user['name']}}</span>&nbsp&nbsp<span class="username">#{{$user['id']}}</span>
                        </div><br><br>
                        <div class="email"><span style="color:#B1B2FF;font-weight:600">Email:</span> {{$user['email']}}</div>
                        <div class="stats"><span style="color:#B1B2FF;font-weight:600">Gender:</span> {{$user['gender']}}</div>
                        <div class="stats"><span style="color:#B1B2FF;font-weight:600">Status:</span> {{$user['status']}}</div>
                    </div>
                </div>
                <hr>

                <div class="container-fluid" style="padding:0;padding-bottom:20px;">
                    <div class="card-body" style="width:100%">
                        <button class="btn btn-primary" style="margin-bottom:10px" data-bs-toggle="modal" data-bs-target="#AddPostModal">ADD POSTS</button>

                        <div class="posts" id="user_posts">
                            <div class="resultTotal">
                                Total Posts: <span style="font-weight:600">{{$totalPost}}</span> posts
                            </div>
                            @if($totalPost == 0)
                            <p>This user don't have any posts.</p>
                            @else
                            @foreach($post as $posts)
                            <div class="post">
                                <p><span style="font-weight:600">Title: </span>{{$posts['title']}}</p>
                                <p><span style="font-weight:600">Body: </span>{{$posts['body']}}</p>
                                <p style="text-align:right;font-size:15px;margin-bottom:0;">posted by #{{$posts['user_id']}}</p>
                            </div>

                            @endforeach

                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Add Posts Modal -->
    <div class="modal fade" id="AddPostModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="result"></div>
                    <form id="post_form" action="{{ route('addpost') }}">
                        <input type="hidden" id="token" value="{{ @csrf_token() }}">
                        <input type="hidden" name="user_id" id="user_id" value="{{ $user['id'] }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="body" id="body" placeholder="Body" rows="5"></textarea>
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

    <!--Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

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
                            $('#result').html(error);
                        }
                        if (response.status == 'success') {
                            $('#AddPostModal').modal('hide');
                            $(".modal-backdrop").remove();
                            $('#user_posts').load(' #user_posts');
                        } else if (response.status == 'fail') {
                            let error = '<span style="color:#b34045">Error: ' + response.restmsg + '</span>';
                            $('#result').html(error);
                        }
                    });
            });
        });
    </script>
</body>

</html>