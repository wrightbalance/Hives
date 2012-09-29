<?php $this->load->view('layout/head_default') ?>
<body>

<?=$content?>

<?php if(!isset($jsgroup)) $jsgroup = "default"?>

<script type="text/javascript" src="<?=site_url("mini/js/{$jsgroup}/".mtime('js',$jsgroup).'.js')?>"></script>

</body>
</html>
