<?php
include_once "base.php";
// 接收來自表單傳來的投票主題文字內容
$subject=$_POST['subject'];

$add_subject=[// add_data變數設置為陣列, 'subject'的資料為POST抓下來的資料$subject
    'subject'=>$subject,
    'type_id'=>$_POST['types'], // subjects表 type_id欄 填入 POST帶來的types值
    'multiple'=>$_POST['multiple'], // 資料表辨別單複選的multiple欄位 其值 來自POST表單選的multiple
    'start'=>date("Y-m-d"), // 開始(今天)
    'end'=>date("Y-m-d",strtotime("+10 days")), // 結束(把今日+10天)

];

// 使用save()函式把投票主題存至資料表subjects中
save('subjects',$add_subject);
$id=find('subjects',['subject'=>$subject])['id'];// 重新將投票名稱丟回去 獲得find的資料 = 我要找的那筆資料
// function find : 用於回傳資料表內有符合指定條件的單筆資料----<在base.php的170行>
// $id=find功能(條件1.使用資料表'subjects',
//              條件2.[條件為 資料表內的'subject'欄位 若內容等於剛才使用者在網頁寫入的投票主題的內容=>這裡的$subject指第4行的POST帶來的值])
//              而該find的function於結尾retrun回傳的是fetch完的該(PDO::FETCH_ASSOC)欄位名稱
//              而我要的是[id]這個欄位的內容  最終 上述條件完 獲得 資料表'subjects'的id內容給$id

if(isset($_POST['option'])){//若POST表單給予了選項 就表示opstion參數存在 執行foreach
    foreach($_POST['option'] as $opt){// foreach使用POST['option']帶來的值做為陣列處理, 將變成陣列內容的值 賦值給$opt
        if($opt!=""){//若$opt得到了foreach使用POST['option']帶來的值, 該$opt為非空值 執行下列
            $add_option=[//將 資料表欄位'option'=選項$opt  和  資料表欄位'subject_id'=主題$id   做為陣列賦值給 $add_option
                'option'=>$opt,
                'subject_id'=>$id
            ];
            // 使用save()函式把投票選項存至資料表options中
            save("options",$add_option);
            // 執行base.php->135行, 將這裡獲取的"options",$add_option 使用saveFunction 使用資料表id對應去更新資料 若無資料 則新增資料
        }
    }
}

// header("location:../back.php");// 使用base.php->110行的toFinction取代header作為路徑變更設定
to('../back.php');
?>