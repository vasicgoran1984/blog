<div class="top-container">
    <div class="top_container_content">
        <?php if(!isset($_SESSION['korisnik'])): ?>
            <a href="<?php echo BASE_URL;?>">Pocetna</a>
            <a class="top-container-registracija" href="<?php echo BASE_URL;?>registracija/registruj-korisnika">Registracija</a>
            <a class="top-container-login" href="<?php echo BASE_URL;?>login/logovanje">Login</a>
        <?php else : ?>
            <a href="<?php echo BASE_URL;?>login/logout">LogOut</a>
            <a href="<?php echo BASE_URL;?>">Pocetna</a>
            <a href="<?php echo BASE_URL;?>profil/moj-profil">Profil</a>
            <a href="<?php echo BASE_URL;?>clanci/moji-clanci">Moji Clanci</a>
    <?php endif; ?>
    </div>
</div>