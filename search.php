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


    <div class="container my-4">
        <div class="p-4 shadow-4 rounded-3" style="background-color: hsl(0, 0%, 94%);">
            <h2 class="display-5 mx-2">Search results for "<em class="text-primary"><?php echo $_GET['query'] ?></em>"
            </h2>
            <?php
            $query = $_GET['query'];
            $sql = "SELECT * FROM `threads` WHERE MATCH(thread_title,thread_desc) against ('$query')";
            $result = mysqli_query($conn,$sql);
            $noresults = true;
            while($row=mysqli_fetch_assoc($result)){
                $noresults=false;
               $title = $row['thread_title'];
               $desc = $row['thread_desc'];
               $thread_id = $row['thread_id'];
               $url = "thread.php?threadid=".$thread_id;
            echo ' 
            <div class="container my-4 mx-0">
            <a class="text-dark fs-5" href="'.$url.'">'.$title.'</a> </br>
            </div>';
            }
            if($noresults){
                echo'
                <h5 class="fst-italic text-secondary my-3">Sorry, no results were found. Check your spelling or try searching for something else.
            </h2>';
            }
            ?>
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