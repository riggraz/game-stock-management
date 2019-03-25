<!DOCTYPE html>

<html>
  <head>
    <title>Videogame stock</title>

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
      <a class="navbar-brand" href="<?php echo base_url(''); ?>">
        <h1>Videogame stock</h1>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="navbarSupportedContent">
        <ul class="navbar-nav nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(''); ?>">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('users'); ?>">Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('logout'); ?>">Logout</a>
          </li>
        </ul>
      </div>
    </nav>