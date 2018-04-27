@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Statistics
@endsection

@section('main-content')

    {{ json_encode($messages) }}
    {{ json_encode($totalUsers) }}
    {{ json_encode($users) }}

    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <statistics-chart
                        :total-users="{{ json_encode($totalUsers) }}"
                        :messages="{{ json_encode($messages) }}"
                        :users="{{ json_encode($users) }}"
                ></statistics-chart>
            </div>
        </div>

    </div>
@endsection