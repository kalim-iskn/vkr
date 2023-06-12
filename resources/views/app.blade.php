<html lang="ru">
<head>
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ asset("img/logo_header.png") }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" href="{{ asset("mobile/css/pushy.css") }}">
    <script src="{{ asset("js/jquery.min.js") }}"></script>
</head>
<body onload="Size()">
<!--///////////////////////////////////////////////////////////////////////////МЕНЮ ДЛЯ МОБИЛЬНЫХ УСТРОЙСТВ///////////////////////////////////////////////////////////////////////////////////////////////-->
    <div id="goback" onclick="history.back()">Назад</div>
    <div class="pushy pushy-left" data-focus="#first-link">
        <div class="pushy-content">
            <div style="width:100%;background:#2C1F30">
                <a href="">
                    <center>
                        <img src="{{ asset("img/menu_img.PNG") }}" width="62px" height="60px"
                             style="margin-top:7px;margin-bottom:7px">
                    </center>
                </a>
            </div>
            <a href="{{ route("profile", ["id" => auth()->id()]) }}"><input type="button" value="КАБИНЕТ" id="mob_menu_button"></a>
            <a href="{{ route("term") }}"><input type="button" value="ТАБЕЛЬ" id="mob_menu_button"></a>
            <a href="{{ route("diary") }}"><input type="button" value="ДНЕВНИК" id="mob_menu_button"></a>
            <a href="{{ route("rating", ["class" => auth()->user()->class]) }}"><input type="button" value="РЕЙТИНГ" id="mob_menu_button"></a>
        </div>
    </div>
    <div class="site-overlay"></div>
    <div  id="container"  style="z-index:1;">
        <img src="{{ asset("img/menu_img.PNG") }}" height="100%" align="right">
        <div class="menu-btn">
            <img src="{{ asset("img/menu-icon.png") }}" height="60%" style="margin:20%" align="left">
        </div>
        {{--<div style="margin-top:10px;"><?echo $address_this_page?></div>--}}
    </div>
    <script src="{{ asset("mobile/js/pushy.min.js") }}"></script>
    <!--///////////////////////////////////////////////////////////////////////////МЕНЮ ДЛЯ ДЕКСТОПНЫХ УСТРОЙСТВ///////////////////////////////////////////////////////////////////////////////////////////////-->
    <div id="menu">
        <img src="{{ asset("img/menu_img.PNG") }}" id="img_menu">
        <a href="{{ route("profile", ["id" => auth()->id()]) }}"><input type="button" value="КАБИНЕТ" id="menu_button"></a>
        <a href="{{ route("term") }}"><input type="button" value="ТАБЕЛЬ" id="menu_button"></a>
        <a href="{{ route("diary") }}"><input type="button" value="ДНЕВНИК" id="menu_button"></a>
        <a href="{{ route("rating", ["class" => auth()->user()->class]) }}"><input type="button" value="РЕЙТИНГ" id="menu_button"></a>
    </div><br><br><br class="br"><br class="br">
    @yield("content")
</body>
<footer id="footer">
        Iskander Kalimullin © 2023<br>
        Диплом ИТИС КФУ<br>
</footer>
</html>
