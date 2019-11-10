
@extends('layouts.admin.plofile')

<!-- admin.blade.phpの@yield('title')に'プロフィールの編集'を埋め込む -->
@section('title', 'プロフィールの編集')

<!-- admin.blade.phpの@yield('content')に以下のタグを埋め込む -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>プロフィール編集</h2>
                <form action="{ action('Admin\PlofileController@update') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="name">名前</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="{{ $plofile_form->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-10" for="gender">性別</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="gender" value="{{ $plofile_form->gender }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection