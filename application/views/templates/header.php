<!DOCTYPE html>

<html>
  <head>
    <title>Videogame stock</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
    <script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>" defer></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>" defer></script>
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
            <a class="nav-link" href="#">Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('logout'); ?>">Logout</a>
          </li>
        </ul>
      </div>
    </nav>