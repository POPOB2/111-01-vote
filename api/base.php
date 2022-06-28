<!-- 用於多個頁面重複使用的指令 -->

<?php
session_start(); // 會用到session 先宣告session_start()
date_default_timezone_set('Asia/Taipei'); // 該程式使用的時區為何

function pdo(){
    $dsn="mysql:host=localhost;charset=utf8;dbname=s1110103";
    return new PDO($dsn,'s1110103','s1110103');
    // $dsn="mysql:host=localhost;charset=utf8;dbname=vote";
    // return new PDO($dsn,'root','');
}
// ---------------------------all()-給定資料表名和條件後，會回傳符合條件的所有資料---------------------------------------------
/**
 * $table - 資料表名稱 字串型式
 * ...$arg - 參數型態
 *           1. 沒有參數，撈出資料表全部資料
 *           2. 一個參數：
 *              a. 陣列 - 撈出符合陣列key = value 條件的全部資料
 *              b. 字串 - 撈出符合SQL字串語句的全部資料
 *           3. 二個參數：
 *              a. 第一個參數必須為陣列，同2-a描述
 *              b. 第二個參數必須為字串，同2-b描述
 */

function all($table,...$arg){// 自定函式all(條件1,複數條件...)
    $pdo=pdo();
    $sql="SELECT * FROM $table "; // $sql=查詢全部 條件為條件1
    
    //依參數數量來決定進行的動作因此使用switch...case
    switch(count($arg)){
        case 1:
    
            //判斷參數是否為陣列
            if(is_array($arg[0]) && !empty($arg[0])){//如果條件2是陣列 而且不為空值+++++++++++++++++++++++++++
    
                //使用迴圈來建立條件語句的字串型式，並暫存在陣列中
                foreach($arg[0] as $key => $value){
    
                    $tmp[]="`$key`='$value'";
    
                }
    
                //使用implode()來轉換陣列為字串並和原本的$sql字串再結合
                $sql.=" WHERE ". implode(" AND " ,$tmp);
            }elseif(empty($arg[0])){//如果條件2是空值 無反應++++++++++++++++++++++++++++++++++++++++++++++++++
                
            }else{
                //如果參數不是陣列，那應該是SQL語句字串，因此直接接在原本的$sql字串之後即可
                $sql.=$arg[0];
            }
        break;
        case 2:
            if(!empty($arg[0])){//如果條件2不是空值 執行下述陣列 並執行WHERE++++++++++++++++++++++++++++++++++++++++++++++++++

                    //第一個參數必須為陣列，使用迴圈來建立條件語句的陣列
                foreach($arg[0] as $key => $value){
                
                    $tmp[]="`$key`='$value'";
                
                }
                //將條件語句的陣列使用implode()來轉成字串，最後再接上第二個參數(必須為字串)
                $sql.=" WHERE ". implode(" AND " ,$tmp) . $arg[1];

            }else{//如果條件2是空值 不執行WHERE 並陣列++++++++++++++++++++++++++++++++++++++++++++++++++
                $sql.=$arg[1];
            }
        break;
    
        //執行連線資料庫查詢並回傳sql語句執行的結果
        }
    
        //fetchAll()加上常數參數FETCH_ASSOC是為了讓取回的資料陣列中
        //只有欄位名稱,而沒有數字的索引值

        // echo $sql; // 觀看sql語法結果
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    
    }
// ---------------------------math()-使用指定的聚合函數進行資料表的計算或取值---------------------------------------------
/**
 * $table - 資料表名稱 字串型式
 * $math - 聚合函式名稱，必須有，支援以下聚合函式：
 *         count、max、min、avg、sum
 * $col - 要進行計算的欄位 字串型式
 * ...$arg - 參數型態
 *           1. 沒有參數，針對資料表全部資料進行計算
 *           2. 陣列 - 計算符合陣列key = value 條件的全部資料
 */

function math($table,$math,$col,...$arg){
    $pdo=pdo();
    
    $sql="SELECT $math(`$col`) FROM $table ";
    
        if(!empty($arg[0])){
    
            foreach($arg[0] as $key => $value){
    
                $tmp[]="`$key`='$value'";
    
            }
    
            $sql.=" WHERE " . implode(" AND " ,$tmp);
    
        }
    
        //使用fetchColumn()來取回第一欄位的資料，因為這個SQL語法
        //只有select 一個欄位的資料，因此這個函式會直接回傳計算的結果出來
        return $pdo->query($sql)->fetchColumn();
    }
// ---------------------------to()-頁面導向，取代header(‘location:url’)---------------------------------------------
/**
 * $url - 要導向的檔案路徑及檔名
 */

function  to($url){

    header("location:".$url);

}
// ---------------------------q()-可以用來撰寫較為複雜的SQL語句，並回傳查詢結果的全部資料---------------------------
/**
 * $sql - SQL語句字串，取出符合SQL語句的全部資料
 */

function  q($sql){
    $pdo=pdo();
    
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

}
// ---------------------------save()-整合insert()和update()的功能為一支函式------------------------------------------
/**
 * $table - 資料表名稱 字串型式
 * $arg - 陣列型式
 *        1. 如果陣列中有key值為id，則執行更新(update)的功能
 *        2. 如果陣列中沒有key值為id，則執行新增(insert)的功能
 */

 
function  save($table,$arg){//在api->add_vote.php裡對應到save('subjects',$add_subject);
    $pdo=pdo();
    $sql='';
    if(isset($arg['id'])){// 有無id值 , 若有id則需要更新 ,因資料表的資料才會有id可以藉此判斷有無id
                          // 若無id值 , 代表該筆資料在資料庫中不存在, 所以要新增 而不是更新
        //update
        foreach($arg as $key => $value){
            if($key!='id'){
                $tmp[]="`$key`='$value'";
            }
        }
        //建立更新的sql語法
        $sql.="UPDATE $table SET ".implode(" , " ,$tmp)." WHERE `id`='{$arg['id']}'";

    }else{// 若無 進入查詢
        //insert
        $cols=implode("`,`",array_keys($arg));
        $values=implode("','",$arg);

        //建立新增的sql語法
        $sql="INSERT INTO $table (`$cols`) VALUES('$values')";

    }
    
    return $pdo->exec($sql);

}
// ---------------------------find()-會回傳資料表指定條件的單筆資料-------------------------------------------------
/**
 * $table - 資料表名稱 字串型式
 * $arg 參數型態
 *      1. 陣列 - 撈出符合陣列key = value 條件的單筆資料
 *      2. 字串 - 必須是資料表的id，數字型態，且資料表有id這個欄位
 */

function find($table,$arg){
    $pdo=pdo();
    
    $sql="SELECT * FROM $table WHERE ";
        if(is_array($arg)){//是否陣列 , 若是 使用下列 以條件的方式來撈資料
    
            foreach($arg as $key => $value){
    
                $tmp[]="`$key`='$value'";
    
            }
    
            $sql.=implode(" AND " ,$tmp);
    
        }else{// 若否 ,預設其為一個ID, 執行上述171行$sql="SELECT * FROM $table WHERE" 到下列
              // 171行撈出資料的$sql   相連   "字串:資料庫的id=find(條件2放入的id)"  賦值給 新$sql
            $sql.=" `id`='$arg'";
    
        }
    
        return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
// ---------------------------del()-給定條件後，會去刪除指定的資料-------------------------------------------------
/**
 * $table - 資料表名稱 字串型式
 * $arg 參數型態
 *      1. 陣列 - 刪除符合陣列key = value 條件的所有資料
 *      2. 字串 - 必須是資料表的id，數字型態，且資料表有id這個欄位
 */

function del($table,$arg){
    $pdo=pdo();
    
    $sql="DELETE FROM $table WHERE ";
        if(is_array($arg)){
    
            foreach($arg as $key => $value){
    
                $tmp[]="`$key`='$value'";
    
            }
    
            $sql.=implode(" AND " ,$tmp);
    
        }else{
    
            $sql.=" `id`='$arg'";
    
        }
    
        return $pdo->exec($sql);
    }

// ---------------------------dd-傾印陣列-------------------------------------------------
function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
?>