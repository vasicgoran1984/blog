<div class="top-container">
    <div class="top_container_content">
        <?php if(!isset($_SESSION['korisnik'])): ?>
            <a href="<?php echo BASE_URL; ?>index.php?controller=index&operation=home">Pocetna</a>
            <a class="top-container-registracija" href="<?php echo BASE_URL; ?>index.php?controller=login&operation=registracija">Registracija</a>
            <a class="top-container-login" href="<?php echo BASE_URL; ?>index.php?controller=login&operation=logovanje">Login</a>
        <?php else : ?>
            <a href="<?php echo BASE_URL; ?>index.php?controller=login&operation=logout">LogOut</a>
            <a href="<?php echo BASE_URL; ?>index.php?controller=index&operation=home">Pocetna</a>
            <a href="<?php echo BASE_URL; ?>index.php?controller=profil&operation=editKorisnika">Profil</a>
            <a href="<?php echo BASE_URL; ?>index.php?controller=clanak&operation=stranicaClanak">Moji Clanci</a>
    <?php endif; ?>
    </div>
</div>