<?php
session_start();
if (!isset($_SESSION['email'])) {
  echo "<script>window.location.replace('../html/index.html')</script>";
}

include("dbconnect.php");
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sqlloadsubject = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search%' ORDER BY subject_id ASC";
} 
else {
  $sqlloadsubject = "SELECT * FROM tbl_subjects";
}

$results_per_page = 10;
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
  $page_first_result = ($page - 1) * $results_per_page;
} else {
  $page = 1;
  $page_first_result = 0;
}

$page_first_result = ($page - 1) * $results_per_page;
$result = $conn->query($sqlloadsubject);
$number_of_result = $result->num_rows;
$totalPages = ceil($number_of_result / $results_per_page);
$sqlloadsubject = $sqlloadsubject . " LIMIT $page_first_result , $results_per_page";
$result = $conn->query($sqlloadsubject);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>MyTutor</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
</head>


  <header class="text-center">
    <nav id="MenuBar">
        <div class="list-group"  style="margin-top: 20px">
          <a href="home.php" class="list-group-item list-group-item-action py-4"><span>Courses</span>
          </a>
          <a href="tutor.php" class="list-group-item list-group-item-action py-4"><span>Tutor</span>
          </a>
          <a href="#" class="list-group-item list-group-item-action py-4"><span>Subscription</span></a>
          <a href="#" class="list-group-item list-group-item-action py-4"><span>Profile</span></a>
        </div>
    </nav>

  
    <form method="get" action="../php/home.php">
    <div class="input">
      <input type="text" class="form-control rounded" name="search" id="search" placeholder="Search here" aria-label="search" aria-describedby="search-addon">
      <button type="submit" class="btn btn-dark">Search
      </button>
    </div>
    </form>
    
    <nav id="NavBar" class="navbar navbar-expand-lg bg-black fixed-top card">
      <div class="container-fluid">
        <button class="navbar-toggler btn" type="button">
        </button>
        <a class="navbar-brand" style="height: 10px" href="#">
          <div style="margin-top: -15px"> <b style="color:white">MyTutor</b></div>
        </a>
      </div>
    </nav>
  </header>


  <main style="margin-top: 30px">
    <div class="container pt-1">
      <h2 class="text-center">Course List</h2>
      <?php
      while ($row = $result->fetch_assoc()) {
      ?>

        <div class="card mb-1">
            <div class="col-md-3">
              <img src="../assets/courses/<?php echo $row['subject_id']; ?>.png" class="card-img" alt="...">
            </div>
            <div class="col-md-10">
              <div class="card-body">
                <h5 class="card-title">
                  <?php echo $row['subject_name']; ?>
                </h5>
                <p class="card-text">
                  <?php echo $row['subject_description']; ?>
                </p>
                <p class="card-text">
                  <?php echo $row['subject_sessions']; ?> Sessions
                </p>
                <p class="card-text text-warning">
                  <?php echo $row['subject_rating']; ?>
                </p>
                <br>
                <p class="card-text text-success">RM
                  <?php echo $row['subject_price']; ?>
                </p>
                <br>
                
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#Modal">
                  Details
                </button>

                <!-- Modal -->
                <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                   <div class="modal-content">
                     <div class="modal-header">
                        <h6 class="modal-title" id="ModalLabel"><?php echo $row ['subject_name'];?>
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                     <div class="modal-body">
                        <p class="card-text">
                  <?php echo $row['subject_description']; ?>
                </p>
                <p class="card-text">
                  <?php echo $row['subject_sessions']; ?> Sessions
                </p>
                <p class="card-text text-warning">
                  <?php echo $row['subject_rating']; ?>
                </p>
                <br>
                <p class="card-text text-success">RM
                  <?php echo $row['subject_price']; ?>
                </p>
                <br>
                      </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      <?php
      }
      ?>
       <?php
    $num = 1;
    if ($page == 1) {
        $num = 1;
    } else if ($page == 2) {
        $num = ($num) + 10;
    } 
    else {
        $num = $page * 10 - 9;
    }
    echo "<div class='row'>";
    echo "<center>";
    for ($page = 1; $page <= $totalPages; $page++) {
        echo '<a href = "home.php?page=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp&nbsp' . $page .' </a>';
    }

    ?>
    </div>
  </main>

  <br><br>
    <footer class="bg-dark fixed-bottom text-center text-lg-start">
        <div class="text-center p-0.5">
            <p class="text-light" >MyTutor</p>
        </div>
    </footer>
</body>

</html>