@extends('layouts.front')
@section('title','プロフィール一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>プロフィール一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-8">
                <form action="{{ action('ProfileController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">名前</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-profiles col-md-12 mx-auto">
                <div class="row">
                    <div class="table table-light">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="40%">名前</th>
                                <th width="50%">性別</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($post as $profile)
                                <tr>
                                    <th>{{ $profile->id }}</th> <!-- table header -->
                                    <td>{{ \Str::limit($profile->name, 100) }}</td> <!-- table data -->
                                    <td>{{ \Str::limit($profile->gender, 100) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>