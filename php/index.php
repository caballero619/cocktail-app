<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Cocktails</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="container py-3">
    <header>
      <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis">Search Cocktails</h1>
        <div class="col-lg-6 mx-auto">
            <form class="d-flex"><input name="search" class="form-control me-2" type="search" placeholder="Type here" aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
      </div>
      </header>
      <main>
      <div class="row row-cols-1 row-cols-md-4 mb-3">
      <?php
        $primary_url = "https://www.thecocktaildb.com/api/json/v1/1/";
        $search = $_GET['search'];
        $param = array(
          's' => $search ?: "margarita"
        );
        // search
        $url = $primary_url . "/search.php?" . http_build_query($param);

        $curl = curl_init();
        curl_setopt_array( $curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              "cache-control: no-cache"
            ),
        ));

        $response = curl_exec( $curl );
        $err = curl_error( $curl );
        curl_close( $curl );

        $data = json_decode( $response, true );
        foreach($data['drinks'] as $drink):?>
        <div class="col" data-bs-toggle="modal" data-bs-target="#drink<?php echo $drink['idDrink']; ?>">
          <div class="card mb-3">
            <img src="<?php echo $drink['strDrinkThumb']; ?>" class="card-img-top" alt="<?php echo $drink['strDrink']; ?>"/>
            <div class="card-body">
                <h5 class="card-title"><?php echo $drink['strDrink']; ?></h5>
                <a href="#" class="card-link" data-bs-toggle="modal" data-bs-target="#drink<?php echo $drink['idDrink']; ?>">View Drink</a>
            </div>
          </div>
        </div>
        <div class="modal fade" id="<?php echo "drink" . $drink['idDrink']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $drink['strDrink']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-2 text-end" style="font-size: 10px; text-transform: uppercase;">
                  Available language: 
                  <?php
                  $instructions = "";
                  $lang_arr = array("", "ES", "DE", "FR", "IT", "ZH-HANS", "ZH-HANT");
                  $inst_class = "";
                  foreach ($lang_arr as $lang):
                    if(!empty($drink["strInstructions".$lang])):
                    $instructions .= "<p class='instructions ". $inst_class .  "' data-lang='" .( ($lang) ?: "EN") . "'>" . $drink["strInstructions".$lang] . "</p>"; ?>
                  <a href="#" class="lang-toggle" data-id="<?php echo $drink['idDrink'];?>" data-lang="<?php echo ($lang) ?: "EN"; ?>"><?php echo ($lang) ?: "EN"; ?></a>
                  <?php $inst_class = "visually-hidden"; endif; endforeach;?>
                </div>
                <p><?php echo $instructions;?></p>
                <p>Serve: <?php echo $drink['strGlass']; ?></p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><i>Ingredients</i></li>
                <?php
                $ctr = 1;
                $ingredient = "strIngredient";
                $measurement = "strMeasure";
                while(!empty($drink[$ingredient . $ctr])):
                ?>
                <li class="list-group-item"><?php echo $drink[$measurement . $ctr] . " " . $drink[$ingredient . $ctr]; ?></li>
                <?php $ctr++; ?>
                <?php endwhile; ?>  
              </ul>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </main>
</div>
</body>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
