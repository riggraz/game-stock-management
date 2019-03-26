<!DOCTYPE html>

<html>
  <head>
    <title>Videogame stock</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
      if (isset($css_files))
      {
        foreach($css_files as $file): ?>
	        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach;
      }
      else
      { ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/themes/tablestrap/css/bootstrap.min.css'); ?>" />
      <?php } ?>

    <script defer src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
    <script defer src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
  </head>

  <body class="container-fluid">
    <nav class="navbar navbar-default" style="margin-top: 8px;">
      <div class="navbar-header">
        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url(''); ?>">
          <span style="font-size: 3rem;">Videogame stock</span>
        </a>
      </div>
      
      <?php if (isset($auth_role)) { ?>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav nav navbar-right">
          <li class="nav-item <?= $this->router->fetch_class() == 'products' ? 'active':''; ?>">
            <a class="nav-link" href="<?php echo base_url('products'); ?>">Products</a>
          </li>
          <?php if ($auth_role === 'admin') { ?>
          <li class="nav-item <?= $this->router->fetch_class() == 'users' ? 'active':''; ?>">
            <a class="nav-link" href="<?php echo base_url('users'); ?>">Manage users</a>
          </li>
          <?php } ?>
          <li class="dropdown <?= $this->router->fetch_class() == 'auth' ? 'active':''; ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <?php echo $auth_username; ?> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#">Edit your profile</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <?php } ?>
    </nav>