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
    function confirmAction(title, confirm_message, icon, dest_url, data, return_url='')
    {
      
      headers = {
        "Content-Type": "application/json",
        "Access-Control-Origin" : "*",
        "X-CSRF-Token" : "<?= $this->request->getAttribute('csrfToken') ?>"
      };
      let redirectUrl = '';
      Swal.fire({
        title: title,
        html: confirm_message,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: "<i class='fa fa-thumbs-up'></i> <?= __('Oui, je confirme') ?>",
        cancelButtonText: "<?= __('Annuler') ?>",
        showLoaderOnConfirm: true,
        preConfirm: ()=>{

          return fetch(dest_url,{ method:"POST", headers:headers, body: JSON.stringify(data)})
            .then(response =>{
              if(!response.ok){
                throw new Error(response.statusText)
              }
              return response.json()
            })
            .catch(error=>{
              Swal.showValidationMessage("<?= __('Une erreur est survenue, veuillez réessayer plus tard') ?>")
            })
          },
          backdrop: true,
          allowOutsideClick: ()=> !Swal.isLoading()
        })
        .then((result)=>{
          
          if (result.value.status==1) {

            if (result.value.error != 0) {
              Swal.fire({
                title: "<?= __('Oups') ?>",
                icon: 'error',
                text: result.value.message
              });
              return false;
            } else {
              Swal.fire({
                icon: 'success',
                text: result.value.message
              });
              // redirectUrl = result.value.redirect;

              if (typeof redirectUrl === 'undefined') {
                redirectUrl = return_url;
              }
              
              if (redirectUrl=='reload') {
                document.location.reload();  
              } else if (redirectUrl=='none' || redirectUrl=='') {
                return true;          
              } else {
                document.location.assign(redirectUrl);
              }
            }
          } else {
            Swal.fire({
              title: "<?= __('Oups') ?>",
              icon: 'error',
              text: result.value.message
            });

            if(result.value.error==1){
              document.location.assign("<?= $this->Url->build('/connect') ?>");
            }

            if(result.value.error==2){
              document.location.assign("<?= $this->Url->build('/logout') ?>");
            }
            return false;
          }
          
        });
    }
</script>