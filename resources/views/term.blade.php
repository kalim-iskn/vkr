<?php
/** @var \App\DTO\Parser\Term\TermDTO $term */
?>

@extends("app", ["title" => "Табель успеваемости"])

@section("content")
    <style>
        @media screen and (max-width: 60em) {
            hr {
                margin-top: 14px;
            }

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

        @media screen and (max-width: 300px) {
            td {
                font-size: 9px;
                padding: 4px;
            }

            th {
                font-size: 10px;
                padding: 5px;
            }
        }
    </style>
    <div id="main">
        <div id="zag">
            <span style="vertical-align: text-top;">Табель успеваемости</span>
            @if($isSaved)
                <div class="term_actual_text">
                    <div>
                        <a href="{{ route("profile", ["id" => $user->id]) }}" class="link_name" style="text-decoration: underline">
                            {{ $user->getFullName() }}
                        </a>
                    </div>
                    Актуален по состоянию на {{ $term->actualDate->format("d.m.Y H:i") }}
                </div>
            @else
                <select id="term" name="term" style="margin-top: 0" onchange="window.location.href = '?term=' + $(this).val();">
                    <option value="1" {{ $termPeriod == 1 ? "selected" : "" }}>1 четверть</option>
                    <option value="2" {{ $termPeriod == 2 ? "selected" : "" }}>2 четверть</option>
                    <option value="3" {{ $termPeriod == 3 ? "selected" : "" }}>3 четверть</option>
                    <option value="4" {{ $termPeriod == 4 ? "selected" : "" }}>4 четверть</option>
                    <option value="year" {{ $termPeriod == "year" ? "selected" : "" }}>Год</option>
                </select>
            @endif
            <hr color="#2C1F30" width="100%">
        </div>
        <div id="block">
            <table align="left" class="table_lessons">
                <tr>
                    <th class='lesson'>Предмет</th>
                </tr>
                @foreach($term->getSubjects() as $subject)
                    <tr class="{{ $loop->index % 2 > 0 ? "even_row" : "odd_row" }}">
                        <td class="{{ $loop->index + 1 }}">{{ $subject->name }}</td>
                    </tr>
                @endforeach
                <tr>
                   <td>ИТОГО</td>
                </tr>
            </table>
            <div class="div_table">
                <table class="table_marks">
                    <tr>
                        <th colspan="{{ $term->maxMarksCount }}">Оценки</th>
                        <th>Ср. балл</th>
                        <th class="mark">Итоговая<br>оценка</th>
                        <th class="mark_mob">Итог.<br>оценка</th>
                    </tr>
                    @foreach($term->getSubjects() as $subject)
                        <tr class="{{ $loop->index % 2 > 0 ? "even_row" : "odd_row" }} mark_{{ $loop->index + 1 }}">
                            @foreach($subject->getMarks() as $mark)
                                <td>{{ $mark }}</td>
                            @endforeach
                            @for($i = count($subject->getMarks()); $i < $term->maxMarksCount; $i++)
                                <td></td>
                            @endfor
                            <td>
                                @if($subject->averageMark > 0)
                                    {{ number_format($subject->averageMark, 2, '.', ',') }}
                                @endif
                            </td>
                            <td>{{ $subject->finalMark }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="{{ $term->maxMarksCount }}"></td>
                        <td>{{ $term->totalAverageMark }}</td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <script>
                function Size(){
                    $('#calculating_block').hide();
                    for(i = 1;i <= {{ count($term->getSubjects()) }};i++){
                        $('.mark_'+i).height($('.'+i).outerHeight(true));
                    }
                    $('.lesson').height($('.mark').outerHeight(true));
                }
                $(window).resize(function(){
                    $('.lesson').height($('.mark').outerHeight(true));
                    for(i = 1;i <= {{ count($term->getSubjects()) }};i++){
                        $('.mark_'+i).height($('.'+i).outerHeight(true));
                    }
                });
            </script>

            <select class="calculating" id="term">
                <option value="0">Выберите предмет</option>
            </select>
            <div id="calculating_block">
                <input type="text" id="input_marks" placeholder="Предполагаемые оценки">
                <span class="ravno">
                    <b>Ср. балл <span id="average_mark"></span></b>
                    (Оценок добавлено: <span id="additional">0</span>)
                </span>
            </div>

            <script src="{{ asset("js/calculating.js") }}"></script>

            <script>
                for(i = 1;i <= {{ count($term->getSubjects()) }};i++){
                    var text = $('.'+i).text();
                    $('.calculating').append('<option value=\"mark_'+i+'\">'+text+'</option>');
                }
            </script>
        </div>
    </div>
@endsection
