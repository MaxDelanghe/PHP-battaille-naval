<?php class Game
{
  public $grille = null;
  public $grille_p1 = null;
  public $grille_p2 = null;
  public $size_Y = null;
  public $size_X = null;
  public $string_first = null;
  public $actual_id = 2;

  public function __construct() {
  }

  public function colle($x, $y, $coords){
    if ($x <= 0 || $y <= 0) {
      exit;
    }
    else {
      $this->size_Y = $y;
      $this->size_X = $x;
      $stingX = '+';
      $sting_case = '';
      $array_grid = array();
      for ($i=0; $i <= $x ; $i++) {
        $stingX .= "–––+";
  //      $sting_case .= "   |";
      }
      $this->string_first = $stingX;
      for ($i=0; $i <= $y; $i++) {
        $array_grid[$i] = array();
        for ($popy=0; $popy <= $x; $popy++) {
          if ($popy == 0) {
            $array_grid[$i][$popy] = "|   |";
          }
          else {
            $array_grid[$i][$popy] = "   |";
          }
        }
      }
    //  $array_grid[0][2] =" X |";

      foreach ($coords as $value) {
        if ((is_array($value))) {
          if (isset($value[0]) && is_numeric($value[0]) && $value[0] <= $x && $value[0] >= 0 && isset($value[1]) && is_numeric($value[1]) && $value[1] <= $y && $value[1] >= 0)
          {
            if ($value[0] == 0) {
              $array_grid[$value[1]][$value[0]] ="| X |";
            }
            else {
              $array_grid[$value[1]][$value[0]] =" X |";
            }
          }
        }
      }
      echo "$stingX\n";
      foreach ($array_grid as $value) {
        foreach ($value as $case) {
          echo $case;
        }
        echo "\n$stingX\n";
      }
    }
    $this->grille_p1 = $array_grid;
    $this->grille_p2 = $array_grid;
  }

  public function check($x, $y) {
    if ($x == 0) {
      if ((strpos($this->grille[$y][$x] , '| X') === 0) ) {
        echo "\nfull\n";
        return 'ok';
      }
      else{
        echo "\nempty\n";
        return false;
      }
    }
    else {
      if ((strpos($this->grille[$y][$x] , ' X') === 0) ) {
        echo "\nfull\n";
        return 'ok';
      }
      else{
        echo "\nempty\n";
        return false;
      }
    }
  }

  public function adding($x, $y) {
    if (strpos($this->grille[$y][$x] , 'X') !== false) {
      echo "\nA cross already exists atthis location\n";
      return false;
    }
    else{
      if ($x == 0) {
        $this->grille[$y][$x] = "| X |";
      }
      else {
        $this->grille[$y][$x] = " X |";
      }
      return 'ok';
    }
  }

  public function remove($x, $y) {
    if ($x == 0) {
      if ((strpos($this->grille[$y][$x] , '| X') === 0) ) {
        $this->grille[$y][$x] = "|   |";
      }
      else{
        echo "\nNo cross exists at thislocation\n";
      }
    }
    else {
      if ((strpos($this->grille[$x][$y] , ' X') === 0) ) {
        $this->grille[$y][$x] = "   |";
      }
      else{
        echo "\nNo cross exists at thislocation\n";
      }
    }
  }


  public function display() {
    echo $this->string_first."\n";
    foreach ($this->grille as $value) {
      foreach ($value as $case) {
        echo $case;
      }
      echo "\n$this->string_first\n";
    }

  }


  public function commande() {
    $cmd = false;
    do {
      $line = readline(">");
      if (strpos($line, 'q') === 0) {
      //if (strpos($line, 'query [') === 0) {
        preg_match_all('!\d+!', $line, $matches);
        if ( isset($matches[0][0]) && isset($matches[0][1])) { //// TODO: le cas 00 est pas verif
          if ( $matches[0][0] >= 0 && $matches[0][1] >= 0 && $matches[0][0] <= $this->size_X && $matches[0][1] <= $this->size_Y) {
              $this->check($matches[0][0], $matches[0][1]);
          }
          else {
            echo "Coordonee invalide\n";
          }
        }
        else {
          echo "Coordonee invalide\n";
        }

      }
      elseif(strpos($line, 'add') === 0) {
        preg_match_all('!\d+!', $line, $matches);
        if ( isset($matches[0][0]) && isset($matches[0][1])) { //// TODO: le cas 00 est pas verif
          if ( $matches[0][0] >= 0 && $matches[0][1] >= 0 && $matches[0][0] <= $this->size_X && $matches[0][1] <= $this->size_Y) {
              $result = $this->adding($matches[0][0], $matches[0][1]);
              if ($result == 'ok') {
                $cmd = true;
              }
          }
          else {
            echo "Coordonee invalide\n";
          }
        }
        else {
          echo "Coordonee invalide\n";
        }
      }
      elseif(strpos($line, 'display') === 0) {
        echo "\n";
        $this->display();
      }
      elseif(strpos($line, 'remove') === 0) {
        preg_match_all('!\d+!', $line, $matches);
        if ( isset($matches[0][0]) && isset($matches[0][1])) { //// TODO: le cas 00 est pas verif
          if ( $matches[0][0] >= 0 && $matches[0][1] >= 0 && $matches[0][0] <= $this->size_X && $matches[0][1] <= $this->size_Y) {
              $this->remove($matches[0][0], $matches[0][1]);
          }
          else {
            echo "Coordonee invalide\n";
          }
        }
        else {
          echo "Coordonee invalide\n";
        }
      }
    } while ($cmd == false);
    return;
  }

  public function ship_are_ok() {
    $ok = 0;
    for ($y=0; $y < $this->size_Y; $y++) {
      for ($x=0; $x <= $this->size_X; $x++) {
        if (strpos($this->grille[$y][$x] , 'X') !== false) {
          $ok++;
        }
      }
    }
    return $ok;
  }

  public function placing($id) {
    $continue = true;
    $this->actual_id = $id;
    if ($id == 1) {
      $this->grille = $this->grille_p1;
    }
    else {
      $this->grille = $this->grille_p2;
    }
    echo "Player $id, place your 2 ships :\n";
    do {
        $this->commande();
        $is_ok = $this->ship_are_ok();
        if ($is_ok == 2) {
           $continue = false;
           if ($id == 1) {
             $this->grille_p1 = $this->grille;
           }
           else {
             $this->grille_p2 = $this->grille;
           }
        }
    } while ($continue);
  }

  public function attack() {
    if ($this->actual_id == 1) {
      $id_openent = 1;
      $this->grille = $this->grille_p1;
      $this->actual_id = 2;
    }
    else {
      $id_openent = 2;
      $this->grille = $this->grille_p2;
      $this->actual_id = 1;
    }
    echo "Player $this->actual_id, launch your attack :\n";
    $line = readline(">");
    preg_match_all('!\d+!', $line, $matches);
    if ( $matches[0][0] >= 0 && $matches[0][1] >= 0 && $matches[0][0] <= $this->size_X && $matches[0][1] <= $this->size_Y) {
        $result = $this->check($matches[0][0], $matches[0][1]);
        if ($result == 'ok') {
          echo "Player $this->actual_id : you touched a boat of player $id_openent\n";
          $this->remove($matches[0][0], $matches[0][1]);
        }
        else {
          echo "Player $this->actual_id : you didn’t touch anything.\n";
        }
    }
    else {
      echo "Player $this->actual_id : tir invalide tu perd ton tour\n";
    }
    if ($this->actual_id == 1) {
      $this->grille_p2 = $this->grille;
    }
    else {
      $this->grille_p1 = $this->grille;
    }
  }

  public function test_if_win() {
    $ok = $this->ship_are_ok();
    if ($ok == 0) {
      echo "Player $this->actual_id gg you win !\n";
      return false;
    }
    return true;
  }
}


$Game = new Game();
$Game->colle(3, 3, [[]]);
//$Game->colle(3, 3, [[0, 0],[0, 1]]);
$Game->placing(1);
$Game->placing(2);
$continue = true;
do {
  $Game->attack();
  $continue = $Game->test_if_win();
} while ($continue == true);


//$Game->commande(); game ??
