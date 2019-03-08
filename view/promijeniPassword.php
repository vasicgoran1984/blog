<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php include('topContainer.php'); ?>
        <form class="prijava-korisnika" action="<?php BASE_URL; ?>index.php?controller=login&operation=promijeniPassword" method="post">
            <input type="hidden" name="promijeni_password" value="1">
            <div class="container">
                <h3>PROMIJENI PASSWORD</h3>
                <?php if(isset($greske)) : ?>
                        <?php echo '<p>' . $greske .'<p/>'.'<br/>'; ?>
                <?php endif; ?>
                <hr class="prijava_korisnika_hr">
                <label class="label-korisnicko_ime" for="korisnicko_ime"><h6>KORISNICKO IME</h6></label>
                <input type="text" placeholder="Korisnicko ime..." name="korisnicko_ime" value="<?php echo (isset($korisnicko_ime)) ? $korisnicko_ime : ''; ?>" required>

                <label class="label_password" for="stari password"><h6>STARI PASSWORD</h6></label>
                <input type="password" placeholder="Password..." name="stari_password" required>
                
                <hr class="promijeni_password_hr">
                <label class="label_password" for="password"><h6>NOVI PASSWORD</h6></label>
                <input type="password" placeholder="Password..." name="novi_password" required>
                
                <label for="potvrda_passworda"><h6>POTVRDA PASSWORDA</h6></label>
                <input type="password" placeholder="Potvrda passworda..." name="password_potvrda" required>
                
                <button type="submit" class="prijava-btn">PROMIJENI PASSWORD</button>
            </div>
        </form> 
    </body>
</html>
    
    