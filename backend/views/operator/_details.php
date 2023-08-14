<div class="card pd-25">
    <div class="row">
        <div class="col-lg-4 col-4 col-sm-4 col-xs-12">
            <?php if (!empty($model->logo)) { ?>
            <img src="data:image/jpeg;base64,<?= $model->logo ?>" alt="Company Logo" class="wd-170 rounded-circle"/>
            <?php } ?>
        </div>
        <div class="col-lg-8 col-8 col-sm-8 col-xs-12">
            <div class="form-group">
                <label class="form-control-label">Company Name</label>
                <div class="form-control"><?= $model->name ?></div>
            </div>
            <div class="form-group">
                <label class="form-control-label">code</label>
                <span class="form-control"><?= $model->code ?></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-6 col-sm-6 col-sm-6 col-sm-12">
            <div class="card">
                <div class="card-header">Contact Details</div>
                <div class="card-body form-layout">
                    <div class="form-group">
                        <label class="form-control-label">Contact Person</label>
                        <div class="form-control"><?= $model->contact_person ?></div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Parent Franchise</label>
                        <span class="form-control"><?= !empty($model->distributor) ? $model->distributor->name : "N/A" ?></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Mobile No.</label>
                        <div class="form-control"><?= $model->mobile_no ?></div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Phone No.</label>
                        <span class="form-control"><?= $model->telephone_no ?></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Email</label>
                        <span class="form-control"><?= $model->email ?></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Address</label>
                        <span class="form-control"><?= $model->address ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-6 col-sm-6 col-sm-6 col-sm-12">
            <div class="card">
                <div class="card-header">Billing Details</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-control-label">GST No</label>
                        <div class="form-control"><?= $model->gst_no ?></div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">PAN</label>
                        <span class="form-control"><?= $model->pan_no ?></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Balance</label>
                        <span class="form-control"><?= $model->balance ?></span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

