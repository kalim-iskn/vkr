<?php
/** @var \App\DTO\Rating\RatingDTO $rating */
?>

@extends("app", ["title" => "Рейтинг"])

@section("content")
    <style>
        tr {
            background: white;
        }

        td {
            text-align: center;
            border-bottom: 2px solid #19143D;
            font-size: 22px;
        }

        th {
            font-size: 20px;
        }

        table {
            border-spacing: 0px
        }

        a {
            text-decoration: underline;
            color: black;
        }

        @media screen and (max-width: 60em) {
            hr {
                margin-top: 9px;
            }

            td, tr {
                font-size: 18px;
            }

            th {
                font-size: 19px;
                padding: 10px;
            }
        }

        @media screen and (max-width: 650px) {
            td, tr {
                font-size: 13px;
            }

            th {
                font-size: 14px;
                padding: 8px;
            }
        }

        @media screen and (max-width: 400px) {
            td, tr {
                height: auto;
            }

            td, tr {
                font-size: 11px;
            }

            th {
                font-size: 12px;
                padding: 7px;
            }
        }
    </style>
    <div style="min-height:90%">
        <div id="main">
            <div id="zag">
                Рейтинг
                <select id="term" name="term" style="margin-top: 0"
                        onchange="window.location.href = '?school={{ $selectedSchool }}&class=' + $(this).val();">
                    @foreach(range(1, 11) as $class)
                        <option value="{{ $class }}" {{ $selectedClass == $class ? "selected" : "" }}>
                            {{ $class }} класс
                        </option>
                    @endforeach
                </select>
                <select id="term" name="school" style="margin-top: 0;"
                        onchange="window.location.href = '?class={{ $selectedClass }}&school=' + $(this).val();">
                    <option value="">Выберите школу</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ $selectedSchool == $school->id ? "selected" : "" }}>
                            {{ $school->short_name }}
                        </option>
                    @endforeach
                </select>
                <hr color="#2C1F30" width="100%">
            </div>
            <div id="block">
                <table style="width: 100%">
                    <tr>
                        <th>Место</th>
                        <th>Ученик</th>
                        <th>Ср. балл</th>
                        <th>Класс</th>
                        <th>Дата</th>
                    </tr>
                    @foreach($rating->getUsers() as $user)
                        <tr>
                            <td>
                                {{ $user->place }}
                            </td>
                            <td>
                                <a href="{{ route("profile", ["id" => $user->id]) }}">
                                    {{ $user->fullName }}
                                </a>
                            </td>
                            <td>
                                {{ number_format($user->totalAverageMark, 2, '.', ',') }}
                            </td>
                            <td>
                                {{ $rating->class }}
                            </td>
                            <td>
                                {{ $user->actualDate }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
