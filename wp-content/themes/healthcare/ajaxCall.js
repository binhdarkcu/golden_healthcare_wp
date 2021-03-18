jQuery(document).ready(function(){
    var date = new Date();
    date.setDate(date.getDate()+1);
    $('#dateTimePicker input, #dateTimePicker2').datepicker({
        format: 'dd/mm/yyyy',
        startDate: date,
        todayHighlight: false,
        autoclose: true,
        language: 'vi',
    })
    var clsName = 'has-error';
    var selectDoctor, dateAppointment,
        timeAppointment,
        symptom,
        switchTab = $('.tabMain li:eq(1) a'),
        male,
        female,
        name,
        email,
        gender,
        phone,
        examination,
        birthday,
        response;
    $('#selectDoctor').select2();
    function toDate(dateStr) {
        var parts = dateStr.split("/")
        return new Date(parts[2], parts[1] - 1, parts[0])
    }

    /* 
    * change value radio 
    */
    $('.radio-inline').click(function () {
        var val = $(this).find('input[type="radio"]').attr('value');
        gender = $(this).parents().find('input[type="hidden"]').attr('value', val);
    });

    /* 
    * checking validation and send data to server in đặt hẹn
    */
    $('#registerUser').click(function () {
        // response = grecaptcha.getResponse();
        male = $('#male').is(':checked');
        female = $('#female').is(':checked');
        name = $('input[name="patientName"]');
        email = $('input[name="patientEmail"]');
        phone = $('input[name="patientPhone"]');
        birthday = $('input[name="ngaysinh"]').datepicker().val();
        if (name !== '' && phone !== '' && birthday !== '' && response !== '' && male || female) {
            $.ajax({
                type:'POST',
                data:{
                    action:'action_insert_db',
                    id_doctor: selectDoctor,
                    day_booked: dateAppointment,
                    time_booked: timeAppointment,
                    symptom: symptom,
                    full_name: name.val(),
                    email: email.val(),
                    phone: phone.val(),
                    birthday: birthday,
                    gender: gender.val(),
                    examination: examination,
                    client_code: $('#client_code').val(),
                    doctorName: $('#selectDoctor').select2('data')[0]['text']
                },
                url: my_ajax_insert_db.ajax_url
            });
            alert('Đăng ký thành công');
            return true
        } else {
            if (name.val() == '') {
                name.addClass(clsName);
            }
            if (email.val() == '') {
                email.addClass(clsName)
            }
            if (phone.val() == '') {
                phone.addClass(clsName)
            }
            if (!male && !female) {
                $('.error-message').css({'display': 'block'})
            }
            if (!birthday) {
                $('input[name="ngaysinh"]').addClass(clsName)
            }
            if (response == '') {
                $('.msg-captcha').css({'display': 'block'})
            }
            return false;
        }
    });

    /* 
    * checking validation and next step in đặt hẹn 
    */
    $('#nextStep').click(function () {
        selectDoctor = $('#selectDoctor').val();
        dateAppointment = $('#dateTimePicker input').datepicker().val();
        symptom = $('#symptom').val();
        timeAppointment = $('select[name="timeOrder"]').val();
        examination = $('#examination').val();
        if (selectDoctor !== 0 && dateAppointment !== '' && symptom !== '') {
            if (symptom) {
                $('#symptom').removeClass(clsName)
            }
            if (selectDoctor !== 0) {
                $('.select2-selection--single').removeClass(clsName)
            }
            if (dateAppointment) {
                $('#dateTimePicker input').removeClass(clsName)
            }
            if(examination) {
                $('#examination').removeClass(clsName)
            }
            $.ajax({
                type: 'GET',
                data: {
                    action: 'action_check_time_booked',
                    id_doctor: selectDoctor,
                    day_booked: dateAppointment,
                    time: timeAppointment
                },
                url: my_ajax_insert_db.ajax_url,
                success: function (response) {
                    if(response.length > 0) {
                        $('#timeAppointment').addClass(clsName);
                        $('#duplicateTime').removeClass('hidden');
                    } else {
                        $('#timeAppointment').removeClass(clsName);
                        $('#duplicateTime').addClass('hidden');
                        switchTab.tab('show');
                        switchTab.removeClass('disableTab');
                    }
                }
            })
        } else {
            if(examination == '') {
                $('#examination').addClass(clsName)
            }
            if (!symptom) {
                $('#symptom').addClass(clsName)
            }
            if (selectDoctor == 0) {
                $('.select2-selection--single').addClass(clsName)
            }
            if (dateAppointment == '') {
                $('#dateTimePicker input').addClass(clsName)
            }
            
        }
        return false
    });
    
    /* =======================================================================================*/
    /* checking validation and send data to server in đặt hẹn công ty */
    const reducer = (accumulator, currentValue) => accumulator + currentValue;
    var countError = 0, totalAmount;
    $('#registerScheduleCompany').click(function () {
        $('#formScheduleCompany').validate({
            rules: {
                nameOfCompany: "required",
                name: "required",
                yourBirthday: 'required',
                genderOptRadio: 'required',
                yourEmail: {
                    required: true,
                    email: true
                },
                yourPhone: 'required',
                timeOrder: 'required',
                sessionOrder: 'required',
                companyCode: 'required'
            },
            messages: {
                genderOptRadio: 'Vui lòng chọn giới tính'
            },
            highlight: function (element) {
                $(element).addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).removeClass('has-error');
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") ) {
                    error.appendTo( element.parents('.form-group .col-xs-8') );
                }
            },
            submitHandler: function () {
                $.ajax({
                    type: 'GET',
                    url: my_ajax_insert_db.ajax_url,
                    data: {
                        action: 'action_handle_check_code',
                        company_name: $('select[name="nameOfCompany"]').val(),
                        companyCode: $('input[name="companyCode"]').val()
                    },
                    success: function(res) {
                        $('.tab-content').removeClass('loadingForm')
                        /**
                         * logic: if company code fail equal 5, disable register
                         */
                        if(res.length == 0) {
                            countError++;
                            $('input[name="companyCode"]').val('');
                            $('input[name="companyCode"]').addClass('has-error');
                            $('#companyCodeFailed').removeClass('d-none')
                            if(countError == 5) {
                                alert('Vui lòng liên hệ phòng khám để nhận mã công ty');
                                countError = 0;
                                $('#registerScheduleCompany').addClass('disableButton').removeAttr('id')
                                $('input[name="companyCode"]').removeClass('has-error')
                                $('input[name="companyCode"]').prop('disabled', true);
                            }
                        } else {
                            /**
                             * logic: compare amount current and maximun amount
                             */
                            check_amount_registered(function(res) {
                                if(res.length >= parseInt(totalAmount)) {
                                    $('#limitAmount').attr('style', '')
                                    $('#limitAmount').find('label').addClass('statusErr')
                                } else {
                                    $.ajax({
                                        type: 'POST',
                                        url: my_ajax_insert_db.ajax_url,
                                        data: {
                                            action: 'action_insert_db_schedule_company',
                                            company_name: $('select[name="nameOfCompany"]').val(),
                                            name: $('.yourName').val(),
                                            birthday: $('#yourBirthday').datepicker().val(),
                                            gender: $('#valueGender').val(),
                                            email: $('.yourEmail').val(),
                                            phone: $('.yourPhone').val(),
                                            marital_status: $('.marital_status').val(),
                                            day: $('input[name="timeOrder"]').datepicker().val(),
                                            sessions: $('select[name="sessionOrder"]').val(),
                                            employee_code: $('.yourCode').val(),
                                            note: $('.yourNote').val()
                                        }
                                    })
                                    alert('Đăng ký thành công')
                                    location.reload();
                                }
                            })
                        }
                    },
                    beforeSend: function() {
                        $('.tab-content').addClass('loadingForm')
                    }
                })
            }
        });
    });

    //return date wwith format: 1/1/2011
    function pad(num) {
        return num.replace(/(^|\/)0+/g, '$1')
    }

    //convert string to array
    function convertString(val) {
        return val.split(",");
    }

   /**
    * logic: send a request to server to get a Json to check amount of session with a paramatter 
    */
   function check_amount(val, callback) {
        var amount = [];
        if(val == '') {
            return
        } else {
            $.ajax({
                type: 'GET',
                url: my_ajax_insert_db.ajax_url,
                data: {
                    action: 'action_check_amount_register',
                    company_name: $('select[name="nameOfCompany"]').val(),
                    day: $('input[name="timeOrder"]').datepicker().val()
                },
                success: function(res) {
                    $('.tab-content').removeClass('loadingForm')
                    return Object.values(res[0]).forEach(function(element) {
                        if(element == val) {
                            switch(element) {
                                case 'Sáng':
                                    amount.push(res[0].amount_morning)
                                    callback(amount)
                                    break;
                                case 'Chiều':
                                    amount.push(res[0].amount_afternoon)
                                    callback(amount)
                                    break;
                                default:
                                    return []
                                    break;
                            }
                        }
                    })
                },
                beforeSend: function() {
                    $('.tab-content').addClass('loadingForm')
                }
            })
        }
   }

   /**
    * logic: send request GET to check amount registered
    */
   function check_amount_registered(callback) {
        $.ajax({
            type: 'GET',
            url: my_ajax_insert_db.ajax_url,
            data: {
                action: 'action_check_number',
                company_name: $('select[name="nameOfCompany"]').val(),
                date: $('input[name="timeOrder"]').datepicker().val(),
                session: $('select[name="sessionOrder"]').val()
            },
            success: function(res) {
                $('.tab-content').removeClass('loadingForm')
                callback(res)
            },
            beforeSend: function() {
                $('.tab-content').addClass('loadingForm')
            }
        })
   }

    /*
    * render calender and session when select company
    */
    $('select[name="nameOfCompany"]').change(function() {
        $('input[name="timeOrder"]').datepicker("destroy");
        var onlyThisDates = [];
        $.ajax({
            type: 'GET',
            url: my_ajax_insert_db.ajax_url,
            data: {
                action: 'action_handle_check_date',
                companyName: $(this).val()
            },
            success: function(res) {
                $('.tab-content').removeClass('loadingForm')
                if(res.length > 0) {
                    //logic: check date in db and only show the day avilable (multiple days)
                    res.map(function(e) {
                        return onlyThisDates.push(pad(e.date))
                    })
                    $('input[name="timeOrder"]').datepicker({
                        format: 'dd/mm/yyyy',
                        beforeShowDay: function(date) {
                            var dt_ddmmyyyy = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
                            return (onlyThisDates.indexOf(dt_ddmmyyyy) != -1);
                        },
                        autoclose: 1
                    }).on('changeDate', function(e) {
                        //logic: append buổi follow  days
                        $.ajax({
                            type: 'GET',
                            url: my_ajax_insert_db.ajax_url,
                            data: {
                                action: 'action_handle_check_session',
                                companyName: $('.name_of_company').val(),
                                day: moment(e.date).format('DD/MM/YYYY')
                            },
                            success: function(res) {
                                var sessionOrder = $('select[name="sessionOrder"]');
                                sessionOrder.empty();
                                var arrSessions = [];
                                Object.keys(res[0]).forEach(function(e) {
                                    if(res[0][e] !== '') {
                                        arrSessions.push(res[0][e])
                                    }
                                })
                                arrSessions.map(function(e) {
                                    sessionOrder.append($('<option>', {
                                        value: e,
                                        text: e
                                    }))
                                })
                                $('select[name="sessionOrder"] option:first').attr('selected','selected')
                                sessionOrder.promise().done(function() {
                                    check_amount($(this).val(), function(res) {
                                        $('#textError').attr('style', '');
                                        $('#total_current').text(res.toString())
                                        totalAmount = parseInt(res.toString())
                                        check_amount_registered(function(res) {
                                            $('#current_register').text(res.length)
                                        })
                                    })
                                })

                                //logic: send a request to server to get a Json to check amount of session
                                sessionOrder.on('change', function() {
                                    check_amount($(this).val(), function(res) {
                                        $('#total_current').text(res.toString())
                                        totalAmount = parseInt(res.toString())
                                        check_amount_registered(function(res) {
                                            $('#current_register').text(res.length)
                                        })
                                    })
                                })
                            }
                        })
                    })
                } else {
                    //show all date (logic: if db return date with value == [])
                    var arrSession = ['Sáng', 'Chiều'];
                    $('input[name="timeOrder"]').datepicker({
                        format: 'dd/mm/yyyy',
                        startDate: date,
                        todayHighlight: false,
                        autoclose: true,
                        language: 'vi',
                    })
                    arrSession.map(function(e) {
                        $('select[name="sessionOrder"]').append($('<option>', {
                            value: e,
                            text: e
                        }))
                    })
                }
            },
            beforeSend: function() {
                $('.tab-content').addClass('loadingForm')
            }
        })
    })

    /* 
    * checking validation and send data form 2 
    */
    $('#registerCompany').click(function () {
        $('#formCompany').validate({
            rules: {
                companyName: 'required',
                insuranceAgent: 'required',
                nameCompany: 'required',
                birthdayCompany: 'required',
                genderCompany: 'required',
                emailCompany: {
                    required: true,
                    email: true
                },
                phoneCompany: 'required',
                dateCompany: 'required'
            },
            messages: {
                genderCompany: 'Vui lòng chọn giới tính'
            },
            highlight: function (element) {
                $(element).addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).removeClass('has-error');
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") ) {
                    error.appendTo( element.parents('.form-group .col-xs-8') );
                }
            },
            submitHandler: function () {
                $.ajax({
                    type: 'GET',
                    url: my_ajax_insert_db.ajax_url,
                    data: {
                        action: 'action_check_total_number',
                        companyName: $('.companyName').val(),
                        date: $('input[name="dateCompany"]').datepicker().val()
                    },
                    success: function (res) {
                        $('.tab-content').removeClass('loadingForm')
                        var total_current = [],
                        total_register = parseInt(res.list_company[0].total_members),
                        amount_current = '';
                        res.company.length > 0 ? res.company.map(function (e) {
                            return total_current.push(parseInt(e.amount))
                        }) : total_current = [0];
                        amount_current = total_current.reduce(reducer)
                        // console.log('total_register:', total_register, 'amount_current: ', amount_current)
                        if(total_current.length > 0 && parseInt(amount_current + 1) > total_register) {
                            $('#text_error').attr('style', '');
                            $('#current_amount').text(total_current.reduce(reducer) + '/' + total_register);
                        } else {
                            $('#text_error').css('display', 'none');
                            $('input[name="amountCompany"]').removeClass('has-error');
                            $.ajax({
                                type: 'POST',
                                url: my_ajax_insert_db.ajax_url,
                                data: {
                                    action: 'action_insert_db_compant_not_schedule',
                                    company_name: $('.companyName').val(),
                                    amount: 1,
                                    name: $('input[name="nameCompany"]').val(),
                                    birthday: $('input[name="birthdayCompany"]').val(),
                                    gender: $('#valueGender01').attr('value'),
                                    email: $('input[name="emailCompany"]').val(),
                                    phone: $('input[name="phoneCompany"]').val(),
                                    statusYourself: $('.statusYourself').val(),
                                    date: $('input[name="dateCompany"]').datepicker().val(),
                                    session: $('select[name="sessionCompany"]').val(),
                                    codeCompany: $('input.codeCompany').val(),
                                    noteCompany: $('textarea.noteCompany').val()
                                },
                                success: function() {
                                    alert('Đăng ký thành công')
                                    location.reload();
                                }
                            })
                        }
                    },
                    beforeSend: function() {
                        $('.tab-content').addClass('loadingForm')
                    }
                })
            }
        })
    });
});
