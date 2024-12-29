<?php include(APPPATH . 'Views/Components/headers.php');?>

<body>
<div class="container">
    <?php include(APPPATH . 'Views/Components/NavBar.php');?>
    

    <div> <?php include(APPPATH . 'Views/Components/Carrousel.php'); ?> </div>
    <div style="display:flex; gap:50px; flex-wrap:wrap; align-items: center; justify-content: center;  ">  <iframe  src="https://www.youtube.com/embed/Nb14JRM0DNs?si=y5f8EgkhL7faAEhu" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div > <?php include(APPPATH . 'Views/Components/Card.php'); ?> </div></div>
  

    <div> <?php include(APPPATH . 'Views/Components/toast.php'); ?> </div>
    <div> <?php include(APPPATH . 'Views/Components/footer.php'); ?> </div>

</div>
</body>
</html>
