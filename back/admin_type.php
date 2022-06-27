

<!-- 分類管理 -->
<!-- 以POST傳資料到api/add_type.php, 資料內容標記為name(該標記用於api/add_type.php內的base.php引用的saveFunction辨識放到表的哪個欄)   -->
<form action="./api/add_type.php" method="post">
    <div>
        <label for="name">分類名稱</label>
        <input type="text" name="name" id="name">
    </div>
    <div>
        <input class="btn btn-primary" type="submit" value="送出">
    </div>
</form>
