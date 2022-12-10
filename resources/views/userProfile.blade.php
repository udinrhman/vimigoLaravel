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
                            @if($user['gender'] == 'male') <!-- profile icon change according to gender -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkfF6nBhidhIzL330CYtg70I8tpDBGJ2YjBPnE9D9gY0iLmGu563WBIab4KBexSDv7kG8&usqp=CAU" width="100%" height="100%" style="object-fit:cover;" class="profilePic">
                            @else
                            <img src="https://www.kindpng.com/picc/m/163-1636340_user-avatar-icon-avatar-transparent-user-icon-png.png" width="100%" height="100%" style="object-fit:cover;" class="profilePic">
                            @endif
                        </div>
                        <div class="User">
                            <span class="name">{{$user['name']}}</span>&nbsp&nbsp<span class="username">#{{$user['id']}}</span>
                        </div><br><br>
                        <div class="email"><span style="font-weight:600">Email:</span> {{$user['email']}}</div>
                        <div class="stats"><span style="font-weight:600">Gender:</span> {{$user['gender']}}</div>
                        <div class="stats"><span style="font-weight:600">Status:</span> {{$user['status']}}</div>
                    </div>
                </div>
                <hr>
                <div class="container-fluid" style="padding:0;padding-bottom:20px;">
                    <div class="card-body" style="width:100%">
                        <div class="bio">
                            <p>Gender: {{$user['gender']}}</p>
                            <p>Status: {{$user['status']}}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>