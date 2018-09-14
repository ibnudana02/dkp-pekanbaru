<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#F90487">
    <meta name="description" content="<?php e(isset($meta_description) ? $meta_description : ''); ?>">
    <meta name="author" content="<?php e(isset($meta_author) ? $meta_author : ''); ?>">
    <title><?php
        echo isset($page_title) ? "{$page_title} : " : '';
        e(class_exists('Settings_lib') ? settings_item('site.title') : 'Pekanbaru');
    ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootflat.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
	
    <?php echo Assets::css(); ?>    
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/images/favicon-76.png') ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('assets/images/favicon-120.png') ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('assets/images/favicon-152.png') ?>">
    <link rel="icon" sizes="196x196" href="<?= base_url('assets/images/favicon-196.png') ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
  </head>

  <body>
   <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
       <div class="navbar-header page-scroll">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar">
             <span class="sr-only">Toggle navigation</span>
             <i class="fa fa-bars"></i>
         </button>
         <a class="navbar-brand" href="<?= base_url() ?>">SIG DKP Pekanbaru</a>
        </div>
        <div class="navbar-collapse collapse" id="bs-navbar">
          <ul class="nav navbar-nav">
            <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Profil</a>
             <ul class="dropdown-menu">
              <?php
              $this->load->model('profil/profil_model');
              $profil = $this->profil_model->find_all_by('kategori_informasi','Profil DKP');
              foreach($profil as $atk){ ?>
              <li><a href="<?= base_url('home/profil/'.$atk->id_informasi) ?>"><?= $atk->judul_informasi ?></a></li>
              <?php } ?>
             </ul>
            </li>
            <li><a href="<?= base_url('home/gis') ?>" >Peta TPS</a></li>
            <!--li class="hidden-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="list-btn"><i class="fa fa-list white"></i>&nbsp;&nbsp;POI List</a></li-->
          </ul>
          <ul class="nav navbar-nav navbar-right">
           <?php if (empty($current_user)) : ?>
           <li><a href="<?php echo site_url(LOGIN_URL); ?>" class="navbar-link">Login</a></li>
           <?php else : ?>
           <li <?php echo check_method('profile'); ?>><a href="<?php echo site_url('users/profile'); ?>"><?php e(lang('bf_user_settings')); ?></a></li>
           <li><a href="<?php echo site_url('logout'); ?>"><?php e(lang('bf_action_logout')); ?></a></li>
           <?php endif; ?>
           </ul>
          </div>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>