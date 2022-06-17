


<?php
$id=$_GET['id'];
$subj=find('subjects',$id);// findFunction 只找一筆資料
$opts=all('options',['subject_id'=>$id]);// allFunction 找全部資料
// dd($subj);
// dd($opts);


?>

<form action="./api/edit_vote.php" method="post">
    <div>
        <label for="subject">投票主題：</label><!-- label的for可以使用id值做連接, 將下列的input用id連接後 兩者可以產生關聯 -->
        <input type="text" name="subject" id="subject" value="<?=$subj['subject'];?>"><!-- 第6行找到的資料用 值=$subj的資料表欄位['subject']內容  顯示 -->
        <input type="button" value="新增選項" onclick="more()"><!-- '每點一下'就會新增, 所以使用onclick去add -->
    </div>
    <div id="options">
        <?php
        foreach($opts as $opt){// 查找到的每一個選項內容(7行) as 作為一個資料內容呈現(36行) , 不須顯示值的索引值 所以不輸入$key只用$opt(內容)
        ?>
        <div>
            <!-- 顯示的值value=$opt(22行)options資料庫的option資料欄位的內容 -->
            <label>選項:</label><input type="text" name="option[]" value="<?=$opt['option'];?>">
        </div>
        <?php
        }
        ?>
    </div>
    <input type="submit" value="修改">

</form>
<script>
    function more(){
        let opt=`<div><label>選項:</label><input type="text" name="option[]"></div>`;
        let opts=document.getElementById('options').innerHTML;// 變數opts=由id:options的內容賦值.使用innerHTML縮小查找與顯示該ID範圍
        opts=opts+opt;// 將opts再加上opt的內容(即click後的'新增選項'表單)
        document.getElementById('options').innerHTML=opts;
    }
</script>