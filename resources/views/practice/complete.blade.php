@extends('layouts.app')

@section('style')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">練習登録完了</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="mb-4">練習を登録しました</h3>
                    <p>学生団体活動支援システム上で学外行事届を作成してください。</p>
                    <p>緊急事態宣言が発令されている場合、「活動理由書」の提出が必要です。</p>

                    <div class="mb-3">
                        <p>「活動理由書」のダウンロードはこちらから。</p>
                        <a href="{{ route('list.detail', $ym) }}" class="btn btn-primary">ダウンロード画面へ</a>
                    </div>

                    <a href="{{ route('home') }}">HOME</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
