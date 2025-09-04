<script>
  let myToken = '<?= $this->request->getAttribute('csrfToken') ?>';
  let myUrl = '<?= $this->request->getParam('controller') ?>';
</script>
<?php
    $AppDescription = 'Minalinks';
    $AppTitle = 'La solution idéale pour raccoucir vos URLs';
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
    <link rel="icon" type="image/x-icon" href="<?= $this->Url->image('favicon.ico') ?>">
    <?= $this->fetch('meta') ?>
    <?php echo $this->html->css([
        'bootstrap',
          '../plugins/fontawesome-free/css/all.min',
        '../plugins/datatables-bs4/css/dataTables.bootstrap4.min',
        '../plugins/datatables-responsive/css/responsive.bootstrap4.min',
        '../plugins/datatables-buttons/css/buttons.bootstrap4.min',
        '../dist/css/adminlte.min', 
        '../plugins/toastr/toastr.min',
        '../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min'
    ]) ?>
    <?php echo $this->fetch('css'); ?>
    <?= $this->Html->script([
    '../plugins/jquery/jquery.min.js', // jQuery d'abord
    '../plugins/bootstrap/js/bootstrap.bundle.min.js', // ensuite Bootstrap
    '../plugins/toastr/toastr.min',
    '../plugins/jquery-ui/jquery-ui.min',
    '../plugins/sweetalert2/sweetalert2.min.js',
    '../dist/js/adminlte.min.js',
    'sms',
    'sms_counter'
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
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- script pour les messages d'alertes -->


<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
  })
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  /**
     * Affiche une boite de dialogue pour confirmer et exécuter une action
     */
  function fetchAction(dest_url, data = {}, return_url = 'reload') {
  const headers = {
    "Content-Type": "application/json",
    "X-CSRF-Token": "<?= $this->request->getAttribute('csrfToken') ?>"
  };

  fetch(dest_url, {
    method: "POST",
    headers: headers,
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(result => {
    if (result.status === 1 && result.error === 0) {
      Swal.fire({
        icon: 'success',
        text: result.message
      }).then(() => {
        if (return_url === 'reload') {
          document.location.reload();
        } else if (return_url && return_url !== 'none') {
          document.location.assign(return_url);
        }
      });
    } else {
      Swal.fire({
        title: "Erreur",
        icon: 'error',
        text: result.message
      });

      if (result.error === 1) {
        document.location.assign("<?= $this->Url->build('/connect') ?>");
      }
      if (result.error === 2) {
        document.location.assign("<?= $this->Url->build('/logout') ?>");
      }
    }
  })
  .catch(error => {
    Swal.fire({
      icon: 'error',
      title: "Oops !",
      text: "Une erreur est survenue. Veuillez réessayer plus tard."
    });
  });
}

</script>