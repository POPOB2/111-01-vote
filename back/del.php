
<!-- 刪除頁面 -->

<?php

$subj=find("subjects",$_GET['id']);


?>

<div class="confirm" style="width:500px; margin:2rem auto; border:1px solid #ccc; box-shadow:2px 2px 15px #999; padding:2rem;">
    <h2 style="text-align:center; color:red">確定要刪除該筆投票嗎</h2>
    <div>主題:</div>
    <div style="font-size:1.5rem;text-align:center"><?=$subj['subject'];?></div>

    <!-- 按下時 到api的del.php(將刪除要用的參數告知給del.php)  要刪除的table為subjects, 而要刪除的資料為GET傳值給的id -->
    <button onclick="location.href='./api/del.php?table=subjects&id=<?=$_GET['id'];?>'">確定刪除</button>
    <button onclick="location.href='back.php'">取消刪除</button>
</div>