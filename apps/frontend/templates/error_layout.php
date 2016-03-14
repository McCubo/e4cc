<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_http_metas(); ?>
        <?php include_metas(); ?>
        <?php include_title(); ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets(); ?>
        <?php include_javascripts(); ?>
    </head>
    <body>
        <div class="container" style="margin: 77px auto 0px;">
            <div class="errorLabel"></div>
            <!-- start: contentMiddle -->
            <?php echo $sf_content; ?>
            <!-- end: contentMiddle -->
            <div class="contentFooter"></div>
            <!-- start: footerMenu -->
            <div class="footerMenu">
                <ul>
                    <li><a href="#">Home</a></li><li>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a href="#">About</a></li><li>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a href="#">Contact us</a></li><li>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a href="#">Support</a></li>
                </ul>
            </div>
            <!-- end: footerMenu -->
        </div>
        <!-- end: container -->

    </body>
</html>