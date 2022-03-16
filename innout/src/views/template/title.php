<!-- Este arquivo tem como função carregar os ícones,
títulos e subtitulos atravpes de uma função interativa -->
<div class="content-title mb-4">
  <?php if($icon) { ?>
    <i class="icon icof<?= $icon ?> mr-2"></i>
  <?php } ?>
  <div>
    <h1><?= $title?></h1>
    <h2><?= $subtitle?></h2>
  </div>
</div>
