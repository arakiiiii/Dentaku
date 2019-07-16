@extends("layouts.login")
@section('title','ログイン画面')
<style>
.form-group{
    margin-top: 30px;
}
</style>

@section("content")
<div class="container">
    <form action={{ url('/signIn') }} method="post">
    {{ csrf_field() }}
        <div class="form-group" action="/signIn">
            <label for="exampleInputEmail1">ユーザーID</label>
            <input class="form-control" id="exampleInputEmail1" name="userID" placeholder="ユーザーID">
            <small class="text-muted">ユーザーIDは半角英数字で6文字以上20文字以内で入力してください</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">パスワード</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="パスワード">
            <small class="text-muted">パスワードは半角英数字で6文字以上20文字以内で入力してください</small>
        </div>
    <button type="submit" class="btn btn-primary">送信する</button>
    </form>

@if($errors != [])
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