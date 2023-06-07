<?php

/** @var yii\web\View $this */

use yii\widgets\LinkPager;

$this->title = 'Welcome, stranger!';
?>
<div class="site-index">

    <?php
    foreach($posts as $post):?>
    <post class="post">
        <h1>Post</h1>
        <a href="blog.html"<img src="<?=$post->getImage();?>"
    </post>
    <?php endforeach; ?>

    <?php
    echo LinkPager::widget([
    'pagination' => $pagination,
    ]);
    ?>

</div>
