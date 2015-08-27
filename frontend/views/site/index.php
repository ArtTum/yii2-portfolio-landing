<?php
/* @var $this yii\web\View */
$this->title = Yii::$app->name;

//Pseudo template of index page

//--Header--

//Logo (template), menu (entity, editable, backend), language select

//--/Header--

//Photo, text with js self-erasing roles, button (static text widget, editable, backend)

//"Hello world" text (static text widget, editable, backend)

//Optional: what i love. Think about it.

//My skills: blocks with description, graphs (entity, editable, backend) and resume (static text widget, editable, backend)

//My employers: icons (entity, editable, backend). Optional: additional info (period, position)

//My projects (entity, editable, backend). Optional: create case pages.

//My photo (module, integration): flickr + instagram

//My blogs (module, integration): twitter + medium.com

//Hobbies (entity, editable, backend)

//--Footer--

//Feedback form (entity, backend, email) + email, skype, telegram

//Google map (module, integration)

//My social (module, editable, backend): linkedin, fb, twitter, medium, vk, github

//--/Footer--
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>
        <?php echo common\widgets\DbText::widget(['key' => 'index_test']) ?>
        <p class="lead">You have successfully created your Yii-powered application.</p>

        <?php echo common\widgets\DbMenu::widget([
            'key'=>'frontend-index',
            'options'=>[
                'tag'=>'p'
            ]
        ]) ?>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
