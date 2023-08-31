<?php
    include('database.php')
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Database Project</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
  </head>

  <body class="bg-light">

    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Joe's Vet</a>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Tables <span class="sr-only">(current)</span></a>
          </li>
          
        </ul>
        
      </div>
    </nav>

    <div class="nav-scroller bg-white box-shadow">
      <nav class="nav nav-underline">
        <a class="nav-link active" href="#">Dashboard</a>
        <a class="nav-link" href="#">
          Friends
          <span class="badge badge-pill bg-light align-text-bottom">27</span>
        </a>
        <a class="nav-link" href="#">Explore</a>
        <a class="nav-link" href="#">Suggestions</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
      </nav>
    </div>

    <main role="main" class="container my-4">
      <ul>
        <li>
          <div class="h2">Relationships</div>
          <img class="card-img-right flex-auto d-none d-md-block py-4" src="Resources/relationship_diagram.png" alt="Relationships">
        </li>
        <li class="h2">
          <div> Users</div>
          <img class="card-img-right flex-auto d-none d-md-block py-4" src="Resources/users_diagram.png" alt="Users">
        </li>
        <li>
          <div class="h2">Privileges</div>
          <img class="card-img-right flex-auto d-none d-md-block py-4" src="Resources/previleges_diagram.png" alt="Privileges">
        </li>
        <li>
          <div class="h2">Tables</div>
          <ol>
          <?php
            $tables = array("Customer", "Pets", "Staff", "Appointment", "Diagnosis_Medication", "Bill", "Payment");
            for($i = 0; $i < count($tables); $i++){
              echo "<li class='h4'>" . $tables[$i] . "</li>";
              $query = "SELECT * FROM " . $tables[$i];

              $result_set = mysqli_query($db, $query);

              echo '
              <table class="table table-striped table-sm">
              <thead>
                <tr>';

              $isPix = -1;
              for($j = 0; $j < mysqli_num_fields($result_set); $j++){
       //         echo "" . $field_info = $result_set->fetch_field()->name;
                
                  $column_name = $field_info = $result_set->fetch_field()->name;
                  if($column_name == 'picture'){
                    $isPix = $j;
                  }
                  echo "<th>" . $column_name . "</th>";
              }
                echo '</tr>
              </thead>
              ';
              echo '<tbody>';
              while($row = $result_set->fetch_array()){
                echo '<tr>';
                for($j = 0; $j < mysqli_num_fields($result_set); $j++){
                  if($isPix != $j){
                    echo '<td>' . $row[$j] . '</td>';
                  } else {
                    echo '<td><img style="max-width: 100%; height: auto" src="data:image/jpeg;base64, ' . base64_encode($row[$j]). '"/></td>';
                  }
     //             echo "<th>" . $field_info = $result_set->fetch_field()->name . "</th>";
                }
                echo '</tr>';
              }
              echo '</tbody>';
/*                <tbody>
                  <tr>
                    <td>1,001</td>
                    <td>Lorem</td>
                    <td>ipsum</td>
                    <td>dolor</td>
                    <td>sit</td>
                  </tr>
                  <tr>
                    <td>1,002</td>
                    <td>amet</td>
                    <td>consectetur</td>
                    <td>adipiscing</td>
                    <td>elit</td>
                  </tr>
                </tbody>
              </table>
*/           echo '</table>';   
            }

          ?>
          </ol>
        </li>
        <li>
          <div class="h2">Queries</div>
          <ul>
            <li>
              <?php
              $columns = array('Name', 'Pet', 'Picture', 'Diagnosis', 'Amount');
              $query = "SELECT C.Name, P.pet_id, P.picture, D.diagnosis, PA.amount, PA.payment
                        FROM Payment AS PA INNER JOIN Bill AS B ON PA.bill_id = B.bill_id 
                        INNER JOIN Diagnosis_Medication AS D ON B.diag_id = D.diag_id 
                        INNER JOIN Appointment AS A ON D.app_id = A.app_id
                        INNER JOIN Pets AS P ON A.pet_id = P.pet_id
                        INNER JOIN Customer AS C ON P.cust_id = C.cust_id
                        WHERE PA.payment = 'REVOLUT';
                        ";
              ?>
              <span clas="my-3 py -3">
                  Query list of all payments done with revolut for dogs. 
              </span>
              <div class="bg-secondary my-4 p-3">
                <?php echo $query; ?>
              </div>
              <div class="my-4">
                <table class="table table-striped table-sm my-4">
                  <thead>
                    <tr>
                    <?php
                      for($i = 0; $i < count($columns); $i++){
                        echo '<td>' . $columns[$i] . '</td>';
                      }
                    ?>
                  <tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                        $result_set = mysqli_query($db, $query);
                        while($row = $result_set->fetch_array()){
                          echo '<tr>';
                          for($j = 0; $j < mysqli_num_fields($result_set); $j++){
                            echo '<td>';
                            if($j != 2){
                              echo $row[$j];
                            } else {
                                echo '<img style="max-width: 100%; height: auto" src="data:image/jpeg;base64, ' . base64_encode($row[$j]). '"/>';;
                            }
                            echo '</td>';
                          }
                          echo '</tr>';
                        }
                      ?>
                  </tr>
                  </tbody>
                </table>
              </div>
            </li>
            <li>
              <?php
                $columns = array('Pet Id', 'Appointment ID', 'Diagnosis', 'Medication');
                $query = "SELECT P.pet_id, A.app_id, D.diagnosis, D.medication
                          FROM Diagnosis_Medication AS D INNER JOIN Appointment AS A ON D.app_id = A.app_id
                          INNER JOIN Pets AS P ON A.pet_id = P.pet_id
                          WHERE D.medication = 'aspirin';
                          ";
                ?>
              <span clas="my-3 py -3">
                  Query list of all animals taking Aspirin. 
              </span>
              <div class="bg-secondary my-4 p-3">
                <?php echo $query; ?>
              </div>
              <div class="my-4">
                <table class="table table-striped table-sm my-4">
                  <thead>
                    <tr>
                    <?php
                      for($i = 0; $i < count($columns); $i++){
                        echo '<td>' . $columns[$i] . '</td>';
                      }
                    ?>
                  <tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                        $result_set = mysqli_query($db, $query);
                        while($row = $result_set->fetch_array()){
                          echo '<tr>';
                          for($j = 0; $j < mysqli_num_fields($result_set); $j++){
                            echo '<td>';
                            
                              echo $row[$j];
                            
                            echo '</td>';
                          }
                          echo '</tr>';
                        }
                      ?>
                  </tr>
                  </tbody>
                </table>
              </div>            
            </li>
            <li>
              <?php
              $columns = array('Picture', 'Name', 'Address', 'Total');
              $query = "SELECT C.picture, C.name, C.address, SUM(PA.amount)
                        FROM Payment AS PA INNER JOIN Bill AS B ON PA.bill_id = B.bill_id
                        INNER JOIN Diagnosis_Medication AS D ON D.diag_id = B.diag_id
                        INNER JOIN Appointment AS A ON A.app_id = D.app_id
                        INNER JOIN Pets AS P ON A.pet_id = P.pet_id
                        INNER JOIN Customer AS C ON C.cust_id = P.cust_id
                        WHERE Year(PA.date) = 2022
                        GROUP BY C.cust_id;
                        ";
              ?>
              <span clas="my-3 py -3">
                  Query to get total amount each customer spent for the calendar year 2022 
              </span>
              <div class="bg-secondary my-4 p-3">
                <?php echo $query; ?>
              </div>
              <div class="my-4">
                <table class="table table-striped table-sm my-4">
                  <thead>
                    <tr>
                    <?php
                      for($i = 0; $i < count($columns); $i++){
                        echo '<td>' . $columns[$i] . '</td>';
                      }
                    ?>
                  <tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                        $result_set = mysqli_query($db, $query);
                        while($row = $result_set->fetch_array()){
                          echo '<tr>';
                          for($j = 0; $j < mysqli_num_fields($result_set); $j++){
                            echo '<td>';
                            if($j != 0){
                              echo $row[$j];
                            } else {
                                echo '<img style="max-width: 100%; height: auto" src="data:image/jpeg;base64, ' . base64_encode($row[$j]). '"/>';;
                            }
                            echo '</td>';
                          }
                          echo '</tr>';
                        }
                      ?>
                  </tr>
                  </tbody>
                </table>
              </div>
            </li>
            <li>
              <?php
              $columns = array('Picture', 'Pet_id', 'Date');
              $query = "SELECT P.picture, P.pet_id, A.date
                FROM Pets AS P INNER JOIN Appointment AS A ON P.pet_id = A.pet_id
                INNER JOIN Diagnosis_Medication AS D ON D.app_id = A.app_id
                INNER JOIN Staff AS S ON D.staff_id = S.staff_id
                WHERE S.name = 'Joe Odonell' AND P.animal = 'Cat';
              ";
              ?>
              <span clas="my-3 py -3">
                  Query to get list of all cats attended to by Joe Odonell
              </span>
              <div class="bg-secondary my-4 p-3">
                <?php echo $query; ?>
              </div>
              <div class="my-4">
                <table class="table table-striped table-sm my-4">
                  <thead>
                    <tr>
                    <?php
                      for($i = 0; $i < count($columns); $i++){
                        echo '<td>' . $columns[$i] . '</td>';
                      }
                    ?>
                  <tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                        $result_set = mysqli_query($db, $query);
                        while($row = $result_set->fetch_array()){
                          echo '<tr>';
                          for($j = 0; $j < mysqli_num_fields($result_set); $j++){
                            echo '<td>';
                            if($j != 0){
                              echo $row[$j];
                            } else {
                                echo '<img style="max-width: 100%; height: auto" src="data:image/jpeg;base64, ' . base64_encode($row[$j]). '"/>';;
                            }
                            echo '</td>';
                          }
                          echo '</tr>';
                        }
                      ?>
                  </tr>
                  </tbody>
                </table>
              </div>
            </li>
            <li>
              <?php
                $columns = array('Animal', 'Total');
                $query = "SELECT P.animal, SUM(PA.amount) FROM Payment AS PA 
                          INNER JOIN Bill AS B ON PA.bill_id = B.bill_id 
                          INNER JOIN Diagnosis_Medication AS D ON D.diag_id = B.diag_id 
                          INNER JOIN Appointment AS A ON A.app_id = D.app_id 
                          INNER JOIN Pets AS P ON A.pet_id = P.pet_id
                          GROUP BY P.animal;
                          ";
                ?>
              <span clas="my-3 py -3">
                  Query listing total amount spent on each type of animal 
              </span>
              <div class="bg-secondary my-4 p-3">
                <?php echo $query; ?>
              </div>
              <div class="my-4">
                <table class="table table-striped table-sm my-4">
                  <thead>
                    <tr>
                    <?php
                      for($i = 0; $i < count($columns); $i++){
                        echo '<td>' . $columns[$i] . '</td>';
                      }
                    ?>
                  <tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                        $result_set = mysqli_query($db, $query);
                        while($row = $result_set->fetch_array()){
                          echo '<tr>';
                          for($j = 0; $j < mysqli_num_fields($result_set); $j++){
                            echo '<td>';
                            
                              echo $row[$j];
                            
                            echo '</td>';
                          }
                          echo '</tr>';
                        }
                      ?>
                  </tr>
                  </tbody>
                </table>
              </div>            
            </li>
          </ul>
          
        </li>
      </ul>
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script src="offcanvas.js"></script>
  </body>
</html>