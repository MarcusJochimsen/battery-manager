@extends('layouts.app')

@section('head')
    <script type="application/javascript">
        $(document).ready(function () {
            @isset($batteryFocused)
                $( "#load-{{ $batteryFocused }}" ).focus();
            @endisset
        })
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header font-weight-bold">Übersicht</div>
                    <div class="card-body">
                        @foreach($batteries as $battery)
                            <div class="card">
                                <div class="card-header d-flex justify-content-between {{ $battery->chargingStatusColor() }}">
                                    <span class="font-weight-bold">{{ $battery->name }}  <i class="{{ $battery->lastChargingChangeStatus() }} fas fa-exclamation-triangle"></i></span>
                                    <span>{{ $battery->actualLoad() }}% <i>({{ $battery->lastChargingChangeHuman() }})</i></span>
                                </div>
                                <div class="card-body">
                                    <div class="col-12 py-2 d-flex justify-content-between">
                                        <div class="input-group p-0 col-5" title="Anzahl der Ladungen">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-charging-station"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" value="{{ $battery->charged() }}" disabled>
                                        </div>
                                        <div class="input-group p-0 col-5" title="Anzahl der Ladezyklen">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-battery-three-quarters"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" value="{{ $battery->chargeCycles() }}" disabled>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 py-2">
                                        @include('charging.parts.form-create')
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
