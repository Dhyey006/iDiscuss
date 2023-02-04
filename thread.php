<!doctype html>
<html lang="eng">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-WJUUqfoMmnfkBLne5uxXj+na/c7sesSJ32gI7GfCk4zO4GthUKhSEGyvQ839BC51" crossorigin="anonymous">

    <title>Welcome to iDiscuss - Coding Forum</title>
    <style>
       #ques{
        min-height:433px; 
       } 
    </style>
</head>

<body>

    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <?php
                $id = $_GET['threadid'];
                $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result))
                {
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];
                    $thread_user_id = $row['thread_user_id'];

                    //QUery the users table to find out the name of original poster
                    $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    $posted_by = $row2['user_email'];
                }

    ?>

<?php
     $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    //echo $method;

    if($method=='POST')
    {
        //Insert into comments db
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", "$comment",);
        $comment = str_replace(">", "&gt;", "$comment",);
        $sno = $_POST['sno'];

        $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES (  '$comment', '$id', '$sno', current_timestamp());";
        $result = mysqli_query($conn,$sql);
        $showAlert = true;
        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added! 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }

    ?>


    <div class="container my-4">


        <div class="col-md-6">
            <div class="h-100 p-5 text-bg-dark rounded-3">
                <h2> <?php echo $title; ?> </h2>
                <p><?php echo $desc; ?></p>
                <hr class="my-4">
                <p>This is peer to peer forum for sharing knowledge with each other.</p>
                <p>Posted by :<b><?php echo $posted_by; ?></b></p>
            </div>

        </div>
    </div>
<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
{   
    echo ' <div class="container my-3">
        <h1 class="py-2">Post a Comment </h1>
        <form action="' .  $_SERVER['REQUEST_URI'] . '" method="post">
            
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">type your comment </label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="' . $_SESSION['sno'] . '">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
}
else
{
    echo '
    <div class="container">
    <h1 class="pu-2"> Start a Discussion</h1>
    <p class"lead"> You are not logged in, Please login to able to post comments. </p>
    </div>';
}
?>

    <div class="container " id="ques">
        <h1 class="py-2">Discussions </h1>
         <?php
                $id = $_GET['threadid'];
                $sql = "SELECT * FROM `comments` WHERE thread_id='$id'";
                $result = mysqli_query($conn, $sql);
                $noResult=true;
                while($row = mysqli_fetch_assoc($result))
                {
                    $noResult=false;
                    $id = $row['comment_id'];
                    $content = $row['comment_content'];
                    $comment_time = $row['comment_time'];
                    $thread_user_id = $row['comment_by']; 
                    $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    
                 



        echo '<div class="d-flex my-3">
            <img src="5.jpg" style="height:30px" class="mr-3" alt="...">
            <div class="media-body">
             <p class="font-weight-bold my-0">' . $row2['user_email'] . ' at ' . $comment_time . '</p>   
                ' . $content  . '
            </div>
        </div>';

    }
    if($noResult)
    {
        //echo var_dump($noResult);
        
        echo '<div class="h-50 p-5 text-bg-dark rounded-3">
                <h2> No Comments Found</h2>
                
                <hr class="my-4">
                <p>Be the first person to ask.</p>
                
            </div>';
    }

?>  
    <!-- Remove later; putting just to check html alignment for now -->
        <!-- <div class="d-flex my-3">
            <img src="5.jpg" style="height:30px" class="mr-3" alt="...">
            <div class="media-body">
                <h5 class="mt-0">Unable to install Pyaudio error in windows</h5>
                This is some content from a media component. You can replace this with any content and adjust it as
                needed.
            </div>
        </div> -->

</div>










    <?php include 'partials/_footer.php'; ?>




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    -->
</body>

</html>