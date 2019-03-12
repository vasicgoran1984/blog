    <!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <?php include('topContainer.php'); ?>
    <body>
        <div class="prikazi_autora">
            <span>Autor: <?php echo $prikaziAutora['ime'] . ' ' . $prikaziAutora['prezime'] ?></span><br/><br/>
            <div class="autor_slika">
                <img src="<?php echo BASE_URL.'/view/assets/images/korisnici/'. $prikaziAutora['slika_korisnika']; ?>"/>
            </div>
        </div>
        <?php if((isset($prikaziClanke))): ?>
        <?php foreach($prikaziClanke as $jedanClanak): ?>
        <div class="clanak_container">
            <div class="clanak_wrapper">
                <div class="clanak_wrapper_left">
                    <div class="naslov_clanka">
                    <h4><?php echo htmlspecialchars($jedanClanak['naslov_clanka']); ?></h4>
                    </div>
                    
                    <?php if($jedanClanak['naslovna_slika'] !== '') : ?>
                    <div class="slika_clanka">
                        <img src="<?php echo BASE_URL.'/view/assets/images/clanci/' . $jedanClanak['naslovna_slika'] ; ?>"/>
                    </div>
                    <?php endif; ?>
                    
                    <div class="kratki_tekst_datum">
                        <div class="kratki_tekst_clanka">
                            <span><?php echo htmlspecialchars($jedanClanak['kratki_tekst']); ?></span>
                        </div>
                        <div class="datum_objave_clanka">
                            <h5>Datum objave:</h5>
                            <span><?php echo htmlspecialchars($jedanClanak['datum_objave_clanka']); ?></span>
                        </div>
       
                    </div>
                    <div class="dugacki_tekst_clanka">
                        <span><?php echo htmlspecialchars($jedanClanak['dugacki_tekst']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </body>
</html>
