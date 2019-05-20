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
<h1><a href="/status">查看审核状态</a></h1>
<form action="companyDo" method="post" enctype="multipart/form-data">
    <p>
        公司名称:<input type="text" name="company_name">
    </p>
    <p>
        公司法人:<input type="text" name="company_user">
    </p>
    <p>
        公司账户:<input type="text" name="company_account">
    </p>
    <p>
        对公账号:<input type="text" name="company_pub">
    </p>
    <p>
        营业执照:<input type="file" name="company_img">
    </p>
    <p>
        <input type="submit" value="注册">
    </p>
</form>
</body>
</html>