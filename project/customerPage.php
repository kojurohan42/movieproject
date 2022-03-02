<?php
if (!session_id()) {
  # code...
  session_start();
}
include 'db.php';
?>

<!DOCTYPE html>
<html>

<head>
  <link href="block.css" rel='stylesheet' type='text/css' />
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sen&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
  <link href="css/rotating-card.css" rel="stylesheet">
  <link href="css/astyle.css" rel="stylesheet">
  <link href="css/newstyle.css" rel="stylesheet">
</head>

<body>

  <?php
  if (!empty($_SESSION['msg'])) {
    echo "
    <p style='font-family: cursive; text-align: center; color: #5c865c; font-size: 2vw;'>" . $_SESSION['msg'] . "</p>
    ";
    $_SESSION['msg'] = "";
    $_SESSION['movieId'] = "";
  }
  ?>

  <div class="slideshow-container">

    <?php
    $count = 1;
    $res = $con->query("SELECT * FROM movielist");
    while ($row = $res->fetch_object()) {
      // $_SESSION['movie']=;
      echo " 
        <div class='mySlides'>
          <img src='img/" . $row->image2 . "' style='width:100%'>
          <div class='slideshow-item-text'>
            <div class='mov_desc' >
              <p class='desc'>
                <h1>$row->Name</h1>
                <br>
              </p>
            </div>
            <button class='slideshow-item-button' data-modal='modal" . $count . "'>
              <i class=' fas fa-play-circle'></i>&nbsp;WATCH
            </button>
            <div class='modal' id='modal" . $count . "'>
              <div class='modal-content'>
                <div class='modal-header'>
                  
                  <button class='modal-close' data-dismiss='modal" . $count . "'><i class='fas fa-times'></i></button>
                </div>
                <div class='modal-body'>
                  <iframe width='560' height='315' src='" . $row->trailerLink . "' title='YouTube video player' frameborder='0'
                  allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'allowfullscreen>
                  </iframe>
                </div>
              </div>
            </div>   
          </div>
        </div>
      ";
      $count++;
    }
    ?>

    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
    <script src="js/mySlide.js"></script>
    <script src="js/modal.js"></script>
  </div>
  <div class="panel with-nav-tabs panel-success">
    <div class="movie-list-title">now showing</div>
    <div class="movie-list-container">
      <div class="movie-list-wrapper">
        <div class="panel-body">
          <div class="tab-content">
            <div class="tab-pane fade in active" id="nowshowing">
              <?php
              $count = $count + 1;
              $res = $conn->query("SELECT * FROM movielist WHERE NAME IN (SELECT movieName FROM showorder GROUP BY movieName);");
              while ($row = $res->fetch_object()) {
                echo " 
                  <div class='col-md-3 col-sm-12'>
                    <div class='card-container'>
                      <div class='card'>
                        <div class='front'>
                          <div class='cover'>
                            <img src='image/" . $row->image . "'/> 
                          </div>
                        <div class='content'>
                          <div class='main'>
                            <h3 class='name' style='color:black;'>" . $row->Name . "</h3>
                            <p style='color:black;'><b>IMDB: </b>" . $row->imdb . "</p>

                            <p class='profession'><b>Genre: </b>" . $row->Genre . "</p>

                            <p class='profession'><b>Director: </b> " . $row->Director . "</p>
                          </div>
                        </div>
                      </div>
                      <!-- end front panel -->
                      <div class='back'>
                        <div class='content'>
                          <div class='main'>
                            <h4 class='text-center' style='color:black;'>" . $row->Name . "</h4>
                            <p class='text-center' style='color:black; font-size:15px;'>" . $row->Description . " </p>
                          </div>

                        <div class = 'movielist-item-text'>

                          <div style='margin-top: 10vw;' class='buy_ticket'>
                      

                            <form action='ticketProcessing.php' method='post' >
                              <input type='hidden' name='movieId' value='" . $row->movieId . "' >
                              <input type='submit'  class='movie-list-item-button-buy' type='submit' value='Buy Ticket' name='submit'>
                            </form>

                          </div>
                        </div>
                      </div> 
                      <!-- end card -->
                    </div>
                    <!-- end card-container -->
                  </div>
                </div>
              </div>
                ";
                $count++;
              }
              ?>





            </div>





          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="panel with-nav-tabs panel-success">
    <div class="movie-list-title">Coming soon</div>
    <div class="panel-body">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="Upcoming">

          <?php
          $count = $count + 1;
          $res = $conn->query("select * from movielist where Name Not in (select movieName from showorder group by movieName);");
          while ($row = $res->fetch_object()) {

            echo " 
              <div class='col-md-3 col-sm-12'>
                <div class='card-container'>
                  <div class='card'>
                    <div class='front' >
                      <div class='cover'>
                        <img src='image/" . $row->image . "'/> 
                      </div>
                      <div class='content'>
                        <div class='main' >
                          <h3 class='name' style='color:black;'>" . $row->Name . "</h3>

              <p style='color:black;'><b>IMDB: </b>" . $row->imdb . "</p>

              <p class='profession' ><b>Genre: </b>" . $row->Genre . "</p>

              <p class='profession'><b>Director: </b> " . $row->Director . "</p>
              

            </div>
          </div>
        </div>
        <!-- end front panel -->
        <div class='back'>
          <div class='content'>
            <div class='main'>
              <h4 class='text-center'>" . $row->Name . "</h4>
              <p class='text-center' style='color:black; font-size:15px;'>" . $row->Description . " </p>
            </div>



            <div style='margin-top: 10vw;' class='buy_ticket'>

             <form action='ticketProcessing.php' method='post' >
              <input type='hidden' name='movieId' value='" . $row->movieId . "' >
            </form>

          </div>
        </div>
      </div> <!-- end card -->
    </div> <!-- end card-container -->
  </div>
</div>";

            $count++;
          } ?>
        </div>
      </div>
    </div>
  </div>

  </div>

  </div>
  </div>
  <div id="bottom">
    <?php include 'footer.php'; ?>
  </div>
  <script src="js/movielistmodal.js"></script>
</body>

</html>