<?php $this->load->view('layout/head_default') ?>
<body>

<?=$content?>

<?php if(!isset($jsgroup)) $jsgroup = "default"?>

<script type="text/javascript" data-main="<?=site_url("mini/js/{$jsgroup}/".mtime('js',$jsgroup))?>" src="<?=site_url("mini/js/requirejs/".mtime('js','requirejs').'.js')?>"></script>



</body>
</html>
