<? include("inc/header.php"); ?>

<? include("inc/navi.php"); ?>

<? include("inc/sidebar.php"); ?>
<style type="text/css" media="screen">
    th.dt-center, td.dt-center { text-align: center; }
</style>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
            <? include ("inc/page-header.php"); ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                請選擇查詢年度
                            </div>
                            <div class="panel-body">
                                <select id=sel_years class="form-control" onChange=sel_years_onchange()>
                                <?
                                    $today  = getdate();
                                    $year   = $today["year"] - 1911;
                                    for ($j=95;$j<=$year+1;$j++)
                                        echo "<option value=".$j.">".$j."</option>";   
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                        <div class="panel-heading">個人差假狀況(上)</div>
                            <div class="panel-body">
                                
                                <div id="hl_canceled">
                                    <H3>已取消假單</H3>
                                    <table id="Btable_canceled" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr style="font-weight:bold">
                                                <th>姓名</th>
                                                <th>假別</th>
                                                <th>起始日</th>
                                                <th>終止日</th>
                                                <th>起始時間</th>
                                                <th>終止時間</th>
                                                <th>總時數</th>
                                                <th>職務代理人</th>
                                                <th>取消日期</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <hr>
                                </div>
                                
                                <div id="hl_dealing">
                                    <H3>處理中假單</H3>
                                    <table id="Btable_dealing" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr style="font-weight:bold">
                                                <th>姓名</th>
                                                <th>假別</th>
                                                <th>起始日</th>
                                                <th>終止日</th>
                                                <th>起始</th>
                                                <th>終止</th>
                                                <th>總時數</th>
                                                <th>代理簽核</th>
                                                <th>直屬簽核</th>
                                                <th>單位簽核</th>
                                                <th>備註</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                                
                                <div id="hl_rejected">
                                    <H3>未通過假單</H3>
                                    <table id="Btable_rejected" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr style="font-weight:bold">
                                                <th>姓名</th>
                                                <th>假別</th>
                                                <th>起始日</th>
                                                <th>終止日</th>
                                                <th>起始</th>
                                                <th>終止</th>
                                                <th>單位原因</th>
                                                <th>人事原因</th>
                                                <th>秘書室原因</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <hr>
                                </div>

                                
                                
                                <div id="hl_passing">
                                    <H3>已核准假單</H3>
                                    <table id="Btable_passing" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr style="font-weight:bold">
                                                <th>姓名</th>
                                                <th>假別</th>
                                                <th>起始日</th>
                                                <th>終止日</th>
                                                <th>起始</th>
                                                <th>終止</th>
                                                <th>總時數</th>
                                                <th>代理簽核</th>
                                                <th>直屬簽核</th>
                                                <th>單位簽核</th>
                                                <th>備註</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

<? include("inc/footer.php"); ?>
