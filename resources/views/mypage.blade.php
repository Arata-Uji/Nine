@extends('layouts.app')

@section('style')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">マイページ</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="list-group mb-3">
                        <li class="list-group-item">名前: {{ Auth::user()->name }}</li>
                        <li class="list-group-item">役職: {{ Auth::user()->position }}</li>
                        <li class="list-group-item">学籍番号: {{ Auth::user()->student_id }}</li>
                        <li class="list-group-item">学部学年: {{ Auth::user()->faculty . Auth::user()->department . $grade }}</li>
                        <li class="list-group-item">メールアドレス: {{ Auth::user()->email }}</li>
                    </ul>

                    <a href="javascript:history.back()">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection