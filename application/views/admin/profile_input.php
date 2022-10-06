<form action="" method="POST">
    <input type="text" name="angka">
    <button type="submit" name="proses">Proses</button>
</form>

<?php
extract($_POST);
if(isset($proses))
{
    function faktorial ($n) {
        if($n == 1) {
            return $n;
        }else{
            return $n * faktorial ($n-1);
        }
    }

    for ($i=$angka; $i>=1 ; $i--) { 
        if ($i!=1) {
            echo $i. " x ";
        }else {
            echo $i;
        }
    }

    echo " = ".faktorial($angka);
}