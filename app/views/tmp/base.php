<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>NEW META</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="<?php echo _path_tmp('assets/css/loader.css')?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo _path_tmp('assets/js/loader.js')?>"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="<?php echo _path_tmp('bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo _path_tmp('assets/css/plugins.css')?>" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="<?php echo _path_tmp('plugins/apex/apexcharts.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo _path_tmp('assets/css/dashboard/dash_2.css')?>" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('plugins/table/datatable/datatables.css')?>">
    <link rel="stylesheet" type="text/css" href="<?php echo _path_tmp('plugins/table/datatable/dt-global_style.css')?>">
    <!-- END PAGE LEVEL STYLES -->

</head>
<body class="alt-menu sidebar-noneoverflow">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container">
        <?php grab('partial/navigation_header')?>
        <?php grab('partial/navigation_main')?>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN TOPBAR  -->
        <?php produce('navigation') ?>
        <!--  END TOPBAR  -->
        
        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <?php if( isset($pageTitle)):?>
                <div class="page-header">
                    <div class="page-title">
                        <h3><?php echo $pageTitle?></h3>
                    </div>
                </div>
                <?php endif?>

                <div class="layout-top-spacing">
                    <?php produce('content')?>
                </div>

                <div class="footer-wrapper">
                    <div class="footer-section f-section-1">
                        <p class="">Copyright © 2021 <?php echo COMPANY_NAME?></p>
                    </div>
                </div>

            </div>
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo _path_tmp('assets/js/libs/jquery-3.1.1.min.js')?>"></script>
    <script src="<?php echo _path_tmp('bootstrap/js/popper.min.js')?>"></script>
    <script src="<?php echo _path_tmp('bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo _path_tmp('plugins/perfect-scrollbar/perfect-scrollbar.min.js')?>"></script>
    <script src="<?php echo _path_tmp('assets/js/app.js')?>"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="<?php echo _path_tmp('assets/js/custom.js')?>"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="<?php echo _path_tmp('plugins/apex/apexcharts.min.js')?>"></script>
    <script src="<?php echo _path_tmp('assets/js/dashboard/dash_2.js')?>"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <?php produce('scripts')?>
</body>
</html>