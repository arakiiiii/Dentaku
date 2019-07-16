@extends("layouts.dentaku")
<style>
.table{
    margin-top:50px;
}
.right{
    text-align:right;
    font-size:10px;

}
.center{
    text-align:center;
}
.answerItem {
    display: none;
}

</style>
@section('content')
<div class="container">
<table class="table">
    <thead>
        <tr>
            <th>名前</th>
            <th>コメント</th>
            <th>履歴</th>
        </tr>
    </thead>
        <tbody>
        @foreach($results as $result)
        <tr>
            <th name="name">{{$result->name}}</th>
            @if($result->comment == null)
                <th><small>コメントはありません</small></th>
            @else
                <th>{{$result->comment}}</th>
            @endif
            <th><button type="button" id="user{{$result->id}}" class="btn btn-primary" data-toggle="modal" data-target="#Modal{{$result->id}}">詳細</button></th>
        </tr>

        <!-- モーダルの設定 -->
        <div class="modal fade" id="Modal{{$result->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{$result->name}}の計算履歴</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <?php $e = 0 ?>
            @if(count($result->answer) != 0)
                @for($i=0; $i<count($result->answer); $i++)
                @if($i % 3 == 0)
                    <?php $e += 1 ?>
                @endif
                <div class="no{{$i}} page-{{$e}} answerItem">{{$result->answer[$i]->answer}}</div>
                <div class="no{{$i}} page-{{$e}} answerItem right">{{$result->answer[$i]->update_time}}</div>
                @endfor
            @else
                <small>計算履歴はありません</small>
            @endif
            </div>
            <div class="modal-footer">

            @if(count($result->answer) != 0)
                <div class="pagination-holder clearfix">
                    <div id="light-pagination" class="pagination{{$result->id}}"></div>
                </div>

                <script>
                $(function () {
                    $(".pagination{{$result->id}}").pagination({
                        items: {{$e}},
                        displayedPages: 3,
                        prevText:"前へ",
                        nextText:"次へ",
                        cssStyle: 'light-theme',
                        onPageClick: function (currentPageNumber) {
                            showPage(currentPageNumber);
                        }
                    })
                })

                function showPage(currentPageNumber) {
                    var page = ".page-" + currentPageNumber;
                    $('.answerItem').hide();
                    $(page).show();
                }
                </script>
            @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
            </div>
            </div>
        </div>
        </div>
        @endforeach
    </tbody>
</table>
<div class="center">
{{$results->links()}}
</div>
</div>

<script>
showPage(1)
</script>
@endsection