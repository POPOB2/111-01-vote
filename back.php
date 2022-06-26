<?php
include_once "./api/base.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投票管理中心</title>
    <!-- 前者本來賦予#header 300px設定 -->
    <link rel="stylesheet" href="./css/basic.css">
    <link rel="stylesheet" href="./css/back.css"><!-- 後者賦予#header 100px 後者覆蓋掉前者的設定 -->
</head>
<body>
    <!-- 後台 -->
    <div id="header">
        <?php include "./layout/header.php";
              include "./layout/back_nav.php";
        ?>    
    </div>
    <!--  -form_data : 用表單傳出去的東西是form_data,其使用了GET或POST傳送的方式
          -query string : 查詢用的字串, 帶在網址?後面的參數內容就是query string, 
           1.query=以前針對使用條件再資料庫裡撈資料的行為稱做query
           2.string=代表在網址上傳值的資料型態 用這種方式傳值到後台時99%都是字串 後端拿到後針對這個內容做字串處理 如數字字串轉為數字 或用EX拆解內容等處理字串方式 -->

    <div id="container">
    <?php
    if(isset($_GET['do'])){// 判斷網址有無GET到do參數, 若有do這段文字參數  執行以下
        $file="./back/".$_GET['do'].".php";// 變數=載入一個目錄,載入頁面和do名稱相同(來自./back資料夾 帶有GET到的do參數 且是.php檔)
                                           // 此時 $file= "./back/add_vote.php"  (依照需求可以將第27行.php改為.html 就可以使用html執行一樣的事情)
                                           // *這裡注意 : 是用include是將內容導入,而非導出 所以第32行的include $file; 是將add_vote.php的內容導入到back.php
    }
    if(isset($file) && file_exists($file)){// 新增一個判斷式使用isset確認是否有$file該變數, 且file_exists()判斷$file是否有值(存在), 若有 則載入include $file
        include $file;
    }else{//若無 則維持按下'新增投票'前的結果頁面 , 新增判斷是否存在的用意是 避免有人再do上面輸入了不存在的參數導致網頁錯誤, 結果上來說會回到沒有參數的頁面
    ?>        
            <button class="btn btn-primary" onclick="location.href='?do=add_vote'">新增投票</button><!-- 路徑位置使用?do=鏈結區域  將當下頁面的內容帶到下一個鏈結區域 -->
            <div>
                <ul>
                    <li class='list-header'>
                        <div>投票主題</div>
                        <div>單/複選題</div>
                        <div>投票期間</div>
                        <div>剩餘天數</div>
                        <div>投票人數</div>
                        <div>操作</div>
                    </li>
                <?php
                    // allFunction=base.php->24行 , 給定資料表名稱和條件後，會回傳符合條件的所有資料
                    $subjects=all('subjects');// 不管條件如何  將subjects資料表的資料全部撈出  賦值給$subjects
                    foreach($subjects as $subject){// 使用foreach 將有資料內容的$subjects的資料 用陣列的方式 塞給$subject
                        echo "<li class='list-items'>";

                        // 投票主題------------------------------------------------------------------------------------------------------------------
                        echo "<div>{$subject['subject']}</div>";// 將有資料內容的$subject用陣列的方式  echo出資料表內欄位 名為subject的資料內容

                        // 單/複選題-----------------------------------------------------------------------------------------------------------------
                        if($subject['multiple']==0){// 將現有值用於判斷是否==0,以顯示單/複選題
                            echo "<div class='text-center'>單選題</div>";
                        }else{
                            echo "<div class='text-center'>複選題</div>";
                        }

                        // 投票期間-----------------------------------------------------------------------------------------------------------------
                        echo "<div class='text-center'>";
                        echo $subject['start']."~".$subject['end'];
                        echo "</div>";

                        // 剩餘天數-----------------------------------------------------------------------------------------------------------------
                        echo "<div class='text-center'>";
                            $today=strtotime("now");
                            $end=strtotime($subject['end']);
                            if(($end-$today)>0){// 判斷 結束日-現在日的結果 大於0 表示結束的時間未到, 執行顯示倒數計算
                                $remain=floor(($end-$today)/(60*60*24));
                                echo "該投票還有".$remain."天結束";
                            }else{
                                echo "<span style='color:grey'>該投票已結束</span>";
                            }
                        echo "</div>";

                        // 投票人數-----------------------------------------------------------------------------------------------------------------
                        echo "<div class='text-center'>{$subject['total']}</div>";

                        // 操作---------------------------------------------------------------------------------------------------------------------
                        echo "<div class='text-center'>";
                        echo "<a class='edit' href='?do=edit&id={$subject['id']}'>編輯</a>"; // 新增按鈕  同29行使用 判斷do=哪裡 且 id為資料庫的id值
                        echo "<a class='del' href='?do=del&id={$subject['id']}'>刪除</a>";
                        echo "</div>";

                        echo "</li>";
                    }
                ?>
                </ul>
            </div>
    <?php
    }
    ?>     
    </div>


    <div>
        <?php include "./layout/footer.php";?>
    </div>
</body>
</html>