	</div>
    </div>
</div>
<!--</div>  Закрытие блока контента -->
<script src="/assets/js/jquery-1.9.1.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/up_button.js"></script>
<script src="/assets/js/current_url.js"></script>
<p class="muted" style="padding: 1em; padding-left: 3em;">Render time <strong>{elapsed_time}</strong> sec.</p>
<?php
if(isset($footer_add) AND is_array($footer_add)){
    foreach ($footer_add as $value) {
        echo $value;
    }
}
?>
        </div>
        </body>
</html>