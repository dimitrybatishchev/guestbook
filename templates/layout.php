<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8" />
    <title>PHP guestbook | Script Tutorials</title>
    <link href="<?php echo $this->webRoot(); ?>css/normalize.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webRoot(); ?>css/foundation.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->webRoot(); ?>css/app.css" rel="stylesheet" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
<header>
    <div class="row">
        <div class="large-12 columns">
            <h1>Download Foundation 5</h1>
            <h4>Seriously, it’s free. Just pick the right one for you.</h4>
        </div>
    </div>
</header>
<section id="main-content">
    <div class="row">
        <?php echo $content ?>
    </div>
</section>
</body>
</html>