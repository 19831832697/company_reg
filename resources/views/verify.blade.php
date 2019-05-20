<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table border="1">
    <tr>
        <td>公司id</td>
        <td>公司名称</td>
        <td>公司法人</td>
        <td>公司账户</td>
        <td>对公账号</td>
        {{--<td>营业执照</td>--}}
        <td>操作</td>
    </tr>
    @foreach($data as $v)
    <tr>
        <td>{{$v->company_id}}</td>
        <td>{{$v->company_name}}</td>
        <td>{{$v->company_user}}</td>
        <td>{{$v->company_account}}</td>
        <td>{{$v->company_pub}}</td>
        {{--<td><img src="file:///Z:/laravel/storage/app/{{$v->company_img}}" alt=""></td>--}}
        <td>
            <a href="javascript:;" class="pass" id="{{$v->company_id}}">通过</a>||
            <a href="javascript:;" class="reject" id="{{$v->company_id}}">驳回</a>
        </td>
    </tr>
    @endforeach
</table>
</body>
</html>
<script src="js/jquery.js"></script>
<script>
    $(document).ready(function(){
        //审核通过
        $(document).on('click','.pass',function(){
            var company_id=$(this).attr('id');
            var data={};
            data.company_id=company_id;
            $.ajax({
                url:"/pass",
                method:"POST",
                data:data,
                dataType:"json",
                success:function(data){
                    if(data.code==200){
                        alert(data.msg)
                    }else if(data.code==20020){
                        alert(data.msg);
                    }
                }
            })
        })
        //驳回
        $(document).on('click','.reject',function(){
            var company_id=$(this).attr('id');
            var data={};
            data.company_id=company_id;
            $.ajax({
                url:"/reject",
                method:"POST",
                data:data,
                dataType:"json",
                success:function(data){
                    if(data.code==200){
                        alert(data.msg)
                    }else if(data.code==40020){
                        alert(data.msg);
                    }
                }
            })
        })

    })
</script>