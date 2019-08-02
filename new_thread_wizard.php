<? include("inc/header.php"); ?>



<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <? include ("inc/page-header.php"); ?>
    </div>
    
    <i class="fa fa-spinner fa-pulse fa-4x fa-fw loader" style="display:none"></i>
    <div class="panel panel-blue wizard-begin">
        <div class="panel-heading">
            <h3 class="panel-title" style="color:#ffffff"><i class="fa fa-tasks"></i> 歡迎</h3>
        </div>
        <div class="panel-body">
            <div class="col-lg-6">
              <button id="btn_for_new" class="btn btn-info hvr-glow wizard-begin">
                  <h2><i class="fa fa-plus" aria-hidden="true"></i><strong> 新增全新頁面</strong></h2>
                  <p><strong>設定新的名稱，選擇現存的樣板，新建一個全新的頁面。</strong></p>
              </button>
            </div>
            <div class="col-lg-6">
              <button id="btn_for_edit" class="btn btn-info hvr-glow wizard-begin">
                  <h2><i class="fa fa-pencil" aria-hidden="true"></i><strong> 編輯既有頁面</strong></h2>
                  <p><strong>重新編輯已公開的頁面，利用編輯器快速修改原始內容。</strong></p>
              </button>
            </div>
        </div>
    </div>
    
    
    <div class="fuelux wizard-main" id="wizard_newpage">
        <div class="wizard" id="newPageWizard">
            <div class="steps-container">
                <ul class="steps">
                    <li class="active" data-name="page_name_setting" data-step="1"><span class="badge badge-info">1</span>頁面名稱 <span class="chevron"></span></li>
                    <li data-name="template" data-step="2"><span class="badge">2</span>選擇樣板 <span class="chevron"></span></li>
                </ul>
            </div>
            <div class="actions">
                <button class="btn btn-default btn-prev" type="button"> <span class="glyphicon glyphicon-arrow-left"></span>上一步 </button>
                <button class="btn btn-primary btn-next" data-last="完成" type="button"> 下一步<span class="glyphicon glyphicon-arrow-right"></span> </button>
            </div>
            <div class="step-content">
                <div class="step-pane sample-pane alert active" data-step="1">
                    <h4>設定頁面名稱</h4>
                    <input class="form-control" type="text" id="new_page_name" placeholder="只含英數混合與下劃線"/>
                </div>
                <div class="step-pane sample-pane bg-danger alert" data-step="2">
                    <h4>選擇預設樣板</h4>
                    <select class="list-template"></select><br>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">預覽</h3>
                        </div>
                        <div class="panel-body">
                            <div id="template_preview"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

    <div class="fuelux wizard-main" id="wizard_editpage">
        <div class="wizard" id="editPageWizard">
            <div class="steps-container">
                <ul class="steps">
                    <li data-step="1" class="active"><span class="badge">1</span>頁面選擇 <span class="chevron"></span></li>
                </ul>
            </div>
            <div class="actions">
                <button class="btn btn-default btn-prev" type="button"> <span class="glyphicon glyphicon-arrow-left"></span>上一步 </button>
                <button class="btn btn-primary btn-next" data-last="完成" type="button"> 下一步<span class="glyphicon glyphicon-arrow-right"></span> </button>
            </div>
            <div class="step-content">
                <div class="step-pane sample-pane bg-info alert" data-step="1">
                    <h4>選擇現有頁面</h4>
                    <select class="list-pubpage"></select><br>
                    <button type="button" class="btn btn-info" onclick="showIframe()">預覽</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /#page-wrapper -->

<!-- Modal -->
<div class="modal fade" id="fullscrModal" tabindex="-1" role="dialog" aria-labelledby="fullscrModalLabel" aria-hidden="true">
    <div class="modal-dialog fullscr-iframe">
        <div class="modal-content fullscr-iframe">
            <div class="modal-body fullscr-iframe">
                <iframe class="PreView-IFrame"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>

<? include("inc/footer.php"); ?>