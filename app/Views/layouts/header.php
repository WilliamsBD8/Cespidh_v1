<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta name="description"
            content="<?= isset(configInfo()['meta_description']) ? configInfo()['meta_description'] : 'Name' ?>">
      <meta name="keywords"
            content="<?= isset(configInfo()['meta_keywords']) ? configInfo()['meta_keywords'] : 'Name' ?>">
      <meta name="author" content="IPlanet Colombia S.A.S">
      <title><?= isset(configInfo()['name_app']) ? configInfo()['name_app'] : 'Name' ?></title>
      <link rel="apple-touch-icon" href="<?= !isset(configInfo()['favicon']) ||  empty(configInfo()['favicon']) ? base_url().'/assets/img/logo.png' :  base_url().'/assets/upload/images/'.configInfo()['favicon']   ?>">
      <link rel="shortcut icon" type="image/x-icon" href="<?= !isset(configInfo()['favicon']) ||  empty(configInfo()['favicon']) ? base_url().'/assets/img/logo.png' :  base_url().'/assets/img/'.configInfo()['favicon']   ?>">
      <title><?= isset(configInfo()['name_app']) ? configInfo()['name_app'] : '' ?></title>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/sweetalert/sweetalert.css">



      <!-- BEGIN: VENDOR CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/vendors.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/animate-css/animate.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/chartist-js/chartist.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/chartist-js/chartist-plugin-tooltip.css">
      <!-- END: VENDOR CSS-->
      <!-- BEGIN: Page Level CSS-->
      
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/materialize.css">
      <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/themes/horizontal-menu-template/materialize.css"> -->
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/themes/horizontal-menu-template/style.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/layouts/style-horizontal.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/dashboard-modern.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/intro.css">
      <!-- END: Page Level CSS-->
      <!-- BEGIN: Custom CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/custom/custom.css">
      <!-- END: Custom CSS-->


      <link rel="stylesheet" href="<?= base_url() ?>/assets/css/myStyles/style.css">




      <link rel="stylesheet" href="<?= base_url() ?>/grocery-crud/css/jquery-ui/jquery-ui.css">
      <link rel="stylesheet" href="<?= base_url() ?>/grocery-crud/css/grocery-crud-v2.8.1.0659b25.css">
      <link rel="stylesheet" href="<?= base_url() ?>/grocery-crud/css/bootstrap/bootstrap.css">
      <link rel="stylesheet" href="<?= base_url() ?>/assets/css/iplanet.css">
      <script src="<?= base_url() ?>/assets/ckeditor/ckeditor.js"></script>


      <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/select2/select2.min.css" type="text/css">
      <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/select2/select2-materialize.css" type="text/css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/form-select2.css">

      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/css/jquery.dataTables.min.css">
      
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/css/select.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/materialize-stepper/materialize-stepper.min.css">


      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/table.css">

      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/data-tables.css">
      
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/page-faq.css">
      
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/flag-icon/css/flag-icon.min.css">

      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/form-wizard.css">

      
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/app-file-manager.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/widget-timeline.css">

      
      <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/dropify/css/dropify.min.css">

</head>
<body class="horizontal-layout page-header-light horizontal-menu preload-transitions 2-columns   " data-open="click" data-menu="horizontal-menu" data-col="2-columns">
