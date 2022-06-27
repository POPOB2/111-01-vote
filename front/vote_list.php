<div>   
                        <!--  使用網址帶值的方式控制 投票主題各個參數的排序 
                           1. 網址狀態為不帶值時 執行$subjects=all('subjects',$orderStr) 僅以subjects表做為條件 顯示資料表順序
                           2. 網址狀態為帶值時 執行 偵測是否需要進行排序 為 是, 將$orderStr用GET賦值
                              使$subjects=all('subjects',$orderStr)的條件2生效 以條件2的SQL語法決定遞增或遞減的排序 顯示total值排序
                           3. 網址狀態為帶值時 如上述執行遞增或遞減 兩者的變換遞增或遞減的判斷式為每一個選項去設isset&&type==asc -->
                <ul class='list'>
                    <li class='list-header'>
                        <div>投票主題</div>

                        <?php
                        // 判斷有無GET type存在 若是 且 GET type的type為asc(遞增)時, 就執行下列 將type改為desc(遞減)
                        if(isset($_GET['type']) && $_GET['type']=='asc'){
                        ?>
                        <div><a href="?order=multiple&type=desc">單/複選題</a></div> 
                        <?php
                        }else{    
                        ?>
                        <div><a href="?order=multiple&type=asc">單/複選題</a></div> 
                        <?php
                        }
                        ?>



                        <?php
                        if(isset($_GET['type']) && $_GET['type']=='asc'){
                        ?>
                        <div><a href="?order=end&type=desc">投票期間</a></div>
                        <?php
                        }else{
                        ?>
                        <div><a href="?order=end&type=asc">投票期間</a></div>
                        <?php
                        }
                        ?>


                        <?php
                        if(isset($_GET['type']) && $_GET['type']=='asc'){
                        ?>
                        <div><a href="?order=remain&type=desc">剩餘天數</a></div>
                        <?php
                        }else{

                        ?>
                        <div><a href="?order=remain&type=asc">剩餘天數</a></div>
                        <?php
                        }
                        ?>

                        <?php
                        if(isset($_GET['type']) && $_GET['type']=='asc'){
                        ?>
                        <div><a href='?order=total&type=desc'>投票人數</a></div><!-- 按下投票人數時 返回至當前頁 並以total值排列, 類型為desc(遞減) -->
                        <?php
                        }else{
                        ?>
                        <div><a href='?order=total&type=asc'>投票人數</a></div><!-- 按下投票人數時 返回至當前頁 並以total值排列, 類型為asc(遞增) -->
                        <?php
                        }
                        ?>
                        


                    </li>
    
                <?php
                    // 偵測是否需要進行排序----------------------------------------------------------------------------------------------------------
                    $orderStr=''; // 設一個空值 若未按扭=無GET值 , 若有GET值 執行以下if 將結果賦予$orderStr 使$orderStr產生出有值的排列方式
                    if(isset($_GET['order'])){ // 判斷該值是否存在 若存在 表示已點擊過 所以有該SESSION記錄存在
                            $_SESSION['order']['col']=$_GET['order'];// SESSION一個陣列 order的col為GET order
                            $_SESSION['order']['type']=$_GET['type'];// SESSION一個陣列 order的type為GET type
                                    // 上述SESSION照常運作
                                    if($_GET['order']=='remain'){// 但若按扭按的order GET過來的值為remain時
                                        $orderStr=" ORDER BY DATEDIFF(`end`,now()) {$_SESSION['order']['type']}";
                                        //$orderStr賦值改為 按照日期結束日減現在時間的值 排序
                                        //SQL語法的 : ORDER BY DATEDIFF(`end`,now()) `remain` desc
                                    }else{
                                        $orderStr=" ORDER BY `{$_SESSION['order']['col']}` {$_SESSION['order']['type']}";
                                        // $orderStr經過上述SESSION的賦值產生 = SQL語法的 : ORDER BY `multiple` asc 值
                                    }
                        }
                        /* 建立分頁所需的變數群 
                         * 
                         * 
                         * 
                         *
                         * */ 
                        //math(參數1.subjects表, 參數2.方法使用count, 參數3.使用參數2去執行的目標 count id欄位)     
                        $total=math('subjects','count','id'); // 資料總筆數_
                        $div=3; // 每個分頁有3筆資料_
                        $pages=ceil($total/$div); // 擁有幾個分頁_使用進位避免餘數不被計算 值為(總筆數 除 每頁要設置的筆數)
                        $now=isset($_GET['p'])?$_GET['p']:1; // 當前頁_為GET值, 若無GET值顯示1
                        $start=($now-1)*$div; // 開始頁_(GET進來的值-1)*每分頁資料筆數
                        $page_rows=" limit $start,$div"; // 每頁顯示的資料_限制筆數 為開始頁的 每個分頁筆數
                        // 放在最後執行 是為了 排序完再作分頁, 如果放在前面會變成先作分頁 再排序,  會產生完全不同的結果

            /*  使用index計算每頁資料  而非使用id計算每頁資料   因為id可能會被刪除   導至順序數破碎   無法計算開始值與結束值
                而index不受影響   無論id如何變化   index都是由陣列索引填數
                index       id    頻率為
                0           1     (1-1)*3+1=1
                1           2
                2           3
                ----第一頁----
                3           4     (2-1)*3+1=4
                4           5
                5           6
                ----第二頁----
                6           7     (3-1)*3+1=7
                ----第三頁----                   
            */ 

                    // allFunction=base.php->24行 , 給定資料表名稱和條件後，會回傳符合條件的所有資料
                    $subjects=all('subjects',$orderStr . $page_rows);// 若$orderStr無值  將subjects資料表的資料全部撈出  賦值給$subjects(SELECT * FROM subjects)
                                                        // 若$orderStr有值  將GET進來的內容 做為subjects表搜尋條件 賦值給$subjects(SELECT * FROM subjects ORDER BY `multiple` asc)
                                                        // 新增 . $page_rows 作為字串內容 影響SQL語句, 使用限制筆數產生分頁要顯示的資料 效果

                    foreach($subjects as $subject){// 使用foreach 將有資料內容的$subjects的資料 用陣列的方式 塞給$subject
                        echo "<a href='?do=vote_result&id={$subject['id']}'>";// 點擊投票內容 導到頁面 do=vote 而 id=$subject的id
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
                        echo "</li>";
                        echo "</a>";
                    }
                ?>
                </ul>
                <!-- 分頁的頁碼 -->
                <div class="text-center">
                    <?php
                    for($i=1; $i<=$pages; $i++){ // $i為分頁碼  分頁碼不會大於分頁數  依照每三筆資料+1個分頁碼
                        // echo "<a href='?p=$i'>&nbsp;"; // 使用?帶值 p=$i(頁碼==對應排序的資料)
                        echo "<a href='?p={$i}&{$orderStr}'>&nbsp;";
                        echo $i;
                        echo "&nbsp;</a>";
                    }
                
                    ?>
                </div>
            </div>  