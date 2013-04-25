<?php
$this->load->view('templates/header');
?>
{news}
<h3>{title}</h3>
<p>
    <span class="date"><?php
        echo $data$pubDate</span>
    <br>
    {description}
</p>
{/news}            
<?php
$this->load->view('templates/footer');
?>