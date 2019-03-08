<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php include('topContainer.php'); ?>
         <h3>Profil</h3>
         <?php if($korisnik['slika_korisnika'] !== '') : ?>
            <form action="<?php BASE_URL; ?>index.php?controller=profil&operation=obrisiSliku" method="post">
               <button type="submit" class="">Obrisi Sliku</button>
            </form>
         <?php endif; ?>
         <div class="korisnikov_profil">
            <?php if($korisnik['slika_korisnika'] !== '') : ?>
                <div class="slika_korisinka">
                    <img src="<?php echo BASE_URL.'/view/assets/images/korisnici/'. $korisnik['slika_korisnika']; ?>"/>
                </div>
            <?php else : ?>
                <?php echo 'Molimo vas da dodate sliku.<br/>'; ?>
            <?php endif; ?>
            <?php
                echo '<span>Ime: ' . $korisnik['ime'] . '</span>' . '<br/>';
                echo '<span>Prezime: ' . $korisnik['prezime'] . '</span>' . '<br/>';
                echo '<span>Korisnicko: ' . $korisnik['korisnicko_ime'] . '</span>' . '<br/>';
                echo '<span>E-mail: ' . $korisnik['email'] . '</span>' . '<br/>';
            ?>
        </div>
        <div class="komentari_greske">
            <?php echo ((isset($_SESSION['greska']) && !empty($_SESSION['greska'])) ? $_SESSION['greska'] : ''); ?>
        </div>
         <br/>
        <form action="<?php BASE_URL; ?>index.php?controller=profil&operation=dodajSliku" method="post" enctype="multipart/form-data">
            <input type="hidden" name="image" value="1">
            Izaberite sliku:
            <input type="file" name="image" id="slika_korisnika">
            <input type="submit" value="Snimi sliku" name="submit">
        </form>
        <form class="edit_korisnika" action="<?php BASE_URL; ?>index.php?controller=profil&operation=editKorisnika" method="post">
             <input type="hidden" name="edit_korisnika" value="1">
            <div class="container"><hr>
            <p>Promijenite licne podatke.</p>
            <div class="komentari_greske">
                <?php if(isset($greske)) {
                    foreach($greske as $jednaGreska) {
                        echo $jednaGreska . '<br/>';
                    }
                } ?>
            </div>
                <label for="ime"><b>Ime:</b></label>
                <input type="text" placeholder="Enter First Name" name="ime" value="<?php echo (!empty($korisnik['ime']) ? $korisnik['ime'] : "");?>" required>

                <label for="prezime"><b>Prezime:</b></label>
                <input type="text" placeholder="Enter Last Name" name="prezime" value="<?php echo (!empty($korisnik['prezime']) ? $korisnik['prezime'] : "");?>" required>

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" value="<?php echo (!empty($korisnik['email']) ? $korisnik['email'] : ""); ?>" required>
                <hr>
                <button type="submit" class="registerbtn">Spremi</button>
            </div>
        </form>
    </body>
</html>