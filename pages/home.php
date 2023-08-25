<?php

$show_confirmation = False;

const HEART_SCALE = array(
  1 => '❤',
  2 => '❤ ❤',
  3 => '❤ ❤ ❤',
  4 => '❤ ❤ ❤ ❤',
  5 => '❤ ❤ ❤ ❤ ❤'
);

const WEATHER = array(
  "cold" => '❄️',
  "cooler" => '☁️',
  "warmer" => '🌤️',
  "hot" => '☀️',
  "any" => '❄️ ☁️ 🌤️ ☀️',

);

 $form_feedback_classes = array(
   'piece' => 'hidden',
   'category' => 'hidden',
   'weather' => 'hidden',
   'need' => 'hidden',
   'words' => 'hidden'
 );

$form_values = array(
  'piece' => '',
  'category' => '',
  'weather' => '',
  'need' => '',
  'words' => ''
);

$sticky_values = array(
  'piece' => '',
  'tops' => '',
  'bottoms' => '',
  'dress' => '',
  'shoes' => '',
  'outerwear' => '',
  'accessories' => '',
  'other' => '',
  'cold' => '',
  'cooler' => '',
  'warmer' => '',
  'hot' => '',
  'any' => '',
  'need' => '',
  'words' => ''
);

$insert_values = array(
  'piece' => NULL,
  'category' => NULL,
  'weather' => NULL,
  'need' => NULL,
  'words' => NULL
);

$form_valid = False;

if (isset($_POST["add-piece"])) {

  // getting user data
  $form_values['piece'] = trim($_POST['piece']); // untrusted
  $form_values['category'] = trim($_POST['category']); // untrusted
  $form_values['weather'] = trim($_POST['weather']); // untrusted
  $form_values['need'] = (int)$_POST['need']; // untrusted
  $form_values['words'] = trim($_POST['words']); // untrusted

  $form_valid = True;


  if ($form_values['piece'] == '') {
    // 7. Mark form as invalid.
    $form_valid = False;
    // 8. Show corrective feedback for $data.
    $form_feedback_classes['piece'] = '';
  }

  if ($form_values['category'] == '') {
    // 7. Mark form as invalid.
    $form_valid = False;
    // 8. Show corrective feedback for $data.
    $form_feedback_classes['category'] = '';
  }

  if ($form_values['weather'] == '') {
    // 7. Mark form as invalid.
    $form_valid = False;
    // 8. Show corrective feedback for $data.
    $form_feedback_classes['weather'] = '';
  }

  if ($form_values['need'] > 5 or $form_values['need'] < 1 or $form_values['need'] == '') {
    // 7. Mark form as invalid.
    $form_valid = False;
    // 8. Show corrective feedback for $data.
    $form_feedback_classes['need'] = '';
  }

  if ($form_valid) {
    // 10. Show confirmation.
    $show_confirmation = True;
  } else { // 11. Otherwise:
    // 12. Set sticky values and echo them.
    $sticky_values['piece'] = $form_values['piece'];
    $sticky_values['need'] = $form_values['need'];
    $sticky_values['words'] = $form_values['words'];
    $sticky_values['tops'] = ($form_values['category'] == "tops" ? 'selected' : '');
    $sticky_values['bottoms'] = ($form_values['category'] == "bottoms" ? 'selected' : '');
    $sticky_values['dress'] = ($form_values['category'] == "dress" ? 'selected' : '');
    $sticky_values['shoes'] = ($form_values['category'] == "shoes" ? 'selected' : '');
    $sticky_values['outerwear'] = ($form_values['category'] == "outerwear" ? 'selected' : '');
    $sticky_values['accessories'] = ($form_values['category'] == "accessories" ? 'selected' : '');
    $sticky_values['other'] = ($form_values['category'] == "other" ? 'selected' : '');
    $sticky_values['cold'] = ($form_values['weather'] == "cold" ? 'selected' : '');
    $sticky_values['cooler'] = ($form_values['weather'] == "cooler" ? 'selected' : '');
    $sticky_values['warmer'] = ($form_values['weather'] == "warmer" ? 'selected' : '');
    $sticky_values['hot'] = ($form_values['weather'] == "hot" ? 'selected' : '');
    $sticky_values['any'] = ($form_values['weather'] == "any" ? 'selected' : '');

  }
}

$db = open_sqlite_db('secure/site.sqlite');

if ($form_valid) {

  $insert_values['piece'] = ($_POST['piece'] == '' ? NULL : $_POST['piece']); // untrusted
  $insert_values['category'] = ($_POST['category'] == '' ? NULL : $_POST['category']); // untrusted
  $insert_values['weather'] = ($_POST['weather'] == '' ? NULL : $_POST['weather']); // untrusted
  $insert_values['need'] = ($_POST['need'] == '' ? NULL : (int)$_POST['need']); // untrusted
  $insert_values['words'] = ($_POST['words'] == '' ? NULL : $_POST['words']); // untrusted


  $result = exec_sql_query(
    $db,
    "INSERT INTO pieces (piece, category, weather, need, words) VALUES (:piece, :category, :weather, :need, :words);",
    array(
      ':piece' => $insert_values['piece'], // tainted
      ':category' => $insert_values['category'], // tainted
      ':weather' => $insert_values['weather'], // tainted
      ':need' => $insert_values['need'], // tainted
      ':words' => $insert_values['words']
    )
  );
}

$result = exec_sql_query($db, 'SELECT * FROM pieces');

$records = $result->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="public/styles/site.css" />
  <title>Capsulette.</title>
</head>

<body>

<header>
      <!-- Source: https://www.pngitem.com/middle/TbJihR_silhouette-high-heel-png-transparent-png/ -->
      <img class="logo" src="public/images/heel.png" alt="Logo"/>
    <h1>Capsulette.</h1>
</header>

<main>

  <div class="top">
  <div class="intro">
  <h2>Welcome fashionistas!</h2>

  <p>Are you looking for inspiration for a classic, timeless wardrobe? Are you tired of just buying the latest fashion trends, and not feeling like you have your own personal style? Look no further! This site will give you all the information you need to create your staple pieces in your wardrobe. Whether you are looking to start over, or have a foundation to build upon, feel free to take inspiration and submit your own pieces to appear below! We have also provided some key words to search up on popular second-hand clothing platforms such as <a href="https://poshmark.com/">Poshmark</a> or <a href="https://www.depop.com/">Depop</a> so we can stay sustainable! Enjoy :).</p>

  </div>



  <?php  if ($show_confirmation) { ?>
    <div class="intro" id="form-box">

    <h2>Piece Input Confirmation</h2>

    <p>Thanks for submitting your piece - you should see it below!</p>

    <p><a href="/">Submit another piece</a></p>
    </div>

  <?php } else { ?>

  <div class="intro" id="form-box">

  <h2>Add your pieces here!</h2>
   <p>Are there classic pieces you think should be added below? Fill out this form!</p>


   <form id="request-form" action="/" method="post" novalidate>

    <?php  if ($form_feedback_classes['piece'] == '') { ?>

    <p class="feedback <?php echo $form_feedback_classes['piece']; ?>">Please provide your piece's name!</p>

    <?php } ?>

    <div class="form-label">
      <label for="request-piece">Item Name: </label>
      <input type="text" name="piece" id="request-piece" value="<?php echo $sticky_values['piece']; ?>"/>
    </div>

    <?php  if ($form_feedback_classes['category'] == '') { ?>

    <p class="feedback" >Please provide your piece's category!</p>

    <?php } ?>

    <div class="form-label">
      <label for="request-category">Category: </label>
      <select id="request-category" name="category">
        <option value="tops" <?php echo $sticky_values['tops']; ?>>Tops</option>
        <option value="bottoms" <?php echo $sticky_values['bottoms']; ?>>Bottoms</option>
        <option value="dress" <?php echo $sticky_values['dress']; ?>>Dresses/Jumpsuits</option>
        <option value="shoes" <?php echo $sticky_values['shoes']; ?>>Shoes</option>
        <option value="outerwear" <?php echo $sticky_values['outerwear']; ?>>Outerwear</option>
        <option value="accessories" <?php echo $sticky_values['accessories']; ?>>Accessories</option>
        <option value="other" <?php echo $sticky_values['other']; ?>>Other</option>
      </select>
    </div>

    <?php  if ($form_feedback_classes['weather'] == '') { ?>

    <p class="feedback">Please provide the best weather conditions for your piece!</p>

    <?php } ?>

    <div class="form-label">
      <label for="request-weather">What weather is this piece best for? </label>
      <select id="request-weather" name="weather">
        <option value="cold" <?php echo $sticky_values['cold']; ?>>cold</option>
        <option value="cooler" <?php echo $sticky_values['cooler']; ?>>cooler</option>
        <option value="warmer" <?php echo $sticky_values['warmer']; ?>>warmer</option>
        <option value="hot" <?php echo $sticky_values['hot']; ?>>hot</option>
        <option value="any" <?php echo $sticky_values['any']; ?>>any</option>
      </select>
    </div>


    <?php  if ($form_feedback_classes['need'] == '') { ?>

    <p class="feedback">Make sure your scale is between 1 and 5!</p>

    <?php } ?>

    <div class="form-label">
      <label for="request-need">On a scale from 1 to 5, how necessary is it? </label>
      <input type="number" name="need" id="request-need" value="<?php echo $sticky_values['need']; ?>"/>
    </div>

    <div class="form-label">
      <label for="request-words">Key words for platform search: </label>
      <input type="text" name="words" id="request-words" value="<?php echo $sticky_values['words']; ?>"/>
    </div>

    <div class="form-label">
          <input id="add-piece" name="add-piece" type="submit" value="Add piece!" />
    </div>

   </form>

    </div>
    <?php } ?>
    </div>


  <div class="category_box">
    <h3 class="category">Item</h3>
    <h3 class="category">Category</h3>
    <h3 class="category">What weather is this piece best for?</h3>
    <h3 class="category">On a scale from 1 to 5, how bad do you need it?</h3>
    <h3 class="category">Key words for platforms</h3>
  </div>


  <?php
  foreach ($records as $record) { ?>
  <div class="box">
    <h4 class="item"><?php echo htmlspecialchars($record["piece"]); ?></h4>
    <p class="item"><?php echo htmlspecialchars($record["category"]); ?></p>
    <p class="item"><?php echo htmlspecialchars(WEATHER[$record["weather"] ]); ?></p>
    <p class="item"><?php echo htmlspecialchars(HEART_SCALE[$record["need"] ]); ?></p>
    <p class="item"><?php echo htmlspecialchars($record["words"]); ?></p>
  </div>
  <?php } ?>



</main>

</body>

</html>
