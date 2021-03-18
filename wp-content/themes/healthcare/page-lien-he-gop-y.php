<?php get_header()?>
<?php include_once('breadcrumb.php') ?>
<div ng-init="loadData()">
    <section id="contact" style="margin-bottom:80px;height:700px">
        <div id="google-map" style="height:650px" data-latitude="52.365629" data-longitude="4.871331">

        </div>
        <div class="container-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div ng-bind-html="contact.GoogleMap | trusted"><iframe style="width: 100%; margin-top: 50px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d823.9013118313533!2d106.64648384710628!3d10.799268884097291!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175299465a6aa4d%3A0x736056bf971601aa!2zUEjDkk5HIEtIw4FNIMSQQSBLSE9BIFFV4buQQyBU4bq-IEdPTERFTiBIRUFMVEhDQVJF!5e0!3m2!1sen!2s!4v1552061025538" width="400" height="584" frameborder="0" style="border:0" allowfullscreen></iframe></div>
                        <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.7082773570987!2d106.6622853145632!3d10.756951392334763!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752efa8f7ecc25%3A0xe68b14f82698f12e!2sPham+Ngoc+Thach+Hospital!5e0!3m2!1sen!2s!4v1507092081256" frameborder="0" style="border:0;  width:100%; height:564px; margin-top:50px; border:2px solid #ccc;" allowfullscreen></iframe>-->
                    </div>
                    <div class="col-sm-4">
                        <div class="contact-form">
                            <h3>Liên hệ với chúng tôi</h3>
                            <address>
                                <strong><?php echo get_field('name_of_clinic', 'option'); ?></strong><br>
                                <?php echo get_field('footer_address', 'option'); ?><br>
                                <abbr title="Phone">Điện thoại:</abbr> <?php echo get_field('footer_phone', 'option'); ?><br>
                                <abbr title="Hotline">Email:</abbr> <?php echo get_field('footer_email', 'option'); ?><br>
                            </address>

                            <form id="main-form-contact" class="ng-pristine ng-invalid ng-invalid-required ng-valid-email">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="Họ tên" ng-model="OfferAdvise.Name" required="" aria-invalid="true">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control ng-pristine ng-untouched ng-empty ng-valid-email ng-invalid ng-invalid-required" placeholder="Email" ng-model="OfferAdvise.Email" required="" aria-invalid="true">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="subject" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" placeholder="Chủ đề" ng-model="OfferAdvise.Status" required="" aria-invalid="true">
                                </div>
                                <div class="form-group">
                                    <select class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="phongban">
                                        <option selected>Chọn phòng ban</option>
                                        <option value="<?php echo get_field('mail_giam_doc', 'option') ?>">Ban giám đốc</option>
                                        <option value="<?php echo get_field('mail_cskh', 'option') ?>">Chăm sóc khách hàng</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea name="message" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" rows="8" placeholder="Nội dung" ng-model="OfferAdvise.Detail" required="" aria-invalid="true"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
                                <div class="block" style="padding-top: 20px">
                                    <!---->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?php get_footer();?>
