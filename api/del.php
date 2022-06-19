
<!-- 投票主題_刪除功能_執行區域 -->

<?php
include_once "base.php";

$table=$_GET['table'];
$id=$_GET['id'];
if($table=='subjects'){ //GET過來的值==subjects資料表時
    del($table,$id); // 刪除 $table的$id(主題)
    del('options',['subject_id'=>$id]); // 要刪除的 options資料表的subject_id欄位(選項) 為GET過來的id <如果=>用成, 會變成刪除subject_id欄位的所有id>
}else{// 若不==subjects資料表時 ,只刪除選項 不刪除主題
    del($table,$id);
}
// delFunction判斷式 條件與執行見base.php第198行

to("../back.php");




?>