<div>
  <?php echo $output; ?>
</div>

<?php foreach($js_files as $file): ?>
    <script defer src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
