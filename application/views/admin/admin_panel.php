<?php
$this->load->view('templates/header');
?>

<div class="span10">
    <h1>{title}</h1>
    <div class="accordion" id="accordion2">
        <div class="accordion-group">
            <div class="accordion-heading" style="background-color: #D54413;">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="color:#fff;">
                    Администрирование пользователей
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
            <div class="accordion-heading" style="background-color: #D54413;">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" style="color:#fff;">
                    Администрирование пользователей
                </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul class="unstyled">
                        <li><i class="icon-list"></i>&nbsp;&nbsp;<a href="/admin/users">Список пользователей</a></li>
                        <li><i class="icon-list-alt"></i>&nbsp;&nbsp;<a href="/admin_panel/list_groups">Список групп</a></li>
                        <li><i class="icon-plus"></i>&nbsp;&nbsp;<a href="/admin_panel/create_user">Создание пользователя</a></li>
                        <li><i class="icon-plus-sign"></i>&nbsp;&nbsp;<a href="/admin_panel/create_group">Создание группы</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('templates/footer');
?>