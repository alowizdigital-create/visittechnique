
            <section class="content-head" style="margin-top: 40px;">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 style="margin-left: 20px; margin-top: 20px;">
                                <i class="nav-icon fas fa-plus"></i> Nouveau
                            </h1>
                        </div>
                    </div>
                </div></section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= $this->Form->create($discount) ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('amount',['label'=>'Montant','class'=>'form-control select2','placeholder'=>'Ex: 50 000']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('gender_id',['label'=>'Genre de vehicule','options'=> $genders,'class'=>'form-control select2','placeholder'=>'Ex: Vehicule lourd']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <?= $this->Form->control('date', [
                                            'label' => 'Date de fin',
                                            'class' => 'form-control',
                                            'type'=> 'date',
                                            'id' => 'lastVisitDate',
                                            'placeholder' => 'Ex: 650000000'
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->control('note',['label'=>'Commentaire','class'=>'form-control select2','placeholder'=>'Ex: Vehicule lourd']); ?>
                                    </div>
                                </div>
                            </div>
                            <?= $this->Form->button(__('Sauvegarder'), ['class' => 'btn btn-primary form-control select2','style'=>'margin-top:25px']) ?>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                    </div>
                </section>
            </body>
    </div>
    <footer class="main-footer" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030; background: #f8f9fa; padding: 10px 20px; border-top: 1px solid #dee2e6;">
        <div class="float-right d-none d-sm-inline">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2025 <a href="#">X-technova</a></strong> Tous droits réservés.
    </footer>
    <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>