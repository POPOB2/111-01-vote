
<!-- 前台投票項目 點入後顯示的投票詳細內容 -->

<?php
include_once "./api/base.php";

$subject=find("subjects",$_GET['id']);
$opts=all('options',['subject_id'=>$_GET['id']]);

// dd($subject);
// dd($opts);
?>
<!--  -->
<h1><?=$subject['subject'];?></h1>
<form action="./api/vote.php" method="post">
<?php
foreach($opts as $opt){
?>
    <div class="vote-item">
        <?php 
        if($subject['multiple']==0){ // 當$subject的multiple==0時
        ?>
        <!-- 上面的opts值給了opt  所以這裡name放入opt做為資料來源 經過傳值來的opt的id 顯示該id的value(值) -->
        <input type="radio" name="opt" value="<?=$opt['id'];?>"> <!-- 顯示radio 單選的按鈕 -->
        <?php
        }else{
        ?>
        <!-- 這裡name放入opt做為資料來源, 但因為複選會有複數資料, 所以在opt後面加上[], 才可以讓資料到後台時 作為陣列使用  -->
        <input type="checkbox" name="opt[]" value="<?=$opt['id'];?>"> <!-- 顯示checkbox 複選的按鈕 -->
        <?php
        }
        ?>
        <?=$opt['option'];?> 
    </div>



<?php
}
?>

<input type="submit" value="投票去">
<input type="reset" value="重置">
<input type="button" value="放棄" onclick="location.href='index.php'">
</form>