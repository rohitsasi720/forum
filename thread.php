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
    $showAlert=false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST' && ( $_POST['comment']!=NULL)){
        $id= $_GET['threadid'];
        $th_comment = $_POST['comment'];
        $th_comment = str_replace("<","&lt;",$th_comment);
        $th_comment = str_replace(">","&gt;",$th_comment);
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$th_comment', '$id', current_timestamp(), '$sno')";
     $result = mysqli_query($conn,$sql);
     $showAlert=true;
     if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your comment has been added successfully 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
     }
    }
    ?>

    <?php
     $id = $_GET['threadid'];
     $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
     $result = mysqli_query($conn,$sql);
     while($row=mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        
        $sql2 = "SELECT user_email FROM `users` WHERE sno=$thread_user_id";
        $result2 = mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $user_email = $row2['user_email'];
        
        echo '<div class="container my-4">
        <div class="p-4 shadow-4 rounded-3" style="background-color: hsl(0, 0%, 94%); border: none;
        outline: none; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); background-color: #144272;"">
            <h2 class="display-4" style="color: #ADD8E6; text-shadow: 0 0 10px #000000;">'.$title.'</h2>
    <p class="my-4 fs-5" style="color: #ADD8E6;">
        '.$desc.'
    </p>
    <div class="badge bg-secondary text-wrap text-capitalize py-1.5" style="width: 10rem; height: 1.75rem;">
    Posted by '.strstr($user_email,"@",true).'
</div>
    <hr class=" my-3" />
    <p style="color: #ADD8E6;">
        Note : Keep it friendly, be courteous and respectful. Appreciate that others may have an opinion
        different from
        yours, stay on topic.
    </p>
    </div>
    </div>';
    }
    ?>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<h5 class="container " style="color: #ADD8E6;">Type your comments here</h5>
        <div class="container">
            <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
    <div class="mb-3 my-1">
        <div class="mb-3 my-3">
            <div class="form-floating">
                <textarea class="form-control" id="comment" name="comment" style="height: 150px"></textarea>
                <label for="comment">Comments</label>
                <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
            </div>
        </div>
        <button type="submit" class="btn btn-success" style="background-color: #ADD8E6; color: #003399;  box-shadow: 0px 0px 3px #ADD8E6;">Comment</button>
    </div>
    </form>
    </div>';
    }
    else{
        echo '<div class="container card" style="background-color: hsl(0, 0%, 94%); border: none;
    outline: none; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); background-color: #144272;">
  <div class="container card-body">
    <p class="container text-center my-2 fs-4" style="color: #ADD8E6;">Please <em>login</em> to join the discussion</p>
  </div>
</div>';
    }
    ?>


    <div class="container my-3 py-2">
        <h2 class="container my-3" style="color: #ADD8E6;">Community Comments</h2>
        <?php
     $id = $_GET['threadid'];
     $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
     $result = mysqli_query($conn,$sql);
     //echo mysqli_num_rows($result);
     $noResult=true;
     while($row=mysqli_fetch_assoc($result)){
        $noResult=false;
        $content = $row['comment_content'];
        $id = $row['comment_id'];
        $comment_time = $row['comment_time'];
        $thread_user_id = $row['comment_by'];
        
        $sql2 = "SELECT user_email FROM `users` WHERE sno=$thread_user_id";
        $result2 = mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $user_email = $row2['user_email'];
        
        echo '<div class="d-flex my-2">
            <div class="flex-shrink-0 my-2">
                <img src="image/user.png" width="50px" alt="...">
            </div>
            <div class="flex-grow-1 ms-3 my-0">
            <p class="font-monospace fw-bold my-0 text-capitalize" style="color: #ADD8E6;">'.strstr($user_email,"@",true). '  📅 '.substr($comment_time,2,8).' / '.substr($comment_time,11,5).' </p>
                <p style="color: #ADD8E6;">'.$content.'</p>
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