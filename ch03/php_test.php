<html>
  <head>
    <title>PHP Tests</title>
  </head>
  <body>
    <h1>PHP Version <?php print phpversion(); ?></h1>
    <p>Include path: <?php print get_include_path(); ?></p>
    <p>Installed extensions:</p>
    <ul>
      <li><?php print implode('</li><li>', get_loaded_extensions()); ?></li>
    </ul>
  </body>
</html>
