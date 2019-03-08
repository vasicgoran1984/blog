<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php include('topContainer.php'); ?>
        <form class="prijava-korisnika" action="<?php BASE_URL; ?>index.php?controller=login&operation=logovanje" method="post">
            <input type="hidden" name="login" value="1">
            <div class="container">
                <h3>LOGIN</h3>
                <div class="komentari_greske">
                <?php if(isset($greske)) : ?>
                    <?php foreach($greske as $jednaGreska) : ?>
                            <?php echo '<p>' . $jednaGreska .'<p/>'.'<br/>'; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>
                <hr class="prijava-korisnika-hr">
                <label class="label-korisnicko-ime" for="email"><h6>KORISNICKO IME</h6></label>
                <input type="text" placeholder="Korisnicko ime..." name="korisnicko_ime" required>

                <label class="label-password" for="password"><h6>PASSWORD</h6></label>
                <input type="password" placeholder="Password..." name="password" required>
                <button type="submit" class="prijava-btn">LOGIN</button>
                <a class="promijeni_password" href="<?php echo BASE_URL; ?>index.php?controller=login&operation=promijeniPassword">Promijeni Password</a>
            </div>

        </form> 
    </body>
</html>
    
    