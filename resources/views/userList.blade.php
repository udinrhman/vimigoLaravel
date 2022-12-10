<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="/css/main.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid" ;>
        <div style="float:right;margin-bottom:10px;width:100%;display:block">
            <button class="btn btn-secondary" style="float:right" data-bs-toggle="modal" data-bs-target="#AddModal">ADD USER</button>
        </div>
        <div class="card">
            <div class="card-body" style="padding:0">

                <table class="table table-hover" id="user_list" style="margin:0">
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

        <!-- Add Product Modal -->
        <div class="modal fade" id="AddModal" aria-hidden="true">
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
                        <form id="user_form" action="{{ route('store') }}">
                            <input type="hidden" id="token" value="{{ @csrf_token() }}">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="gender" id="gender">
                                    <option selected disabled>-- select gender --</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="status" id="status">
                                    <option selected disabled>-- select status --</option>
                                    <option value="active">active</option>
                                    <option value="inactive">inactive</option>
                                </select>
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
        $(document).ready(function() {
            $('#user_form').submit(function(e) {
                e.preventDefault();
                let url = $(this).attr('action');

                $.post(url, {
                        '_token': $('#token').val(),
                        name: $('#name').val(),
                        email: $('#email').val(),
                        gender: $('#gender').val(),
                        status: $('#status').val(),
                    },
                    function(response) {
                        if (response.code == 400) {
                            let error = '<span style="color:#b34045">' + response.msg + '</span>';
                            $('#result').html(error);
                        }
                        if (response.status == 'success') {
                            $('#AddModal').modal('hide');
                            $(".modal-backdrop").remove();
                            $('#user_list').load(' #user_list');
                        } else if (response.status == 'fail') {
                            let error = '<span style="color:#b34045">' + response.restmsg + '</span>';
                            $('#result').html(error);
                        }
                    });
            });
        });
    </script>
</body>

</html>