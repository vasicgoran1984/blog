<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php include('topContainer.php'); ?>
        <form class="registracija-korisnika" action="<?php echo BASE_URL; ?>registracija/registruj-korisnika" method="post">
            <input type="hidden" name="register" value="1">
            <div class="container">
                <h3>REGISTRACIJA</h3>
                <p>Popunite sva polja za registraciju.</p>
                <hr class="registracija-korisnika-hr">
                <div class="komentari_greske">
                    <?php if(isset($greske)) {
                        foreach($greske as $jednaGreska) {
                            echo $jednaGreska . '<br/>';
                        }
                    } ?>
                </div>
                <div class="registracija-container-1">
                    <label for="email"><h6>IME</h6></label>
                    <input type="text" placeholder="Ime" name="ime" value="<?php echo (isset($noviNiz['ime'])) ? $noviNiz['ime'] : ''; ?>">

                    <label for="email"><h6>PREZIME</h6></label>
                    <input type="text" placeholder="Prezime..." name="prezime" value="<?php echo (isset($noviNiz['prezime'])) ? $noviNiz['prezime'] : ''; ?>">

                    <label for="email"><h6>KORISNICKO IME</h6></label>
                    <input type="text" placeholder="Korisnicko ime..." name="korisnicko_ime" value="<?php echo (isset($noviNiz['korisnicko_ime'])) ? $noviNiz['korisnicko_ime'] : ''; ?>">
                </div>
                <div class="registracija-container-2">
                    <label for="email"><h6>EMAIL</h6></label>
                    <input type="text" placeholder="Email" name="email" value="<?php echo (isset($noviNiz['email'])) ? $noviNiz['email'] : ''; ?>">

                    <label for="password"><h6>PASSWORD</h6></label>
                    <input type="password" placeholder="Password..." name="password" value="<?php echo (isset($noviNiz['password'])) ? $noviNiz['password'] : ''; ?>">

                    <label for="potvrda-passworda"><h6>POTVRDA PASSWORDA</h6></label>
                    <input type="password" placeholder="Potvrda passworda..." name="password_potvrda" value="<?php echo (isset($noviNiz['password_potvrda'])) ? $noviNiz['password_potvrda'] : ''; ?>">
                </div>
                <button type="submit" class="registracija-btn">REGISTRACIJA</button>
            </div>
        </form> 
    </body>
</html>
