@extends("layouts.dentaku")
<STYLE>

#page-1 {
    display: block;
}

</STYLE>
@section("content")

<div class="selection" id="page-1">
    <h1>ホームページにページング機能を追加しよう！</h1>
    <h2>事前準備</h2>
    <p>準備についての文章</p>
</div>

<div class="selection" id="page-2">
    <h2>追加方法1</h2>
    <p>追加方法1についての文章</p>
</div>

<div class="selection" id="page-3">
    <h2>追加方法2</h2>
    <p>追加方法2についての文章</p>
</div>

<div class="selection" id="page-4">
    <h2>追加方法3</h2>
    <p>追加方法3についての文章</p>
</div>
<div class="selection" id="page-5">
    <h2>追加方法3</h2>
    <p>追加方法3についての文章</p>
</div>
<div class="selection" id="page-6">
    <h2>追加方法3</h2>
    <p>追加方法3についての文章</p>
</div>
<div class="selection" id="page-7">
    <h2>追加方法3</h2>
    <p>追加方法3についての文章</p>
</div>
<div class="selection" id="page-8">
    <h2>追加方法3</h2>
    <p>追加方法3についての文章</p>
</div>

<div class="pagination-holder clearfix">
    <div id="light-pagination" class="pagination"></div>
</div>

<script type="text/javascript">

    $(function () {
        $(".pagination").pagination({
            items: 10,
            displayedPages: 3,
            prevText:"前へ",
            nextText:"次へ",
            cssStyle: 'light-theme',
            onPageClick: function (currentPageNumber) {
                showPage(currentPageNumber);
            }
        })
    });
    function showPage(currentPageNumber) {
        var page = "#page-" + currentPageNumber;
        $('.selection').hide();
        $(page).show();
    }

</script>
@endsection