<!-- app/Views/dashboard/index.php -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(APPPATH . 'Views/Components/headers.php');?>
    <title>Intranet</title>
</head>
<body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php include(APPPATH . 'Views/Components/NavBar.php');?>

    <div> <?php include(APPPATH . 'Views/Components/Carrousel.php'); ?> </div>
    <div> <?php include(APPPATH . 'Views/Components/Card.php'); ?> </div>


    <div> <?php include(APPPATH . 'Views/Components/footer.php'); ?> </div>
</body>
</html>
