<div class="modal fade" id="modal{{ $practice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route($route) }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">利用情報: {{ $date . ' ' . $location }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf

                    <div class="form-group row">
                        <label for="usage_time" class="col-md-5 col-form-label text-md-right">コート利用時間</label>

                        <div class="col-md-6">
                            <input id="usage_time" type="number" class="form-control @error('usage_time') is-invalid @enderror" name="usage_time" value="{{ $usage_time }}" min="0" required autofocus>

                            @error('usage_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="coat" class="col-md-5 col-form-label text-md-right">面数</label>

                        <div class="col-md-6">
                            <input id="coat" type="number" class="form-control @error('coat') is-invalid @enderror" name="coat" value="{{ $coat }}" min="0" required autofocus>

                            @error('coat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="light_up_time" class="col-md-5 col-form-label text-md-right">照明利用時間</label>

                        <div class="col-md-6">
                            <input id="light_up_time" type="number" class="form-control @error('light_up_time') is-invalid @enderror" name="light_up_time" value="{{ $light_up_time }}" min="0" required autofocus>

                            @error('light_up_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    <input type="hidden" value="{{ $id }}" name="id">
                    <input type="submit" class="btn btn-primary" value="変更を保存">
                </div>

            </form>
        </div>
    </div>
</div>