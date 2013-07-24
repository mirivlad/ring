	<div class="span2">
            <?php 
            if($this->dx_auth->is_logged_in()){
                $banks = $this->bank_model->bank_list()->result_array();
                ?>
            <ul class="nav nav-list">
                <li class="nav-header">Банки Данных</li>
               <?php
                foreach ($banks as $item){
               ?>
                    <li><a href="/bank/index/<?=$item['id_db']?>"><?=$item['name']?></a></li>
               <?php
               }  
               ?>
            </ul>
            <?php
            }else{
            ?>
            <ul class="nav nav-list">
		<li class="nav-header"></li>
		<li><a href="/">Главная</a></li>
                <li><a href="/github">Развитие движка проекта</a></li>
		<li><a href="/about">О проекта</a></li>
	    </ul>
            <?php
            }
            ?>

	</div>
