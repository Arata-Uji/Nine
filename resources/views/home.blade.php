@extends('layouts.app')

@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">HOME</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-4 mt-3">
                        <a href="{{ route('practice') }}" class="btn btn-primary w-25">練習登録</a>
                        <a href="{{ route('list') }}" class="btn btn-primary w-25">登録リスト</a>
                    </div>

                    <h4 class="mb-3" id="calendar">
                        <a href="{{ url('/?date=' . $calendar->getPreviousMonth()) }}">&lt;</a>
                        {{ $calendar->getTitle() }}
                        <a href="{{ url('/?date=' . $calendar->getNextMonth()) }}">&gt;</a>
                    </h4>
                    {!! $calendar->render() !!}
                    @foreach ($practices as $practice)
                        @include('layouts.modal',
                        [
                            'date' => $practice->date,
                            'location' => $practice->location_name,
                            'route' => 'home.update',
                            'usage_time' => $practice->usage_time,
                            'coat' => $practice->coat,
                            'light_up_time' => $practice->light_up_time,
                            'id' => $practice->id
                        ])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
