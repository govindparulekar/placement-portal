<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../api/student/register.php?tpo_id=123&branch_id=6" method="post" enctype = "multipart/form-data">
        <input type="file" name="sheet" id="">
        <input type="submit" name = "submit" value="Upload">
    </form>
    <div class="btn-cont d-flex justify-content-between">
        <button id = "export" class="btn btn-primary">Export</button>
        <button id= "reject" class="btn btn-danger">Reject</button>
    </div>
</body>
</html>
