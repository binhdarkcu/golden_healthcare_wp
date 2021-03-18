<?php
    global $post;
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <h1>Tìm bác sĩ</h1>
    <div class="searchcontrols row col-lg-12">
        <form role="search" method="get" class="form-horizontal searchForm" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="col-md-3">
                <input value="<?php echo get_search_query()?>" name="s" class="searchinputm ng-pristine ng-untouched ng-valid ng-empty" type="text" title="Nhập tên bác sỹ" placeholder="Nhập tên bác sĩ" ng-model="searchDoctor" aria-invalid="false">
            </div>
            <div class="col-md-4" style="padding-left:0px;">
                <div class="dropdown dropdown-lg col-md-10" style="padding:0px;">
                    <select name="khoa" class="searchinputm ng-pristine ng-untouched ng-valid ng-empty" style="border-radius: 10px;" aria-invalid="false">
                        <option value="" id="defaultDepartment" selected="selected">Chọn Chuyên Khoa</option>
                        <?php
                          $categories = get_categories();
                          foreach( $categories as $category ) {
                        ?>
                             <option <?php if($_GET['khoa'] == $category->name) echo 'selected';?> label="<?php echo $category->name;?>" value="<?php echo $category->name;?>"><?php echo $category->name;?></option>
                          <?php } ?>

                    </select>
                </div>
                <div class="col-md-2" style="padding-left:0px;">
                    <input type="hidden" name="page" value="tim-bac-si">
                    <button type="submit" class="fa fa-search searchbuttonm"></button>
                </div>
            </div>
        </form>
    </div>
</div>
