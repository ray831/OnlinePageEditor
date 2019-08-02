<? include("inc/header.php"); ?>



<!-- Page Content -->
<div class="container-fluid">
    <div>
        <? include ("inc/page-header.php"); ?>
    </div>
    <div class="spinner">
        <p>載入中...</p>
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
    <div class="panel panel-blue editor-invisible" id='editor_selector'>
        <div class="panel-heading">
            <h3 class="panel-title" style="color:#ffffff"><i class="fa fa-tasks"></i> 歡迎</h3> </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="get">
                <div class="form-group">
                    <label class="col-lg-2 control-label"><i class="fa fa-pencil" aria-hidden="true"></i> 編輯中頁面</label>
                    <div class="col-lg-3">
                        <select name="pgn"></select>
                        <br>
                        <button type="submit" class="btn btn-primary">確認</button>
                    </div>
                </div>
            </form>
            <br>
            <hr/>
            <div class="col-lg-offset-1">
                <strong>需要新建編輯頁嗎？請使用</strong><br><br>
                <button type="button" class="btn btn-info" onclick="RedirectToWizard()"><i class="fa fa-magic" aria-hidden="true"></i> 編輯器導覽</button>
            </div>
        </div>
    </div>
    <div class="editor-invisible" id='editor_main'>
        <div class="row" id="live_preview_panel" style="display:none">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">即時預覽</h3> </div>
                    <div class="panel-body">
                        <div id="editor_live_preview"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">編輯頁面</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2" id="editor_menu">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="active"><a href="#page-editor" data-toggle="tab" aria-expanded="true"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i><span>&nbsp; 編輯</span></a></li>
                                    <li class=""><a href="#settings" data-toggle="tab"><i class="fa fa-gear fa-fw" aria-hidden="true"></i><span>&nbsp; 設定</span></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-10" id="editor_body">
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="page-editor">
                                        <div class="row">
                                            <nav class="navbar navbar-default">
                                                <div class="container-fluid">
                                                    <div class="navbar-header"><a class="navbar-brand"><i aria-hidden="true" class="fa fa-html5" style="font-size:150%; color:#ff3300"></i> </a></div>
                                                    <div class="collapse navbar-collapse">
                                                        <ul class="nav navbar-nav">
                                                            <li class="active"><a data-toggle="tab" href="#html_editarea">HTML </a></li>
                                                            <li><a data-toggle="tab" href="#js_editarea">JavaScript</a></li>
                                                            <li><a data-toggle="tab" href="#ss_editarea">Server-Side Script</a></li>
                                                        </ul>
                                                        <ul class="nav navbar-nav navbar-right">
                                                            <li><a><div id="autosaveClock"></div></a></li>
                                                            <li><a onclick="EditorOptionAction(1)"><i class="fa fa-window-maximize fa-fw" aria-hidden="true"></i>&nbsp;預覽</a></li>
                                                            <li><a onclick="EditorOptionAction(2)"><i class="fa fa-window-restore fa-fw" aria-hidden="true"></i>&nbsp;完整預覽</a></li>
                                                            <li class="dropdown"><a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"><i aria-hidden="true" class="fa fa-cog fa-fw"></i>&nbsp;選項 <span class="caret"></span></a>
                                                                <ul class="dropdown-menu">
                                                                    <li><a onclick="EditorOptionAction(3)"><i aria-hidden="true" class="fa fa-columns fa-fw"></i>&nbsp;顯示即時預覽面板</a></li>
                                                                    <li><a onclick="EditorOptionAction(4)"><i class="fa fa-window-minimize fa-fw" aria-hidden="true"></i>&nbsp;隱藏即時預覽面板</a></li>
                                                                    <li class="divider" role="separator">&nbsp;</li>
                                                                    <li><a onclick="EditorOptionAction(5)"><i aria-hidden="true" class="fa fa-file-code-o fa-fw"></i>&nbsp;讀取檔案</a></li>
                                                                    <li class="divider" role="separator">&nbsp;</li>
                                                                    <li><a onclick="EditorOptionAction(7)"><i aria-hidden="true" class="fa fa-arrows-h"></i>&nbsp;隱藏菜單文字</a></li>
                                                                    <li><a onclick="EditorOptionAction(6)"><i aria-hidden="true" class="fa fa-wrench fa-fw"></i>&nbsp;重建HTML編輯器</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /.navbar-collapse -->
                                                </div>
                                                <!-- /.container-fluid -->
                                            </nav>
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active" id="html_editarea">
                                                    <div class="panel panel-default editor-panel">
                                                        <div class="panel-body">
                                                            <textarea id="ck_htm_ediotr" name="ck_htm_ediotr"></textarea>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="editor_button_group" id="btn_ck_html" name="htm">
                                                                <div class="form-inline">
                                                                    <select class="form-control">
                                                                        <option value="public">頁面資料夾</option>
                                                                        <option value="auto">自動保存資料夾</option>
                                                                    </select>
                                                                    <button onclick="QuickSave($(this))" title="將目前編輯器內容寫入指定資料夾與緩衝區" type="button" class="btn btn-primary">快速保存</button>
                                                                    <select class="form-control" name="srcbuffer" style="margin-left:2%">
                                                                        <option value="public">頁面資料夾</option>
                                                                        <option value="auto">自動保存資料夾</option>
                                                                    </select>
                                                                    <button onclick="QuickLoad($(this))" title="將指定緩衝區內容寫入編輯器" type="button" class="btn btn-success">快速讀取</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="js_editarea">
                                                    <div class="panel panel-default editor-panel">
                                                        <div class="panel-heading editor-toolbar">
                                                            <i class="fa fa-users coll-edit-ico" onclick="AceEditorToolbarFn(0,0)"></i>
                                                            <i class="fa fa-keyboard-o key-shortcut-ico" onclick="AceEditorToolbarFn(1,0)"></i>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div id="ace_js_edit_area" class="AceEditArea"></div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="editor_button_group" id="btn_ace_js" name="js"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="ss_editarea">
                                                    <div class="panel panel-default editor-panel">
                                                        <div class="panel-heading editor-toolbar">
                                                            <i class="fa fa-users coll-edit-ico" onclick="AceEditorToolbarFn(0,1)"></i>
                                                            <i class="fa fa-keyboard-o key-shortcut-ico" onclick="AceEditorToolbarFn(1,1)"></i>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div id="ace_ss_edit_area" class="AceEditArea"></div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="editor_button_group" id="btn_ace_ss" name="ss"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- page-edit -->
                                    <div class="tab-pane fade" id="settings">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="editor_fnsize" class="col-lg-2 control-label">字體大小</label>
                                                <div class="col-lg-5">
                                                    <input value="16" type="number" class="form-control" id="editor_fnsize" placeholder="大小" min="12" max="64">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="editor_style" class="col-lg-2 control-label">風格</label>
                                                <div class="col-lg-5">
                                                    <select id="editor_style" name="editor_style" value="monokai">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="coedit" class="col-lg-2 control-label">協作編輯</label>
                                                <div class="col-lg-5">
                                                    <input id="coeditToggle" checked data-toggle="toggle" data-on="啟用" data-off="禁用" type="checkbox">
                                                    <p class="help-block">是否允許其他人同時間編輯代碼</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="autoQsaveToggle" class="col-lg-2 control-label">自動快速保存</label>
                                                <div class="col-lg-5">
                                                    <input id="autoQsaveToggle" checked data-toggle="toggle" data-on="開啟" data-off="關閉" type="checkbox">
                                                    <p class="help-block">當按下"完整預覽"時，是否將自動保存自頁面資料夾</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="autosaveToggle" class="col-lg-2 control-label">自動保存</label>
                                                <div class="col-lg-5">
                                                    <input id="autosaveToggle" checked data-toggle="toggle" data-on="開啟" data-off="關閉" type="checkbox">
                                                    <p class="help-block">是否在間隔一段時間將所有內容保存自暫存資料夾</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="autosaveInterval" class="col-lg-2 control-label">自動保存間隔</label>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <input value="1800" type="number" class="form-control" id="autosaveInterval" min="30">
                                                        <div class="input-group-addon">秒</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-5">
                                                    <button onclick="savePageSetting()" type="button" class="btn btn-success">儲存</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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