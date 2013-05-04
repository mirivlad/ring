<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <fieldset><legend>{title}</legend>
    <div class="accordion" id="accordion2">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle text-success" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                    <span class="text-success icon-user"> <strong>Администрирование Пользователей</strong></span>
                </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul class="unstyled">
                        <li><i class="icon-list"></i>&nbsp;&nbsp;<a href="/admin/users">Список пользователей</a></li>
                        <li><i class="icon-list-alt"></i>&nbsp;&nbsp;<a href="/admin/unactivated_users">Не активированные пользователи</a></li>
                        <li><i class="icon-star"></i>&nbsp;&nbsp;<a href="/admin/roles">Роли</a></li>
                        <li><i class="icon-certificate"></i>&nbsp;&nbsp;<a href="/admin/uri_permissions">Права доступа к URI</a></li>
                        <li><i class="icon-tags"></i>&nbsp;&nbsp;<a href="/admin/custom_permissions">Настройка прав доступа</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                    <span class="text-success icon-suitcase"> <strong>Администрирование Системы</strong></span>
                </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul class="unstyled">
                        <?php
                        if($current_db < $actual_db){
                            $db = "<li><i class=\"icon-arrow-up\" style=\"color: #f33;\"></i>&nbsp;&nbsp;<a href=\"/admin/update_db\">Выполнить обновление до версии ".$actual_db."</a></li>";
                        }else{
                            $db = "<li><i class=\"icon-ok\" style=\"color: #3f3;\"></i>&nbsp;&nbsp;База данных в актуальном состоянии</a></li>"; 
                        }
                        ?>
                        <?=$db?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse3">
                    <span class="text-success icon-info-sign"> <strong>Информация о системе</strong></span>
                </a>
            </div>
            <div id="collapse3" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul class="unstyled">
                        <?php
                            phpinfo();
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </fieldset>
</div>
<?php
$this->load->view('templates/footer');
?>