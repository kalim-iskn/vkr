<?php
/** @var \App\DTO\Parser\Diary\DiaryDTO $diary */
?>

@extends("app", ["title" => "Дневник"])

@section("content")
    <div id="main">
        <div id="zag">
            @if($diary->previousDate)
                <a href="{{ route("diary", ["date" => $diary->previousDate]) }}" class="prev">
                    <input type="button" value="Назад" style="float:left;" id="button_next">
                </a>
            @endif
            @if($diary->nextDate)
                <a href="{{ route("diary", ["date" => $diary->nextDate]) }}" class="next">
                    <input type="button" value="Вперед" style="float:right;" id="button_next">
                </a>
            @endif
            <div id="name">Дневник</div>
            <hr color="#2C1F30" width="100%">
        </div>
        <div id="block">
            <table class="diary" cellspacing="0px" border="1px" style="border-color:#19143D" width="100%">
                <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Задание</th>
                    <th>Оценка</th>
                </tr>
                </thead>
                <tbody>
                @foreach($diary->getDays() as $day)
                    <tr>
                        <td colspan="3" class='date'>{{ $day->dayOfWeek }}, {{ $day->day }} {{ __("months.$diary->month") }}</td>
                    </tr>
                    @foreach($day->getSubjects() as $subject)
                        <tr>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->homeTask }}</td>
                            <td style="text-align: center">{{ $subject->mark }}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
