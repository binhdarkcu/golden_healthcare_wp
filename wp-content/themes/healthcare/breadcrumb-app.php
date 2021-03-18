<?php
    $queried_object = get_queried_object();
    $id = $queried_object->ID;
    $bg = get_field('background_breadcrumb', $id);
    if($bg) {
        $bg = $bg['url'];
    } else {
        $bg = get_stylesheet_directory_uri().'/assets/find_bs.jpg';
    }
    $title = '';
    if(has_term('', 'category')) {
        $terms = get_the_terms( $posts[0]->ID, 'category' );
        $title = $terms[0]->name;
    } else {
        $title = get_the_title($id);
    }
    // if($queried_object->post_title) :
?>
<div class="breadcrumbHeath" style="background: url('<?php echo $bg ?>') center center no-repeat;background-size: cover;">
    <h1>Tin tức y học</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><?php echo $title ?></li>
        </ol>
    </nav>
</div>
