
<!-- 投票主題_編輯功能_執行區域 -->

<?php
include_once "base.php";

// dd($_POST);// 用顯示陣列的方式觀測值
// exit();

// 接收來自表單傳來的更改後的內容-----------------------------------------------------------------------------------------------------------------
$subject_id=$_POST['subject_id']; // $subject_id 來自傳值 'subject_id'
$new_subject=$_POST['subject']; // 新資料透過POST表單獲取'subject'值, 將該值暫存於$new_subject

$subject=find('subjects',$subject_id);// 獲取資料表subjects內的$subject_id(第7行,傳值的id)資料
// dd($subject); // 7~11行撈出的資料, 就是api->add_vote.php裡 add出來的東西
$subject['subject']=$new_subject;// $subject=資料庫撈出的舊資料(10行)
                                 // $subject該資料庫裡的['subject']欄位的舊值 
                                 // 使用第8行表單獲取的$new_subject資料, 覆蓋掉上述$subject['subject']原有的資料
$subject['multiple']=$_POST['multiple'];// 資料表的multiple欄改為POST表單給的multiple值
$subject['type_id']=$_POST['types'];// 資料表的type_id欄改為POST表單給的types值(types表的id值)

// 使用save()函式把更改後的內容存到資料表'subjects'中-----------------------------------------------------------------------------------------------
save('subjects',$subject);
$opts=all("options",['subject_id'=>$subject_id]);// $opts=(options資料表的資料,而該資料表的[欄位subject_id內容改為=>POST表單帶來的$subject_id內容])

                              // 這裡的$key(索引)在$opt裡是否有相同的 若有 更新, 若無 新增
    foreach($_POST['option'] as $key => $opt){ // POST表單帶來的option內容(資料表options的option欄位), 轉為$key(索引)和$opt(內容/資料option欄位)
        $exist=false;// 將'資料存在'預設為否

            // 此foreach僅判斷'資料是否存在'於資料庫內, 若有 更新, 若無 新增
            foreach($opts as $ot){ // 將$opts(19行_被表單更新過的options資料表的資料) 賦值給 $ot(這賦值給$ot的資料內容為 資料表options的資料)
                    if($ot['id']==$key){// 若 $ot(資料表options)的[id欄位] == $key(22行 POST表單的option帶來的資料的索引值)時, 就讓'資料存在'改為true
                        $exist=true;// 該if用於 資料表內容==表單內容時, 該資料是存在的=>在下列進行更新
                        break;
                    }
                }
                echo $key."=>".$exist."<br>";// 觀測執行結果, 索引號碼=>1或0==true或flase

                if($exist){ // 若$exist為true時, 代表資料有存在資料庫, 所以在下列進行更新
                    // 更新選項
                    $ot['option']=$opt;// $ot(資料表options的資料)裡的option欄位 = $opt (POST表單帶來的option內容(資料表options的option欄位))
                    save("options",$ot);// saveFunction將上述存檔到options資料表的  option欄位=>($ot)
            }else{ // 新增選項
                $add_option=[
                    'option'=>$opt,// (22行)POST表單option(資料表options的option欄位)帶來的內容賦值給 $opt
                    'subject_id'=>$subject_id// (7行)POST表單subject_id(資料表options的subject_id欄位)帶來的內容賦值給 $subject_id
                ];
                save("options",$add_option);// saveFunction將上述存檔到options資料表的  option欄位=>($add_option)
            }
        
    }




to('../back.php');
?>