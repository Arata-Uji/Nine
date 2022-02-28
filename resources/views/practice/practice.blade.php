@extends('layouts.app')

@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">練習登録フォーム</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div style="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('err_msg'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('err_msg') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('practice.post') }}" name="sampleform">
						@csrf
                        <h4 class="mb-3" id="calendar">
                            <a href="{{ url('/practice/?date=' . $calendar->getPreviousMonth()) }}">&lt;</a>
                            {{ $calendar->getTitle() }}
                            <a href="{{ url('/practice/?date=' . $calendar->getNextMonth()) }}">&gt;</a>
                        </h4>
                        <input type="button" class="btn btn-secondary btn-sm mb-3" value="全チェックON" onclick="allcheck(true);">
                        <input type="button" class="btn btn-secondary btn-sm mb-3" value="全チェックOFF" onclick="allcheck(false);">
                        {!! $calendar->render() !!}
						<button type="submit" class="btn btn-primary mb-3">開催場所選択画面へ</button>
					</form>

                    <a href="{{ route('home') }}">キャンセル</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function allcheck( tf ) {

        var ElementsCount = document.sampleform.elements.length; // チェックボックスの数

        for(i = 0; i < ElementsCount; i++) {
            document.sampleform.elements[i].checked = tf; // ON・OFFを切り替え
        }
    }
</script>
@endsection
