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
    <?php
     $id = $_GET['catid'];
     $sql = "SELECT * FROM `categories` WHERE category_id=$id";
     $result = mysqli_query($conn,$sql);
     while($row=mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
     }
    ?>
    <?php
    $showAlert=false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST' && ( $_POST['title']!=NULL && $_POST['desc']!=NULL) ){
        $th_title = $_POST['title'];
        $th_title = str_replace("<","&lt;",$th_title);
        $th_title = str_replace(">","&gt;",$th_title);
        $th_desc = $_POST['desc'];
        $th_desc = str_replace("<","&lt;",$th_desc);
        $th_desc = str_replace(">","&gt;",$th_desc);
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
     $result = mysqli_query($conn,$sql);
     $showAlert=true;
     if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your query has been added, kindly wait until someone starts the discussion 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
     }
    }
    ?>

    <div class="container my-4">
        <!-- Jumbotron -->
        <div class="p-4 shadow-4 rounded-3" style="background-color: hsl(0, 0%, 94%); border: none;
            outline: none; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); background-color: #144272;">
            <h2 style="color: #ADD8E6; text-shadow: 0 0 10px #000000;">Welcome to
                <?php echo $catname ;?> forums</h2>
            <p class="my-4" style="color: #ADD8E6;">
                <?php echo $catdesc;?>
            </p>
            <hr class=" my-3" />
            <p style="color: #ADD8E6;">
                Note : Keep it friendly, be courteous and respectful. Appreciate that others may have an opinion
                different from
                yours, stay on topic.
            </p>
        </div>
        <!-- Jumbotron -->
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container">
        <p class="my-4 display-5 text-center" style="color: #ADD8E6;">
            Ask your queries here &#11191;
        </p>
    </div>';  
    }
    ?>

    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container">
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapseOne">
                    Discussion Form
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        <div class="container">
                            <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                                <div class="mb-3 my-4">
                                    <label for="title" class="form-label">Problem title</label>
                                    <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
                                        <div class="mb-3 my-3">
                                            <div class="form-floating">
                                                <textarea class="form-control" id="desc" name="desc" style="height: 150px"></textarea>
                                                <label for="desc">Comments</label>
                                                <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                                            </div>
                                        </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
    <style>
    .accordion-collapse {
        background-color: #f0f0f0;
    }
    </style>
    </div>
    </div>
    </div>';
    }
    else{
    echo '<div class="container card" style="background-color: hsl(0, 0%, 94%); border: none;
    outline: none; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); background-color: #144272;">
  <div class="container card-body">
    <p class="container text-center my-2 fs-4" style="color: #ADD8E6;">Please <em>login</em> to ask queries</p>
  </div>
</div>';
    }
    ?>

    <div class="container my-3 py-2">
        <h2 class="container my-3" style="color: #ADD8E6;">Browse Questions</h2>
        <?php
     $id = $_GET['catid'];
     $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
     $result = mysqli_query($conn,$sql);
     //echo mysqli_num_rows($result);
     $noResult=true;
     while($row=mysqli_fetch_assoc($result)){
        $noResult=false;
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $id = $row['thread_id'];
        echo '<div class="d-flex">
            <div class="flex-shrink-0 my-2">
                <img src="image/user.png" width="50px" alt="...">
            </div>
            <div class="flex-grow-1 ms-3 my-2">
            <a class="text-secondary" href="thread.php?threadid='.$id.'"><h6 class="mt-0" style="color: #ADD8E6;">'.$title.'</h6></a>
                <p style="color: #ADD8E6;">'.$desc.'</p>
            </div>
        </div>';
     }
     if($noResult){
        echo '<div class="p-4 shadow-4 rounded-3" style="background-color: hsl(0, 0%, 94%);">
            <h2>No threads found</h2>
            </div>';
     }
    ?>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <?php
     include 'partials/_footer.php';
     ?>
</body>

</html>