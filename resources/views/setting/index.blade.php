@extends('layouts.app')

{{--@section('head')--}}
{{--    <script type="application/javascript">--}}
{{--        $(document).ready(function () {--}}
{{--            $('.collapse').collapse();--}}
{{--        })--}}
{{--    </script>--}}
{{--@endsection--}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header font-weight-bold">Einstellungen</div>
                    <div class="card-body">
                        <div class="accordion" id="accordionSetting">
                            <div class="card">
                                <div class="card-header" id="headingProfile">
                                    <h5 class="mb-0">
                                        <button class="btn" type="button" data-toggle="collapse"
                                                data-target="#collapseProfile" aria-expanded="true"
                                                aria-controls="collapseProfile">
                                            Profil
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseProfile" class="collapse show" aria-labelledby="headingProfile"
                                     data-parent="#accordionSetting">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('user.update') }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="PUT">

                                            <div class="form-group row">
                                                <label for="name"
                                                       class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                                <div class="col-md-6">
                                                    <input id="name" type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           name="name" value="{{ old('name', $user->name) }}" required
                                                           autocomplete="name" autofocus>

                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="email"
                                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                                <div class="col-md-6">
                                                    <input id="email" type="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           name="email" value="{{ old('email', $user->email) }}" required
                                                           autocomplete="email">

                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Speichern
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingBackup">
                                    <h5 class="mb-0">
                                        <button class="btn collapsed" type="button" data-toggle="collapse"
                                                data-target="#collapseBackup" aria-expanded="false"
                                                aria-controls="collapseBackup">
                                            Datensicherung
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseBackup" class="collapse" aria-labelledby="headingBackup"
                                     data-parent="#accordionSetting">
                                    <div class="card-body">
                                        <a class="btn btn-primary" href="{{ route('user.index') }}" role="button">Backup herunterladen</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
