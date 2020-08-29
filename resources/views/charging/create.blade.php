@extends('layouts.app')

@section('head')
    <script type="application/javascript">
        $(document).ready(function () {
            let form = $('#charging-store'),
                original = form.serialize();

            form.submit(function () {
                window.onbeforeunload = null
            });

            window.onbeforeunload = function () {
                console.log(form.serialize() !== original);
                if (form.serialize() !== original)
                    return 'Die Eingaben wurden noch nicht gespeichert!'
            }
        })
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('battery.index') }}">
                            <i class="fas fa-arrow-left"></i>
                        </a>&nbsp;
                        Ladezustand von {{ $battery->name }}
                    </div>

                    <div class="card-body">
                        @include('charging.parts.form-create')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
