<form id="charging-store-{{ $battery->id }}" method="POST"
      action="{{ route('charging.store', ['battery' => $battery->id]) }}">
    @csrf

    <div class="form-group col-12 p-0 my-2">
        <div class="input-group">
            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-battery-half"></i>
                                            </span>
            </div>
            <input id="load-{{ $battery->id }}" type="number"
                   class="form-control @error('load') is-invalid @enderror" name="load"
                   value="{{ old('load') }}" min="0" max="100" step="1" placeholder="neuer Ladezustand" required autofocus>
            <div class="input-group-append">
                <span class="input-group-text">%</span>
                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Speichern">
                    <i class="far fa-save"></i>
                </button>
            </div>
        </div>

        @error('load')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</form>
