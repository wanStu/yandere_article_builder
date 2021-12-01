<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>奇怪文章生成器</title>
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
<div class="container" id="container">
    <h1>文章生成器</h1>
    <div class="form">
        <form action="/assemble" method="post">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-12 col-sm">
                    <label for="SVO">请输入发病对象:</label>
                    <input type="text" class="text" placeholder="请输入发病对象" id="SVO" name="SVO" v-model="SVO">
                </div>
                <div class="col-12 col-sm-1">
                    <input class="btn btn-success" type="button" value="确认" v-on:click="formSubmit">
                </div>
            </div>
        </form>
    </div>
        <h1>
            @{{ articleTitle }}
        </h1>
        <article>
            <p>
              @{{ articleContent }}
            </p>
        </article>
</div>
</body>
</html>
<script>
    const container = {
        data() {
            return {
                SVO:"",
                articleTitle:"Title",
                articleContent:"content"
            }
        },
        methods:{
            formSubmit() {
                axios.post("/assemble",{
                    SVO:this.SVO,
                })
                .then(({data}) => {
                    this.articleTitle = data["message"];
                    this.articleContent = data["data"];
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    };
    Vue.createApp(container).mount("#container");
</script>
<?php /**PATH /usr/share/nginx/html/resources/views/index.blade.php ENDPATH**/ ?>
