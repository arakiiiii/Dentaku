@extends("layouts.dentaku")
<style>
.btn {
    width: 100px;
    height: 50px;
}
.max-auto {
    margin: 0 auto;
}
.first {
    font-size: 50px;
    height: 80px;
    margin-bottom: 0px;
    font-family: 'arial black';
    text-align: right;
}
.second {
    text-align: right;
    height: 20px;
}
.error {
    margin-top:20px;
}
.erroritem{
    color:red;
}
.historyItem {
    display: none;
}


</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>

    let result = "";
    let num = 0;
    //　数字を作る
    let array = [];
    let kigouArray = [];
    function buttonClick(btn) {
        if (num == 0) {
            num = "" + btn;
        } else {
            num += "" + btn;
        }
        document.getElementById('first').textContent = num;
    }

    //　消す部分
    function CEClick() {
        document.getElementById('first').textContent = "";
        num = 0;
    }

    function CClick() {
        document.getElementById('first').textContent = "";
        document.getElementById('second').textContent = "";
        num = 0;
        result = 0;
        array = [];
        kigouArray = [];
    }

    function delClick() {
        if (num != 0) {
            num = num.slice(0, -1);
            document.getElementById('first').textContent = num;
        }
    }

    function kigouClick(kigou) {
        if (num != 0) {
            //secondに正しく映すためのコード
            if (result == "") {
                result = num;
            } else {
                if (num != 0) {
                    result += num;
                }
            }
            if(kigou=="*"){
                result += " × ";
            } else if(kigou=="/"){
                result += " ÷ ";
            }else {
                result += " "+kigou+" ";
            }
            document.getElementById('second').textContent = result;

            array.push(num);
            kigouArray.push(kigou);

            num = 0;
        }
    }

    function plusminus(){
        if(num != ""){
            if(num.slice(0,1) != "-"){
                num = "-"  + num;
                document.getElementById('first').textContent = num;
            } else if(num.slice(0,1) == "-"){
                num = num.slice(1);
                document.getElementById('first').textContent = num;
            }
        }
    }

    function dot(){
        if(num!=""){
            var a = num.indexOf(".");
            if(a == -1){
                num += ".";
                document.getElementById('first').textContent = num;
            }
        }
    }

    function equal(){
        if (num != 0 && result != ""){
            result += num;
            result += " = ";

            array.push(num);

            let param = {
                kigouArray: kigouArray,
                array: array,
            }

            sendData(param);

            data = [];
            num = 0;
            array = [];
            kigouArray = [];
            answer = 0;
            param = [];
        }
    }

    function sendData(param){
        $("li").remove("#erroritem");

        $(function (){
            $.when(
                $.ajax({
                    url: "{{ url('/sendData') }}",
                    type:'POST',
                    data:{
                        param,
                    },
                    success: function(data){
                        if(data.results != null){
                            document.getElementById("second").textContent = data.results[0].answer;
                            document.getElementById("first").textContent = data.results[0].result;
                            showResults(data.results[1]);
                        }else{
                        $('#error').append('<li id="erroritem" class="erroritem">'+data+'</li>');

                        }
                    }
                })
            ).done(function(){
                data = [];
                result = 0;
                num = 0;
                array = [];
                kigouArray = [];
                answer = 0;
                param = [];
            })
        })
    }

    function clearHistory(){

        $("tr").remove(".historyItem");

        $(function (){
            $.ajax({
                url: "{{ url('/deleteData') }}",
                type:'POST',
                success: function(){
                    console.log('clear成功'),
                    paginate(0);
                }
            });
        });
    }

    function showResults(data){
        //初期化
        $("tr").remove(".historyItem");
        //sendDataが押されたとき
        if(data != null){
            $(function (){
                var e = 0;
            for(var i=0; i<data.length; i ++){
                if(i%3 == 0){
                    e += 1;
                }
                $('#history').append('<tr class="page-'+e+' no'+i+' historyItem"><td>'+data[i].answer+'</td><td>'+data[i].update_time+'</td></tr>')
            }
            paginate(e);
            showPage(1);
        })
        // 初期設定
        }else{
            @if($results != null)
                $(function (){
                    <?php $e = 0 ?>
                    @for($i=0; $i<count($results); $i++)
                        @if($i%3==0)
                            <?php $e += 1 ?>
                        @endif
                        $('#history').append('<tr class="page-{{$e}} no{{$i}} historyItem"><td>{{$results[$i]->answer}}</td><td>{{$results[$i]->update_time}}</td></tr>');
                    @endfor
                    paginate({{$e}});
                    showPage(1);
                })
            @endif

        }

    }

    function paginate(number){
        $(function () {
            $(".pagination").pagination({
                items: number,
                displayedPages: 3,
                prevText:"前へ",
                nextText:"次へ",
                cssStyle: 'light-theme',
                onPageClick: function (currentPageNumber) {
                    showPage(currentPageNumber);
                }
            })
        })
    }

    function showPage(currentPageNumber) {
        var page = ".page-" + currentPageNumber;
        $('.historyItem').hide();
        $(page).show();
    }
    //最初に履歴出すやつ
    @if($results != "")
    showResults();
    @endif
    window.onload=paginate();

</script>
@section("content")
<h1>exampleViewです</h1>
<script>
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
</script>
<div class="container">

    <p id='first' class='first'></p>
    <p id='second' class='second'></p>

    <table class='keyboard max-auto'>
        <tr>
            <td><button class='btn btn-danger' onclick='CEClick();'>CE</button></td>
            <td><button class='btn btn-danger' onclick='CClick();'>C</button></td>
            <td><button class='btn btn-warning' onclick='delClick();'>del</button></td>
            <td><button class='btn btn-success' onclick='kigouClick("/")'>÷</button></td>
        </tr>
        <tr>
            <td><button class='btn btn-secondary' onclick='buttonClick(7);'>7</button></td>
            <td><button class='btn btn-secondary' onclick='buttonClick(8);'>8</button></td>
            <td><button class='btn btn-secondary' onclick='buttonClick(9);'>9</button></td>
            <td><button class='btn btn-success' onclick='kigouClick("*")'>×</button></td>
        </tr>
        <tr>
            <td><button class='btn btn-secondary' onclick='buttonClick(4);'>4</button></td>
            <td><button class='btn btn-secondary' onclick='buttonClick(5);'>5</button></td>
            <td><button class='btn btn-secondary' onclick='buttonClick(6);'>6</button></td>
            <td><button class='btn btn-success' onclick="kigouClick('-')">-</button></td>
        </tr>
        <tr>
            <td><button class='btn btn-secondary' onclick='buttonClick(1);'>1</button></td>
            <td><button class='btn btn-secondary' onclick='buttonClick(2);'>2</button></td>
            <td><button class='btn btn-secondary' onclick='buttonClick(3);'>3</button></td>
            <td><button class='btn btn-success' onclick='kigouClick("+")'>+</button></td>
        </tr>
        <tr>
            <td><button class='btn btn-dark  rounded-pill' onclick="plusminus()">±</button></td>
            <td><button class='btn btn-secondary' onclick='buttonClick(0);'>0</button></td>
            <td><button class='btn btn-dark rounded-pill' onclick="dot();">.</button></td>
            <td><button class='btn btn-primary' onclick="equal()">=</button></td>
        </tr>

    </table>
    <ul id="error" class="error">
        <li>5回以上連続で計算するとエラーが発生します</li>
        <li>9999999以上の数字は計算できません</li>
    </ul>
    <button type="button" class="btn-danger rounded-pill " onclick='clearHistory()'>履歴を削除</button>


    <table class="table">
        <thead>
            <tr>
            <th>計算結果</th>
            <th>計算日</th>
            </tr>
        </thead>
        <tbody id="history">
        </tbody>
        <div class="pagination-holder clearfix">
            <div id="light-pagination" class="pagination"></div>
        </div>
    </table>

</div>

@endsection