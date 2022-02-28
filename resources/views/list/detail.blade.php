@extends('layouts.app')

@section('style')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">詳細</div>

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

                    <h3 class="mb-4">行事名: {{ $practices[0]->practice_name }}</h3>

                    <div class="row mb-3">
                        <div class="col-md-3 offset-md-3">
                            <p class="label pt-2" for="every_event">活動理由書:</p>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('list.reason') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $practices[0]->date }}" name="date">
                                <button type="submit" class="btn btn-primary">ダウンロード</button>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>活動日</th>
                                <th>開催場所</th>
                                <th>登録者</th>
                                <th>料金(円)</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($practices as $practice)
                                <tr>
                                    <td>{{ $practice->date }}</td>
                                    <td>{{ $practice->location_name }}</td>
                                    <td>{{ $practice->user_name }}</td>
                                    <td>{{ $practice->cost }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal{{ $practice->id }}">
                                            利用情報
                                        </button>

                                        @include('layouts.modal',
                                        [
                                            'date' => $practice->date,
                                            'location' => $practice->location_name,
                                            'route' => 'list.update',
                                            'usage_time' => $practice->usage_time,
                                            'coat' => $practice->coat,
                                            'light_up_time' => $practice->light_up_time,
                                            'id' => $practice->id
                                        ])
                                    </td>
                                    <td>
                                        <form action="{{ route('list.delete', $practice->id) }}" method="POST" onSubmit="return check()">
                                            @csrf
                                            <input class="btn btn-outline-secondary btn-sm" type="submit" value="削除" name="delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="{{ route('list') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function check(){

        if (window.confirm('練習を削除します。よろしいですか？')) { // 確認ダイアログを表示
            return true; // 「OK」時は送信を実行

        } else { // 「キャンセル」時の処理
            return false; // 送信を中止
        }
    }
</script>
@endsection