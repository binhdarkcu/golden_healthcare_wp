<?php get_header() ?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row">
                <div class="conten col-md-8 col-sm-12 col-xs-12">
                    <h4 class="column-title" style="text-transform: uppercase"><?php echo the_title() ?></h4>
                    <h3 style="margin: 30px 0;line-height: 1.3;" class="color_main">CÔNG THỨC TÍNH CHỈ SỐ BMI = Cân nặng (kg) / ( Chiều cao(m)* Chiều cao(m))</h3>
                    <div class="box_BMI">
                        <strong class="color_main">Nhập thông số tính BMI</strong>
                        <form id="formBMI" class="ng-pristine ng-invalid ng-invalid-required ng-valid-email">
                            <div class="form-group">
                                <label for="">Cân nặng(kg)</label>
                                <input type="text" name="cannang" class="form-control chieucao" placeholder="Nhập cân nặng" />
                            </div>
                            <div class="form-group">
                                <label for="">Chiều cao(m)</label>
                                <input type="text" name="chieucao" class="form-control cannang" placeholder="Nhập Chiều cao" />
                            </div>
                            <input type="submit" class="btn btn-success" id="calc-bmi" value="Tính BMI" />
                        </form>
                        <div class="box-result">
                            <strong class="color_main">BMI = <span id="result-number"></span></strong><br/>
                            <strong class="color_main" id="result-text"></strong>
                        </div>
                    </div>
                    <div style="margin-top: 30px">
                        <?php echo the_content() ?>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12" style="position: sticky;top: 0;">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php get_footer() ?>