<?php headerAdmin($data);?>
  <div class="content-wrapper">
    <section class="content">
      <div class="card">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Area Chart</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="Chart" width="400" height="400"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<?php footerAdmin($data);?>


