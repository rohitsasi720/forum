<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iForum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php 
    include 'partials/_dbconnect.php';
    include 'partials/_bg.php';
    include 'partials/_header.php';
    ?>

    <!-- carousel -->
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://source.unsplash.com/2400x605/?coding,code" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/2400x605/?programming,computer" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/2400x605/?hacking,code" class="d-block w-100" alt="...">
            </div>
        </div>
    </div>
    <!-- categories -->
    <div class="container my-2">
        <p class="text-center fw-normal display-5"
            style="color: #ADD8E6;  font-family: 'Serif';  text-shadow: 0 0 10px #000000;">
            Categories
        </p>
    </div>

    <div class="container my-3">
        <div class="row my-4">
            <?php
                  $sql = "SELECT * FROM `categories`";
                  $result = mysqli_query($conn,$sql);
                  while($row=mysqli_fetch_assoc($result)){
                  $cat = $row['category_name'];
                  $description = $row['category_description'];
                  $id= $row['category_id'];
                  echo '<div class=" col-md-3 my-2">
                  <div class="card" style="width: 18rem; border: none; outline: none; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); background-color: #144272;">
                    <img src="https://source.unsplash.com/400x300/?coding,'.$cat.'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fw-bold" style="color: #ADD8E6;">'.$cat.'</h5>
                        <p class="card-text" style="color: #ADD8E6;">'.substr($description,0,80).'...</p>
                        <a href="threadlist.php?catid='.$id.'" class="btn btn-primary" style="background-color: #ADD8E6; color: #003399;  box-shadow: 0px 0px 3px #ADD8E6;">Explore</a>
                    </div>
                        </div>   
                  </div>';
                }    
               ?>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <?php
     include 'partials/_footer.php';
     ?>
</body>

</html>