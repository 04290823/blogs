<!DOCTYPE html>
<!-- saved from url=(0045)http://www.fukuablog.com/index.php/login.html -->
<html lang="zh-cn"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="copyright" content="Catfish CMS All Rights Reserved">
  <meta name="robots" content="noindex,noarchive">
  <title>用户登录</title>
  <link rel="icon" href="http://www.fukuablog.com/public/common/images/favicon.ico">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/catfishBottom.css">
  <script src="js/jquery.min.js.下载"></script>
  <script src="js/login.js.下载"></script>
</head>
<body style="background-image:url('img/oYYBAFO6RQKICdISAB65bXnkF6MAABtmgLyxbsAHrmF262.jpg');">
<div class="container-fluid" id="catfishContentBlock">
  <div class="row">
    <br>
    <div class="hidden-xs"><br><br></div>
    <div class="col-xs-10 col-sm-6 col-md-4 col-xs-offset-1 col-sm-offset-3 col-md-offset-4">
      <h1 class="text-center" style="color:#fff;">
        <img src="img/catfish_white.png" width="32" height="32">
        后台管理系统            </h1><br>
      <div class="panel panel-default" id="denglukuang">
        <div class="panel-body">
          <form method="post" action="login">
            {{csrf_field()}}
            <div class="form-group">
              <label>用户名</label>
              <input type="text" class="form-control" name="user" placeholder="用户名">
              @if (count($errors) > 0)
                <span style="color: red">
                    @foreach($errors->get('user') as $error)
                    {{ $error }}
                  @endforeach
                </span>
              @endif
            </div>
            <div class="form-group">
              <label>密码</label>
              <input type="password" class="form-control" name="pwd" placeholder="密码">
              @if (count($errors) > 0)
                <span style="color: red">
                @foreach($errors->get('pwd') as $error)
                    {{ $error }}
                  @endforeach
              </span>
              @endif
            </div>
            <div class="form-group">
              <label>验证码</label>
              <div><img src="{{captcha_src()}}" style="cursor: pointer" onclick="this.src='{{captcha_src()}}'+Math.random()"></div>
              <input type="text" class="form-control" name="captcha" placeholder="验证码">
              @if (count($errors) > 0)
                <span style="color: red">
                @foreach($errors->get('captcha') as $error)
                    {{ $error }}
                  @endforeach
              </span>
              @endif
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-default">登录</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid hidden" id="catfishFooter">
  <div class="row">
    <div><a href="http://www.catfish-cms.com/" target="_blank" id="catfish">Catfish(鲶鱼) Blog</a>&nbsp;&nbsp;</div>
  </div>
</div>
</body></html>