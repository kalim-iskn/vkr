<?php
/** @var \App\DTO\UserDTO $user */
?>

@extends("app", ["title" => $user->getFullName()])

@section("content")
    <style>
        table#user {
            margin-top: 20px;
        }
        table#user td {
            vertical-align:top;
            padding:4px;
            height:10px;
            min-width:150px;
        }
    </style>
    <div id="main">
        <div id="zag"  class="no_mobile">
            @if($isMyProfile)
                {{--<a href="friends"><button style="float:right;margin-right:0%" id="setting_button">Друзья (+1)</button></a>--}}
            @else
            @endif
            <div style="text-align: center" id="no_mobile">Личный кабинет</div>
            <hr color="#2C1F30"  id="no_mobile" width="100%" style="margin-bottom:-10px">
        </div>
        <div id="block">
            <table width="100%" id="no_mobile">
                <tr>
                    <td style="vertical-align:top;width:80%">
                        <table width="100%">
                            <tr>
                                <td style="vertical-align:top;" id="photo_td" width="30%">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/No-photo-m.png" id="user_photo">
                                    {{--<div id="change_foto_block" href="#">У вас в друзьях</div>--}}
                                    {{--<div id="list_user" style="margin-top:20px">
                                        <span style="color:#6D0520">Друзья</span>
                                        <span style="color:black">4</span>
                                        <span style="color: #19143D">(+34)</span>
                                    </div>--}}
                                    @if($isMyProfile)
                                        <div style="margin-top: 15px">
                                            <a href="settings">
                                                <input type="button" value="Настройки" style="margin-right:0;width: 100%" id="setting_button">
                                            </a>
                                        </div>
                                    @elseif($isSavedTermExists)
                                        <div style="margin-top: 15px">
                                            <a href="{{ route("saved-term", ["userId" => $user->id]) }}">
                                                <input type="button" value="Посмотреть табель" style="margin-right:0;width: 100%" id="setting_button">
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td style="vertical-align:top;" id="info_user">
                                    <span id="name_user" style="color: #6D0520">
                                        <a href="{{ route("profile", ["id" => $user->id]) }}" class="link_name">
                                            {{ $user->getFullName() }}
                                        </a>
                                    </span>
                                    <table id="user" border="0px" cellspacing="0" cellpadding="0">
                                        @if($isMyProfile)
                                            <tr>
                                                <td style="">
                                                    <b>Логин:</b>
                                                </td>
                                                <td style="">
                                                    {{ $user->login }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td style="">
                                                <b>Школа:</b>
                                            </td>
                                            <td style="">
                                                {{ $user->school }}
                                            </td>
                                        </tr>
                                    </table>
                                <td style="vertical-align:top;width:20%;">
                                    <a href="rating?class=&id=" style="text-decoration:none;color:black">
                                        <div id="rating">
                                            <div style="text-align: center">
                                                <div>Общий рейтинг:</div>
                                                <br>
                                                <div id="place">{{ $user->id == 9 ? 1 : 4 }}</div>
                                                место
                                            </div>
                                            <div id="total">Общее число: 5</div>
                                        </div>
                                    </a>
                                    <br>
                                    <a href="rating?class=&id=" style="text-decoration:none;color:black">
                                        <div id="rating">
                                            <div style="text-align: center">
                                                <div>Школьный рейтинг:</div>
                                                <br>
                                                <div id="place">1</div>
                                                место
                                            </div>
                                            <div id="total">Общее число: {{ $user->id == 9 ? 3 : 1 }}</div>
                                        </div>
                                    </a>
                                </td>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <div id="mobile_profile">
                <style>
                    #block_foto_mob{
                        background-image:url("https://upload.wikimedia.org/wikipedia/commons/2/2f/No-photo-m.png");background-size:cover;background-repeat:no-repeat;
                    }
                    @media screen and (max-width: 60em){
                        #main,#block{
                            padding:0px;
                        }
                        #test-modal{
                            width:85%;
                            font-size:20px;
                        }
                        .modal_zag{
                            font-size:20px;
                        }
                        #rating{
                            font-size:18px;
                        }
                        #place{
                            font-size:60px;
                        }
                        #total{
                            font-size:15px;
                        }
                        #block_foto_mob{
                            background-image:url("https://upload.wikimedia.org/wikipedia/commons/2/2f/No-photo-m.png");background-size:cover;background-repeat:no-repeat;
                        }
                    }
                    @media screen and (max-width: 500px){
                        #rating{
                            font-size:15px;
                        }
                        #place{
                            font-size:45px;
                        }
                        #total{
                            font-size:13px;
                        }
                    }
                    @media screen and (max-width: 350px){
                        #total{
                            font-size:12px;
                        }
                    }
                </style>

                <script>
                    function collapsElement(id1) {
                        if ( document.getElementById(id1).style.display != "none" ) {
                            document.getElementById(id1).style.display = 'none';
                            $("#link_razv").show();
                        }
                        else {
                            document.getElementById(id1).style.display = '';
                            $("#link_razv").hide();
                        }
                    }
                </script>
                <div id="block_foto_mob">
                    <div id="name_profile_mob">{{ $user->getFullName() }}</div>
                </div>
                {{--<div style="text-align:center;background:#f0f2f5;color:black;font-family:TuschTouch;padding:10px;font-weight:600;border-radius:0px 0px 10px 10px" class="add_friend">
                    У вас в друзьях
                </div>--}}
                <div id="block_mob">Информация</div>
                <div id="information_block_mob">
                    <b>Школа</b>
                    <hr style="margin-top:0px;margin-bottom:6px" color="#19143D" width="100%">
                    {{ $user->school }}
                    <br>
{{--                <a href="javascript:collapsElement('identifikator1')"  rel="nofollow" id="link_razv">развернуть</a>--}}
{{--                <div id="identifikator1" style="display:none">--}}
{{--                    <b>Личная почта</b>--}}
{{--                    <hr style="margin-top:0px;margin-bottom:2px" color="#19143D" width="100%">--}}
{{--                    qeeqqe--}}
{{--                    <br>--}}
{{--                    <a href="javascript:collapsElement('identifikator1')"  rel="nofollow" id="link_razv">свернуть</a>--}}
{{--                </div>--}}
            </div>
            <div id="block_mob">Рейтинг</div>
            <table style="background:white;font-family:TuschTouch;" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td width="50%">
                        <div id="rating" style="">
                            <center>
                                Школьный:<br><br>
                                <font id="place">1</font><Br>
                                место
                            </center><div id="total">Общее число: 1</div>
                        </div>
                    </td>
                    <td width="50%">
                        <a href="rating?class=" style="text-decoration:none;color:black">
                            <div id="rating" style="">
                                <center>
                                    Общий:<br><br>
                                    <font id="place">4</font><Br>
                                    место
                                </center><div id="total">Общее число: 5</div>
                            </div></a>
                    </td>
                </tr>
            </table>

            <div id="block_mob">Другое</div>
            {{--<a href="friends?id=" style="text-decoration:none"><div style="background:white;text-align:left;" id="block_mob">Друзья <font color="#19143D">13</font></div></a>
            <hr style="margin-top:0px;margin-bottom:2px">--}}
            <br>
        </div>
        </div>
    </div>
@endsection
