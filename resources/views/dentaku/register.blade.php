@extends("layouts.login")
@section('title','新規登録')

<style>
.form-group{
    margin-top: 30px;
}
</style>

@section("content")
<div class="container">
    <form action={{ url('/signUp') }} method="post">
    {{ csrf_field() }}
        <div class="form-group">
            <label for="exampleInputEmail1">ユーザーID</label>
            <input class="form-control" id="exampleInputEmail1" name="userID" placeholder="ユーザーID">
            <small class="text-muted">ユーザーIDは半角英数字で6文字以上２０文字以内で入力してください</small>
        </div>
        <div class="form-group">
            <label for="">名前</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="name" placeholder="名前">
            <small class="text-muted">名前は15文字以内で入力してください</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">パスワード</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="パスワード">
            <small class="text-muted">パスワードは半角英数字で6文字以上２０文字以内で入力してください</small>
        </div>
    <button type="submit" class="btn btn-primary">送信する</button>
    </form>
@if($errors != null)
<ul>
@foreach($errors as $error)
    @foreach($error as $item)
    <li>{{$item}}</li>
    @endforeach
@endforeach
</ul>
@endif
</div>
@endsection