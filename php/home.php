<?php
include("dbconnect.php");
session_start();
if (!isset($_SESSION['email'])) {
  echo "<script>window.location.replace('../html/index.html')</script>";
}

$limit = 10;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$pageStart = ($page - 1) * $limit;
$sqlSubject = "SELECT * FROM tbl_subjects LIMIT $pageStart, $limit";
$stmt = $conn->prepare($sqlSubject);
$stmt->execute();
$result = $stmt->get_result();
$sql = $conn->query("SELECT count(subject_id) AS id FROM tbl_subjects")->fetch_assoc();
$allRecords = $sql['id'];
$totalPages = ceil($allRecords / $limit);
$prev = $page - 1;
$next = $page + 1;
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
                <p class="card-text text-muted">Subject Sessions :
                  <?php echo $row['subject_sessions']; ?>
                </p>
                <p class="card-text text-warning">
                  <?php echo $row['subject_rating']; ?>
                </p>
                <br>
                <p class="card-text text-success" style="bottom: 15px;">RM
                  <?php echo $row['subject_price']; ?>
                </p>

              </div>
            </div>
        </div>
      <?php
      }
      ?>
      <nav aria-label="Page navigation mt-10">
        <ul class="pagination justify-content-center">
          <li><a class="page-link" href="<?php if ($page <= 1) {
                                          echo '#';
                                        } else {
                                          echo " ?page=" . $prev;
                                        } ?>">Prev</a>
          </li>
          <?php for ($a = 1; $a <= $totalPages; $a++) : ?>
            <li><a class="page-link" href="home.php?page=<?= $a; ?>"><?= $a; ?></a>
            </li>
          <?php endfor; ?>
          <li><a class="page-link" href="<?php if ($page >= $totalPages) {
                                          echo '#';
                                        } else {
                                          echo " ?page=" . $next;
                                        } ?>">Next</a>
          </li>
        </ul>
      </nav>
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