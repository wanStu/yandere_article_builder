<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>登录页</title>
</head>
<style>
    body {
        background: #66ccff;
    }
    .container {
        position: relative;
        height: 200px;
    }
    .container form {
        position: absolute;
        top:50%;
        left:50%;
        width: 255px;
        transform: translate(-50%,150%);
    }
    .row {
        margin-bottom: 5px;
    }
    .container .btn.btn-success {
        width: 255px;
        margin: 10px auto;
    }
    .text {
        background: rgba(57,197,187,0.3);
    }
</style>
<body>
    <div class="container">
        <form action="/admin/login" method="post">
            @csrf
            <div class="row">
                <label for="username">请输入账号：</label>
                <input class="text" type="text" name="username" placeholder="admin" value="admin" id="username">
            </div>
            <div class="row">
                <label for="userpwd">请输入密码：</label>
                <input class="text" type="text" name="userpwd" placeholder="admin" value="admin" id="userpwd">
            </div>
            <div class="row">
                <button class="btn btn-success">登录</button>
            </div>
        </form>
    </div>
</body>
</html>
