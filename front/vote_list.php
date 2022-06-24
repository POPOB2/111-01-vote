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

                    // allFunction=base.php->24行 , 給定資料表名稱和條件後，會回傳符合條件的所有資料
                    $subjects=all('subjects',$orderStr);// 若$orderStr無值  將subjects資料表的資料全部撈出  賦值給$subjects(SELECT * FROM subjects)
                                                        // 若$orderStr有值  將GET進來的內容 做為subjects表搜尋條件 賦值給$subjects(SELECT * FROM subjects ORDER BY `multiple` asc)

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
            </div>  