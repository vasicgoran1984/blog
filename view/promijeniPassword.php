<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php include('topContainer.php'); ?>
        <form class="prijava-korisnika" action="<?php echo BASE_URL; ?>login/promijeni-password" method="post">
            <input type="hidden" name="promijeni_password" value="1">
            <div class="container">
                <h3>PROMIJENI PASSWORD</h3>
                <div class="komentari_greske">
                    <?php if(isset($greske)) : ?>
                        <?php foreach($greske as $jednaGreska) : ?>
                                <?php echo $jednaGreska .'<br/>'; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <hr class="prijava_korisnika_hr">
                <label class="label-korisnicko_ime" for="korisnicko_ime"><h6>KORISNICKO IME</h6></label>
                <input type="text" placeholder="Korisnicko ime..." name="korisnicko_ime" value="<?php echo (isset($noviNiz['korisnicko_ime'])) ? $noviNiz['korisnicko_ime'] : ''; ?>">

                <label class="label_password" for="stari password"><h6>STARI PASSWORD</h6></label>
                <input type="password" placeholder="Password..." name="stari_password">
                
                <hr class="promijeni_password_hr">
                <label class="label_password" for="password"><h6>NOVI PASSWORD</h6></label>
                <input type="password" placeholder="Password..." name="novi_password">
                
                <label for="potvrda_passworda"><h6>POTVRDA PASSWORDA</h6></label>
                <input type="password" placeholder="Potvrda passworda..." name="password_potvrda">
                
                <button type="submit" class="prijava-btn">PROMIJENI PASSWORD</button>
            </div>
        </form> 
    </body>
</html>
    
    