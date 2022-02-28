@extends('layouts.app')

@section('style')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">月別練習リスト</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('err_msg'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('err_msg') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>行事名</th>
                                <th>活動期間</th>
                                <th>料金合計(円)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $list)
                                <tr>
                                    <td>{{ $list->name }}</td>
                                    <td>{{ $list->minDate . ' ~ ' . $list->maxDate . ' ※内' . $list->count . '日' }}</td>
                                    <td>{{ $list->costSum }}</td>
                                    <td>
                                        <a href="/list/{{ substr($list->minDate, 0, -3) }}" class="btn btn-secondary btn-sm">詳細</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('home') }}">HOME</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection