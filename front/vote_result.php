



<?php
$subject=find("subjects",$_GET['id']);// 用find 把GET到的id值 用於查找subjects表的資料 將該筆資料賦值給$subject

$opts=all("options",['subject_id'=>$_GET['id']]);// 用all將GET到的id值 用於查找options表的subject_id欄符合GET到的id值的資料
//給定資料表名和條件後，會回傳符合條件的所有資料
?>
<h1 class="text-center"><?=$subject['subject'];?></h1>
<div style="width:600px;margin:auto">

    <div>總投票數:<?=$subject['total'];?></div>
    <table>
       
        <tr>
            <td>選項</td>
            <td>投票數</td>
            <td>比例</td>
        </tr>
        <?php
        foreach($opts as $opt){ // 使用foreach將$opts(資料內容:第8行註解) 以陣列的方式 塞給$opt
            $total=($subject['total']==0)?1:$subject['total'];
            // 在某些程式語言 進行除法運算時, 若分母為0會產生錯誤 所以在這裡增加一個三元運算, 判斷分母若為0則給分母賦值1, 否則顯示totalㄈ原有值
        ?>
        <tr>
            <!-- 將$opt的陣列資料 取出 顯示再 對應欄位上(18~20行) -->
            <td><?=$opt['option'];?></td>
            <td><?=$opt['total'];?></td>
            <td><?=$opt['total']/$total;?></td><!-- 將opt的total值 除以 subjects表內GET id指定的欄位的total值 -->
        </tr>
        <?php
        }
        ?>
    </table>
    <button onclick="location.href='?do=vote&id=<?=$subject['id'];?>'">我要投票</button><!--  -->
</div>