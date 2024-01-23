<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(APPPATH . 'Views/Components/headers.php');?>

    <title>Intranet</title>
</head>
<body>
      <h2> Bienvenid@s a la Intranet de <?= session('establecimiento') ?> </h2>
    <nav>
        <?php include(APPPATH . 'Views/Components/NavBar.php');
?></nav>
    
      
<div> <?php include(APPPATH . 'Views/Components/Carrousel.php'); ?> </div>

<div> <?php include(APPPATH . 'Views/Components/footer.php'); ?> </div>

</body>
</html>