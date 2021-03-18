<?php get_header() ?>
<?php
$queried_object = get_queried_object();
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px">
            <div class="row">
                <div class="conten col-md-12 col-sm-12 col-xs-12" style="margin-top:30px">

                    <div ng-init="initAppointment()" class="frmAppointment" style="margin-bottom: 50px;">
                    <ul class="nav nav-tabs tabMain" aria-hidden="false">
                                <li class="active"><a showtab="" data-toggle="tab" href="#appointment" aria-expanded="true"><i
                                                class="fa fa-calendar" aria-hidden="true"></i> Thông tin cuộc hẹn</a></li>
                                <li class=""><a showtab="" data-toggle="tab" href="#infoOrderer" aria-expanded="false"
                                                class="disableTab"><i
                                                class="fa fa-id-card-o" aria-hidden="true"></i> Thông tin cá nhân</a></li>
                                <!--<li class=""><a ng-show="mailActiveId!=undefined" showtab="" data-toggle="tab" href="#checkandConfirm"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Kiểm tra và xác nhận</a></li>-->
                            </ul>
                            <div class="tab-content" aria-hidden="false">
                                <div id="appointment" class="tab-pane fade active in" style="width: 100%">
                                    <div class="col-md-9 col-sm-12 col-xs-12" style="padding-left: 0px; padding-right: 0px">
                                        <form class="form-horizontal ng-pristine ng-invalid ng-invalid-required"
                                            method="POST">
                                            <div class="form-group">
                                                <label class="col-md-4 col-sm-6 col-xs-12">Chọn bác sĩ:</label>
                                                <div class="col-md-8 col-sm-6 col-xs-12">
                                                    <select class="form-control" id="selectDoctor">
                                                        <option value="0">Chọn bác sĩ của bạn</option>
                                                        <?php
                                                        $id_doctor = $_GET['id_doctor'];
                                                        $args = array(
                                                            'post_type' => 'post',
                                                            'post_status' => 'publish',
                                                            'posts_per_page' => -1
                                                        );
                                                        $query = new WP_Query($args);
                                                        while ($query->have_posts()) : $query->the_post();
                                                            ?>
                                                            <option <?php echo $id_doctor == get_the_ID() ? 'selected' : null ?> value="<?php echo get_the_ID() ?>"><?php echo the_title() ?></option>
                                                        <?php
                                                        endwhile;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="dateOrder" class="col-md-4 col-sm-6 col-xs-12"
                                                    style="padding-right:0;">Thời gian đặt hẹn: </label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <div id="dateTimePicker" class="input-group date">
                                                        <input type="text"
                                                            class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required"
                                                            placeholder="Chọn ngày" autocomplete="off"
                                                            aria-invalid="false">
                                                        <div class="input-group-addon">
                                                            <span class="fa fa-calendar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label for="timeOrder" class="col-md-1 col-sm-6 col-xs-12" style="margin-top: 10px">Giờ:</label>
                                                <div class="col-md-3 col-sm-6 col-xs-6">
                                                    <select name="timeOrder" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required">
                                                        <option label="08:15" value="08:15" selected>08:15</option>
                                                        <option label="08:30" value="08:30">08:30</option>
                                                        <option label="08:45" value="08:45">08:45</option>
                                                        <option label="09:00" value="09:00">09:00</option>
                                                        <option label="09:15" value="09:15">09:15</option>
                                                        <option label="09:30" value="09:30">09:30</option>
                                                        <option label="09:45" value="09:45">09:45</option>
                                                        <option label="10:00" value="10:00">10:00</option>
                                                        <option label="10:15" value="10:15">10:15</option>
                                                        <option label="10:30" value="10:30">10:30</option>
                                                        <option label="10:45" value="10:45">10:45</option>
                                                        <option label="11:00" value="11:00">11:00</option>
                                                        <option label="11:15" value="11:15">11:15</option>
                                                        <option label="11:30" value="11:30">11:30</option>
                                                        <option label="11:45" value="11:45">11:45</option>
                                                        <option label="12:00" value="12:00">12:00</option>
                                                        <option label="12:15" value="12:15">12:15</option>
                                                        <option label="12:30" value="12:30">12:30</option>
                                                        <option label="12:45" value="12:45">12:45</option>
                                                        <option label="13:00" value="13:00">13:00</option>
                                                        <option label="13:15" value="13:15">13:15</option>
                                                        <option label="13:30" value="13:30">13:30</option>
                                                        <option label="13:45" value="13:45">13:45</option>
                                                        <option label="14:00" value="14:00">14:00</option>
                                                        <option label="14:15" value="14:15">14:15</option>
                                                        <option label="14:30" value="14:30">14:30</option>
                                                        <option label="14:45" value="14:45">14:45</option>
                                                        <option label="15:00" value="15:00">15:00</option>
                                                        <option label="15:15" value="15:15">15:15</option>
                                                        <option label="15:30" value="15:30">15:30</option>
                                                        <option label="15:45" value="15:45">15:45</option>
                                                        <option label="16:00" value="16:00">16:00</option>
                                                        <option label="16:15" value="16:15">16:15</option>
                                                        <option label="16:30" value="16:30">16:30</option>
                                                        <option label="16:45" value="16:45">16:45</option>
                                                        <option label="17:00" value="17:00">17:00</option>
                                                        <option label="17:15" value="17:15">17:15</option>
                                                        <option label="17:30" value="17:30">17:30</option>
                                                        <option label="17:45" value="17:45">17:45</option>
                                                        <option label="18:00" value="18:00">18:00</option>
                                                        <option label="18:15" value="18:15">18:15</option>
                                                        <option label="18:30" value="18:30">18:30</option>
                                                        <option label="18:45" value="18:45">18:45</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="symptom" class="col-md-4 col-sm-4" required="">Triệu chứng lâm sàng: </label>
                                                <div class="col-md-8 col-sm-8">
                                                    <textarea id='symptom'
                                                            class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required"
                                                            aria-invalid="true"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-sm-4" required="">Tái khám hoặc khám mới: </label>
                                                <div class="col-md-8 col-sm-8">
                                                    <select id="examination" class="form-control ng-pristine ng-untouched">
                                                        <option value="" selected>Vui lòng chọn tái khám hoặc khám mới</option>
                                                        <option value="Khám mới">Khám mới</option>
                                                        <option value="Tái khám">Tái khám</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-sm-4">Mã khách hàng: </label>
                                                <div class="col-md-8 col-sm-8">
                                                    <input id="client_code" class="form-control ng-pristine ng-untouched" placeholder="Mã khách hàng" />
                                                </div>
                                            </div>
                                            <div class="col-md-offset-4 col-md-8 text-center">
                                                <span id="duplicateTime" class="text-danger showText hidden">Bác sĩ đã được hẹn trước</span>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4"></label>
                                                <div class="col-md-8">
                                                    <button type="submit" class="btn btn-success" id="nextStep" style="margin-bottom: 10px;">Bước tiếp theo</button>
                                                    <a class="btn btn-default" href="<?php echo get_bloginfo('url') ?>">Trở về trang chủ</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6" id="quickviewProfile">
                                        <!---->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="infoOrderer" class="tab-pane fade">
                                    <ng-form name="infoOrdererForm"
                                            class="form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-email">
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-3 col-xs-12" for="patientName">Họ tên: <span
                                                        class="red">*</span></label>
                                            <div class="col-md-6 col-sm-9 col-xs-12">
                                                <input type="text" name="patientName" placeholder="Nhập họ tên"
                                                    class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required"
                                                    aria-invalid="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-3 col-xs-12" for="patientDoB">Ngày sinh: </label>
                                            <div class="col-md-6 col-sm-9 col-xs-12">
                                                <div class="input-group date" data-provide="datepicker"
                                                    data-date-autoclose="true" data-date-format="dd/mm/yyyy"
                                                    data-date-days-of-week-highlighted="0,6" data-date-language="vi"
                                                    data-date-today-highlight="true">
                                                    <input type="text"
                                                        class="form-control ng-pristine ng-untouched ng-valid ng-empty"
                                                        name="ngaysinh" id="ngaysinh" placeholder="Chọn ngày"
                                                        ng-model="appointment.PatientDoB" aria-invalid="false">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-3 col-xs-12">Giới tính: </label>
                                            <div class="col-md-6 col-sm-9 col-xs-12">
                                                <label class="radio-inline">
                                                    <input type="radio" name="genderOptRadio" id="male"
                                                        class="ng-pristine ng-untouched ng-valid ng-empty" value="Nam"
                                                        aria-invalid="false">Nam
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="genderOptRadio" id="female"
                                                        class="ng-pristine ng-untouched ng-valid ng-empty" value="Nữ"
                                                        aria-invalid="false">Nữ
                                                </label>
                                                <input type="hidden" id="valueGender" value="0">
                                                <div class="error-message text-danger" style="display: none">Vui lòng chọn
                                                    giới tính
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-3 col-xs-12" for="patientEmail">Email: </label>
                                            <div class="col-md-6 col-sm-9 col-xs-12">
                                                <input type="email"
                                                    class="form-control ng-pristine ng-untouched ng-empty ng-valid-email ng-invalid ng-invalid-required"
                                                    placeholder="Email" name="patientEmail"
                                                    ng-model="appointment.PatientEmail" required="" aria-invalid="true">
                                                <small class="text-danger" id="validEmail" style="display: none">Vui lòng nhập đúng định dạnh email</small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-3 col-xs-12" for="patientPhone">Số điện
                                                thoại: </label>
                                            <div class="col-md-6 col-sm-9 col-xs-12">
                                                <input type="text" onkeypress="return isNumberKey(event)"
                                                    class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required"
                                                    placeholder="Số điện thoại" name="patientPhone">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-3 col-xs-12"> </label>
                                                <div class="col-md-6 col-sm-9 col-xs-8" id="example1"></div>
                                                <small style="display: none" class="text-danger msg-captcha">Please check for google captcha</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-3 col-xs-12"></label>
                                            <div class="col-md-6 col-sm-9 col-xs-8">
                                                <a href="<?php echo get_permalink($queried_object->ID) ?>" id="registerUser" class="btn btn-success preventClick">Đăng ký và tiếp tục
                                                </a>
                                            </div>
                                        </div>
                                    </ng-form>
                                </div>
                                <!---->
                            </div>
                    </div>

                    </div>

                    <script>
                    function isNumberKey(evt){
                        var charCode = (evt.which) ? evt.which : event.keyCode
                        if (charCode > 31 && (charCode < 48 || charCode > 57))
                            return false;
                        return true;
                    }
                    </script>
            </div>
    </section>

</div>
<?php get_footer(); ?>
