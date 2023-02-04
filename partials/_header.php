<?php
session_start();


echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum">Navbar</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        
        <ul class="dropdown-menu">';

        $sql = "SELECT category_name, category_id FROM `categories` LIMIT 3";
        $result = mysqli_query($conn, $sql); 
        while($row = mysqli_fetch_assoc($result)){
          echo '<a class="dropdown-item" href="threadlist.php?catid='. $row['category_id']. '">' . $row['category_name']. '</a>'; 
        } 

          
          echo '
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="contact.php">Contact </a>
      </li>
    </ul>
    
    <div class="container mx-2 ml-3">';
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
{
  echo  ' <form class="d-flex" role="search">
  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
  <button class="btn btn-success" type="submit">Search</button>
  <p class="text-light my-1 mx-2"> Welcome'.  $_SESSION['useremail'] . '</p>
  <a href="partials/_logout.php" class="btn btn-outline-success">Logout</a>
</form>';



}
else{
     echo ' <input class="form-control me-auto" type="search" placeholder="Search" aria-label="Search">
     <button class="btn btn-success" type="submit">Search</button>
    <button class="btn btn-outline-success"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';

    

  }
 echo ' </div>
</div>
</nav>';

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
{
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Login Success!</strong> You are now loggedin.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}


include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){


        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>L Success!</strong> Youcan now login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

?>