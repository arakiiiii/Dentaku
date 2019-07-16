@extends("layouts.dentaku")
<style>
.form-group{
    margin-top: 30px;
}
.table {
    margin-top: 30px;
}
</style>
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
</script>
<div class="container">
        <div class="form-group">
            <label for="exampleInputEmail1">ユーザーID</label>
            <input class="form-control" id="userID" name="userID" placeholder="ユーザーID" value="{{$inputs->user_id}}">
            <small class="text-muted">ユーザーIDは半角英数字で6文字以上20文字以内で入力してください</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">名前</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="{{$inputs->name}}">
            <small class="text-muted">名前は15文字以内で入力してください</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">コメント</label>
            <textarea type="text" class="form-control" id="comment" name="comment" placeholder="コメント">{{$inputs->comment}}</textarea>
            <small class="text-muted">コメントは50文字以内で入力してください</small>
        </div>
        <button type="button" id="edit" class="btn btn-primary">送信する</button>
        <div id="error">
        </div>
    @if(isset($results))
    <table class="table">
        <tr>
            <th>計算履歴</th>
            <th>計算日</th>
        </tr>
        @foreach($results as $result)
        <tr>
            <td>{{$result->answer}}</td>
            <td>{{$result->update_time}}</td>
        </tr>
        @endforeach
    </table>
    @endif
    {{ $results->links()}}
</div>

<script>
$(function (){
    $('#edit').click(function(){
        $('li').remove('#erroritem');
        var name = $('#name').val();
        var userID = $('#userID').val();
        var comment = $('#comment').val();
        $.ajax({
            url: "{{ url('/edit') }}",
            type:'POST',
            data:{
                userID,
                name,
                comment
            },
            success: function(data){
                console.log(data);
                document.getElementById("edit").textContent = "送信する";
                if(data==""){
                    alert("編集に成功しました");

                }else{
                    $('#error').append(data);
                }
            },
            beforeSend: function(){
                document.getElementById("edit").innerHTML ='<div class="spinner-border text-white" role="status"><span class="sr-only">Loading...</span></div>'
            }
        })
    })
})
</script>
@endsection