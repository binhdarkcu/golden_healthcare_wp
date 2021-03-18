<?php get_header() ?>
<?php
    global $wpdb;
    $schedule = "SELECT company_name FROM wp_list_company WHERE show_on_site = 'show'";
    $not_schedule = "SELECT company_name FROM wp_list_company WHERE status_company = 'company_not_schedule'";
    $items_schedule_company = $wpdb->get_results($schedule);
    $items_not_schedule_company = $wpdb->get_results($not_schedule);
?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section>
        <div class="container container-bd" id="container" style="padding-top: 50px">
            <div class="row">
                <div class="conten col-md-12 col-sm-12 col-xs-12" style="margin-top:30px;">
                <ul class="nav nav-tabs tabMain" aria-hidden="false">
                    <li class="active"><a showtab="" data-toggle="tab" href="#appointment" aria-expanded="true"><i
                                class="fa fa-calendar" aria-hidden="true"></i> Khám sức khỏe định kỳ công ty</a></li>
                    <li class=""><a showtab="" data-toggle="tab" href="#infoOrderer" aria-expanded="false"><i
                                class="fa fa-id-card-o" aria-hidden="true"></i> Khám sức khỏe tuyển dụng / khám theo bảo hiểm</a></li>
                </ul>
                <div class="tab-content" style="margin-bottom: 30px;" aria-hidden="false">
                    <div id="appointment" class="tab-pane active fade in">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" id="formScheduleCompany" method="post">
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Tên công ty:*</label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <select class="form-control name_of_company" name="nameOfCompany" style="background: lightyellow;">
                                            <option value="">Vui lòng chọn công ty của bạn</option>
                                            <?php
                                                foreach ($items_schedule_company as $item_added) {
                                                    echo '<option value="'.$item_added->company_name.'">'.$item_added->company_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Mã công ty:*</label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <input type="input" name="companyCode" style="background: lightyellow;"
                                            class="form-control yourCompanyCode" placeholder="Mã công ty*" />
                                            <label for="" class="text-error d-none" id="companyCodeFailed">Sai mã công ty. Vui lòng nhập lại!</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Họ tên:*</label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <input type="text" name="name" style="background: lightyellow;" class="form-control yourName" placeholder="Họ tên*" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dateOrder" class="col-md-2 col-sm-3 col-xs-12">Ngày tháng năm sinh:* </label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <div class="input-group date" data-provide="datepicker"
                                            data-date-autoclose="true" data-date-format="dd/mm/yyyy"
                                            data-date-days-of-week-highlighted="0,6" data-date-language="vi"
                                            data-date-today-highlight="true">
                                            <input type="text" style="background: lightyellow;"
                                                class="form-control ng-pristine ng-untouched ng-valid ng-empty"
                                                name="yourBirthday" id="yourBirthday" placeholder="Chọn ngày"
                                                ng-model="appointment.PatientDoB" aria-invalid="false">
                                            <div class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Giới tính:* </label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <label class="radio-inline">
                                            <input type="radio" name="genderOptRadio" id="male"
                                                class="ng-pristine ng-untouched ng-valid ng-empty" value="Nam"
                                                aria-invalid="false">Nam
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="genderOptRadio" id="female"
                                                class="ng-pristine ng-untouched ng-valid ng-empty" value="Nữ">Nữ
                                        </label>
                                        <input type="hidden" id="valueGender" value="0">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Email:*</label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <input style="background: lightyellow;" type="text" name="yourEmail" class="form-control ng-pristine ng-untouched yourEmail" placeholder="Email*" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Số điện thoại:*</label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <input type="text" onkeypress="return isNumberKey(event)" name="yourPhone" style="background: lightyellow;"
                                            class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required yourPhone"
                                            placeholder="Số điện thoại">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Tình trạng hôn nhân:</label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <select class="form-control marital_status">
                                            <option value="" selected>Vui lòng chọn tình trạng hôn nhân</option>
                                            <option value="Độc thân">Độc thân</option>
                                            <option value="Đã kết hôn">Đã kết hôn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dateOrder" class="col-md-2 col-sm-3 col-xs-12" style="padding-right:0;">Thời gian đặt hẹn:* </label>
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                        <div class="input-group date">
                                            <input type="text" name="timeOrder"
                                                class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required"
                                                placeholder="Chọn ngày" autocomplete="off" style="background: lightyellow;"
                                                aria-invalid="false">
                                            <div class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-md-1 col-sm-1 col-xs-12">Buổi:*</label>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <select style="background: lightyellow;" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required sessions" name="sessionOrder">
                                            <option value="" selected>Chọn buổi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="textError" style="display: none">
                                    <label class="col-md-2 col-sm-3 col-xs-12"></label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <label>Số lượng hiện tại là: <span id="current_register">0</span>/<span id="total_current">0</span>.</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Mã nhân viên / phòng ban:</label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control ng-pristine ng-untouched yourCode" placeholder="Nhập mã" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12">Ghi chú:</label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <textarea type="text" class="form-control ng-pristine ng-untouched yourNote" placeholder="Ghi chú"></textarea>
                                    </div>
                                </div>
                                <div class="form-group" id="limitAmount" style="display: none">
                                    <label class="col-md-2 col-sm-3 col-xs-12"></label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <label>Đã vượt qua số lượng cho phép, vui lòng chọn ngày hoặc buổi khác.</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"></label>
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-success" id="registerScheduleCompany">Đăng ký</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="infoOrderer" class="tab-pane fade ">
                        <form id="formCompany" class="form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-email">
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12" for="patientName">Chọn công ty bảo hiểm: <span
                                        class="red">*</span></label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <select class="form-control companyName" name="companyName" style="background: lightyellow;">
                                        <option value="">Vui lòng chọn công ty bảo hiểm</option>
                                        <?php foreach($items_not_schedule_company as $item_not_schedule_company): ?>
                                            <option value="<?php echo $item_not_schedule_company->company_name?>"><?php echo $item_not_schedule_company->company_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12">Họ tên:*</label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <input type="text" name="nameCompany" style="background: lightyellow;"
                                            class="form-control nameCompany" placeholder="Họ tên" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12">Ngày tháng năm sinh:*</label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <div class="input-group date" data-provide="datepicker"
                                            data-date-autoclose="true" data-date-format="dd/mm/yyyy"
                                            data-date-days-of-week-highlighted="0,6" data-date-language="vi"
                                            data-date-today-highlight="true">
                                            <input type="text"
                                                class="form-control ng-pristine ng-untouched ng-valid ng-empty"
                                                name="birthdayCompany" placeholder="Chọn ngày" style="background: lightyellow;"
                                                ng-model="appointment.PatientDoB" aria-invalid="false">
                                            <div class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12">Giới tính:* </label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                        <label class="radio-inline">
                                            <input type="radio" name="genderCompany"
                                                class="ng-pristine ng-untouched ng-valid ng-empty" value="Nam"
                                                aria-invalid="false">Nam
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="genderCompany"
                                                class="ng-pristine ng-untouched ng-valid ng-empty" value="Nữ">Nữ
                                        </label>
                                        <input type="hidden" id="valueGender01" value="0">
                                        <div class="clearfix"></div>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12">Email:* </label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <input type="email" style="background: lightyellow;"
                                        class="form-control ng-pristine ng-untouched"
                                        placeholder="Email" name="emailCompany"
                                        aria-invalid="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12">Số điện
                                    thoại:* </label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <input type="text" onkeypress="return isNumberKey(event)" style="background: lightyellow;"
                                        class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required"
                                        placeholder="Số điện thoại" name="phoneCompany">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12">Tình trạng hôn nhân:</label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <select class="form-control statusYourself">
                                        <option value="" selected hidden>Vui lòng chọn tình trạng hôn nhân</option>
                                        <option value="Độc thân">Độc thân</option>
                                        <option value="Đã kết hôn">Đã kết hôn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dateOrder" class="col-md-2 col-sm-3 col-xs-12" style="padding-right:0;">Thời gian đặt hẹn:* </label>
                                <div class="col-md-2 col-sm-3 col-xs-12">
                                    <div id="dateTimePicker" class="input-group date">
                                        <input type="text" name="dateCompany" style="background: lightyellow;"
                                            class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required"
                                            placeholder="Chọn ngày" autocomplete="off"
                                            aria-invalid="false">
                                        <div class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-md-1 col-sm-1 col-xs-12">Buổi:*</label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <select style="background: lightyellow;" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required sessions" name="sessionCompany">
                                        <option value="Sáng" selected>Sáng</option>
                                        <option value="Chiều">Chiều</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12">Mã nhân viên / phòng ban:</label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control ng-pristine ng-untouched codeCompany" placeholder="Nhập mã" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12">Ghi chú:</label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <textarea type="text" class="form-control ng-pristine ng-untouched noteCompany" placeholder="Ghi chú"></textarea>
                                </div>
                            </div>
                            <div class="form-group" id="text_error" style="display: none">
                                <label class="col-md-2 col-sm-3 col-xs-12"></label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <label class="">Đã vượt quá số lượng khám chữa bệnh trong ngày. Số lượng hiện tại là: <span id="current_amount">0/0</span></label>
                                </div>            
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 col-sm-3 col-xs-12"></label>
                                <div class="col-md-6 col-sm-9 col-xs-12">
                                    <button type="submit" id="registerCompany" class="btn btn-success">Đăng ký</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!---->
                </div>
                <h3 class="column-title">Lưu ý chung</h3>
                <div style="padding-bottom: 30px;">
                    <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            the_content();
                        } // end while
                    } // end if
                    ?>
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
            </div>
    </section>

</div>
<?php get_footer(); ?>
