@extends('layouts.app')

@section('style')
<link href="{{ asset('css/location_list.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">練習場所一覧</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>※コート料金、照明料金は1時間あたりの金額</p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>場所名</th>
                                <th>郵便番号</th>
                                <th>住所</th>
                                <th>コート料金</th>
                                <th>照明料金</th>
                                <th>ウェブサイト</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->postal_code }}</td>
                                    <td>{{ $location->adress }}</td>
                                    <td>{{ $location->price }}</td>
                                    <td>{{ $location->light_up }}</td>
                                    <td>
                                        <a href="{{ $location->url }}" target="_blank" rel="noopener noreferrer">開く</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="javascript:history.back()">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection