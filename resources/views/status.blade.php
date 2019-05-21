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
<table>
    <tr>
        <td>APPID:</td>
        <td id="appid"></td>

    </tr>
    <tbody class="status">
    <tr>
        <td>KEY:</td>
        <td id="key"></td>

    </tr>
    </tbody>
    <input type="button" value="获取主机ip：" id="ip"><br/>
    <input type="button" value="获取UA：" id="ua">

</table>
</body>
</html>
<script src="js/jquery.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url:"/status",
            method:"post",
            dataType:"json",
            success:function(data){
                APPID:$('#appid').html(data.appid);
                KEY:$('#key').html(data.key);
            }
        })
        //获取主机ip
        $(document).on('click','#ip',function(){
            $.ajax({
                url:"/ip",
                method:"post",
                dataType:"json",
                success:function(data){
                    $('#ip').append(data);
                }
            })
        })
    })
</script>