<script>
  let myToken = '<?= $this->request->getAttribute('csrfToken') ?>';
  let myUrl = '<?= $this->request->getParam('controller') ?>';
</script>
<?php
    $AppDescription = ' Travaillez partout dans le monde. ';
    $AppTitle = 'Avec kussala';
    $plugin = $this->getRequest()->getParam('plugin') ?? null;
    $controller = $this->getRequest()->getParam('controller');
    $action = $this->getRequest()->getParam('action');
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
    <?= $AppDescription .' : '. $AppTitle ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?php echo $this->html->css([
        'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap',
        'home'
    ]) ?>
    <?php echo $this->fetch('css'); ?>
    <?= $this->Html->script([
        'sms', 
        'script',
    ]) ?>
    <?php echo $this->fetch('script'); ?>
</head>
<body >
    <main class="main">
      <div class="container-fluid">
        <div class="row">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div> 
      </div>
    </main>
</body>
</html>
