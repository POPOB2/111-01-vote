

<!-- 紀錄投票結果 -->

<?php
include_once "base.php";

// dd($_POST);

// 並增加一個log  讓有登入沒登入有投票上的差異, 此時為設定的情況下user_id 為0 沒有值
// front/vote.php 按下單複選送出資料後  資料送到這裡來  開始撈出資料 去加total值 
// 為了知道POST過來的傳值是否為單個 或 多個 使用is_array 去看 傳過來的 opt(選擇項目後 產生的index與options表的id欄) 是否為陣列
// 就算再複選只選一個  也會是陣列 例:索引[0]=>id[38]

/* 再input選擇 radio && checkbox 這兩種的情況下  只會傳已勾選的選項(值)  不會傳未勾選的選項(值) 過來
   利用 這個特性 可以知道 傳過來的 一定是有勾選的 */

    

// ***避免選多個選項 再主題的total加太多值, 所以需要將'選項'以foreach對total加值, 將'主題'以if對total加值, 拆開執行 如下:

if(isset($_POST['opt'])){// 若下列給了空值 會產生錯誤 所以使用if判斷是否執行 若是空值就直接回首頁或是跳出錯誤訊息
if(is_array($_POST['opt'])){// 先判斷front/vote.php的opt是否為陣列
    //若為複選題 更新資料
    foreach($_POST['opt'] as $key => $opt){ // 使用foreach陸續將POST過來的opt填入 $key(index)=>$opt(id)
        $option=find("options",$opt); // find會回傳資料表指定條件的單筆資料 // 使用options表 的$opt(POST來的id值) 挑出該id值的整筆資料  賦值給$option
        $option['total']++; // $option(options表的POST過來的id值取出的該id的整筆資料)的total欄位  值+1
        save("options",$option); // save()-整合insert()和update()的功能為一支函式 , 將options表 的 $option值(上述由id帶入整筆並在total有變動的值) 存檔更新
    
        if($key==0){ //  無論在複選題選幾個答案 索引只會(一定)有一個  所以當有選答案時 必然有一個$key==0
    // find會回傳資料表指定條件的單筆資料
    // subjetcs表, $option(上述由id帶入整筆並在total有變動的值)在該筆id資料的subject_id欄的值(假設2)  去找到與之相連的subjetcs表的id值(假設2)
    // 將subjects表的id值(假設2)的整筆資料  賦值給$subject, 
            $subject=find("subjects",$option['subject_id']); // 此時$subject 內容為subjects表的id值(假設2)的整筆資料
            $subject['total']++; // 將上述已被指定id的$subjects整筆資料  的total欄位++
            save("subjects",$subject); // 將subjects表 的 $subject值(上述由id帶入整筆並在total有變動的值) 存檔更新
        }
        // 若是陣列(複選題) 則以下
        // isset變數是否存在(查詢SESSION帶進來的user 是否存在) true=$_SESSION的user值:flase=0; 將true或flase的值給$log
        $log=['user_id'=>(isset($_SESSION['user']))?$_SESSION['user']:0, 
              'subject_id'=>$subject['id'],
              'option_id'=>$option['id']];
        save("logs",$log);
    }
}else{      
        // 若不是陣列(單選題) 則以下
        // 將  用POST傳值給opt的內容查找options表裡的值  再將該筆資料給$option
        $option=find("options",$_POST['opt']);
        $option['total']++;
        save("options",$option);
        $subject=find("subjects",$option['subject_id']);
        $subject['total']++;
        save("subjects",$subject);
        $log=['user_id'=>(isset($_SESSION['user']))?$_SESSION['user']:0,
             'subject_id'=>$subject['id'],
             'option_id'=>$option['id']];
        save("logs",$log);
}
}
to("../index.php?do=vote_result&id={$option['subject_id']}"); // 用?帶值 id去到$option(subjects表)的subject_id欄 的值
?>