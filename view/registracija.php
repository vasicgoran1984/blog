<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php include('topContainer.php'); ?>
        <form class="registracija-korisnika" action="<?php BASE_URL; ?>index.php?controller=login&operation=registracija" method="post">
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
                    <input type="text" placeholder="Ime" name="ime" value="<?php echo (isset($ime)) ? $ime : ''; ?>" required>

                    <label for="email"><h6>PREZIME</h6></label>
                    <input type="text" placeholder="Prezime..." name="prezime" value="<?php echo (isset($prezime)) ? $prezime : ''; ?>" required>

                    <label for="email"><h6>KORISNICKO IME</h6></label>
                    <input type="text" placeholder="Korisnicko ime..." name="korisnicko_ime" value="<?php echo (isset($korisnicko_ime)) ? $korisnicko_ime : ''; ?>" required>
                </div>
                <div class="registracija-container-2">
                    <label for="email"><h6>EMAIL</h6></label>
                    <input type="text" placeholder="Email" name="email" value="<?php echo (isset($email)) ? $email : ''; ?>" required>

                    <label for="password"><h6>PASSWORD</h6></label>
                    <input type="password" placeholder="Password..." name="password" autocomplete="off" required>

                    <label for="potvrda-passworda"><h6>POTVRDA PASSWORDA</h6></label>
                    <input type="password" placeholder="Potvrda passworda..." name="password_potvrda" required>
                </div>
                <button type="submit" class="registracija-btn">REGISTRACIJA</button>
            </div>
        </form> 
    </body>
</html>
