@extends('layouts.app')

@section('style')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">開催場所選択</div>

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

                    <form method="POST" action="{{ route('practice.send') }}">
                        @csrf

                        <table class="table table-bordered">
                            <tr>
                                <th>活動日</th>
                                <th>開催場所</th>
                            </tr>

                            @foreach ($input as $practice)
                                <tr style="font-size:14px">
                                    <td>
                                        {{ $practice }}
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="tamagawa{{ $practice }}" value="1" name="practices[{{ $practice }}]" checked="checked" required>
                                            <label class="form-check-label" for="tamagawa{{ $practice }}">多摩川緑地広場</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="kawasaki{{ $practice }}" value="2" name="practices[{{ $practice }}]" required>
                                            <label class="form-check-label" for="kawasaki{{ $practice }}">川崎マリエン</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="akatsuka{{ $practice }}" value="3" name="practices[{{ $practice }}]" required>
                                            <label class="form-check-label" for="akatsuka{{ $practice }}">赤塚公園</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="shinozaki{{ $practice }}" value="4" name="practices[{{ $practice }}]" required>
                                            <label class="form-check-label" for="shinozaki{{ $practice }}">篠崎公園</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="ayase{{ $practice }}" value="5" name="practices[{{ $practice }}]" required>
                                            <label class="form-check-label" for="ayase{{ $practice }}">東綾瀬公園</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <input type="hidden" name="ym" value="{{ $ym }}">
                        <input type="submit" class="btn btn-secondary" name="back" value="戻る">
                        <input type="submit" class="btn btn-primary" value="練習を登録する">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
