@php
    if(!isset($name)) {
        $title = "奇怪文章生成器";
        $name = "";
    }else {
        $title = $name;
    }
    if(!isset($article)) {
        $article = "";
    }
@endphp
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>{{ $name }}</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<style>
    body {
        background: #66ccff;
    }
    * {
        margin: 0;
        padding: 0;
        color:#fff;
    }
    .container {
        padding-top: 10%;
    }
    .container h1 {
        text-align: center;
    }
    .container article p {
        text-indent: 2em;
    }
    .form,article{
        line-height: 31px;
        width: 30%;
        min-width: 345px;
        margin: 0 auto;
    }
    .form .text {
        background: rgba(57,197,187,0.3);
        box-sizing: border-box;
        padding-left: 9px;
    }
    .form + h1 {
        margin-top: 5%;
    }
    article {
        width: 40%;
    }
</style>
<body>
    <div class="container">
        <h1>文章生成器</h1>
        <div class="form">
            <form action="/assemble" method="post">
                @csrf
                <div class="row">
                    <div class="col-12 col-sm">
                        <label for="SVO">请输入发病对象:</label>
                        <input type="text" class="text" placeholder="请输入发病对象" id="SVO" name="SVO">
                    </div>
                    <div class="col-12 col-sm-1">
                        <input class="btn btn-success" type="submit" value="确认">
                    </div>
                </div>
            </form>
        </div>
        <h1>{{ $name }}</h1>
        <article>
            <p>
                {{ $article }}
            </p>
        </article>
    </div>
</body>
</html>
