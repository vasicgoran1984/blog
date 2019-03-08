<html>
    <?php include('header.php'); ?>
    <?php include('topContainer.php'); ?>
    <body>
        <div class="clanak_container">
            <div class="clanak_wrapper">
                <div class="clanak_wrapper_left">
                    <div class="naslov_clanka">
                    <h4><?php echo htmlspecialchars($rezultat['naslov_clanka']); ?></h4>
                    </div>
                    <?php if($rezultat['naslovna_slika'] !== '') : ?>
                    <div class="slika_clanka">
                        <img src="<?php echo BASE_URL.'/view/assets/images/clanci/' . $rezultat['naslovna_slika'] ; ?>"/>
                    </div>
                    <?php endif; ?>
                    
                    <div class="kratki_tekst_datum">
                        <div class="kratki_tekst_clanka">
                            <span><?php echo htmlspecialchars($rezultat['kratki_tekst']); ?></span>
                        </div>
                        <div class="datum_objave_clanka">
                            <span>Datum objave:</span>
                            <span><?php echo htmlspecialchars($rezultat['datum_objave_clanka']); ?></span>
                        </div>
                        <div class="pozitivan_negativan_utisak">
                            <div class="ostavi_utisak">
                                <br/>
                            </div>
                        </div>
                        <div class="ukupno_utisaka">
                            <div class="pozitivni">Pozitivni utisci: <?php echo '<span>' . $pozitivniUtisci . '</span>'; ?></div>
                            <div class="negativni">Pozitivni utisci: <?php echo '<span>' . $negativniUtisci . '</span>'; ?></div>
                            <a href="index.php?controller=clanak&operation=pogledajSveClanke&korisnik_id=<?php echo $rezultat['korisnik_id']; ?>">Pogledaj sve clanke</a>
                        </div>
                    </div>
                    <div class="dugacki_tekst_clanka">
                        <span><?php echo htmlspecialchars($rezultat['dugacki_tekst']); ?></span>
                    </div>
                    
                </div>
            </div>
            <div class="svi_komentari_container">
                <?php if (isset($procitajClanakSaKomentarima)): ?>
                    <?php foreach($procitajClanakSaKomentarima as $key => $jedanClanak): ?>
                    <div class="komentari_clanka">
                            <span class="kor_datum">Komentarisao <?php echo $jedanClanak['ime'] . ' ' . $jedanClanak['prezime'] . ' Datum ' . $jedanClanak['datum_objave_komentara'] . '<br/>';  ?></span><br/>
                            <span class="komentari_clanka_span"><?php echo $jedanClanak['komentar']; ?></span>
                            
                            <div class="reakcije_na_komentar">
                                <?php if((isset($_SESSION['korisnik'])) && (!($jedanClanak['korisnik_id'] == $_SESSION['korisnik'][0]))): ?>
                                    <form class="utisak_na_komentar"  method="post"> 

                                        <div class="komentar-utisak-plus">
                                            <input type="checkbox" komentar_id="<?php echo $jedanClanak['komentar_id']; ?>" class="checkbox-plus-komentar-utisak">
                                            <label class="css-label">
                                                <span class="fa fa-plus" komentar_id="<?php echo $jedanClanak['komentar_id']; ?>" style="background:<?php echo (!empty($jedanClanak['utisak']) && $jedanClanak['utisak'] == 1  ? "gray" : ""); ?>"></span>
                                            </label>
                                        </div>
                                        <div class="komentar-utisak-minus">
                                            <input type="checkbox" komentar_id="<?php echo $jedanClanak['komentar_id']; ?>" class="checkbox-minus-komentar-utisak">
                                            <label class="css-label">
                                                <span class="fa fa-minus" komentar_id="<?php echo $jedanClanak['komentar_id']; ?>" style="background:<?php echo (!empty($jedanClanak['utisak']) && $jedanClanak['utisak'] == 2  ? "gray" : ""); ?>"></span>
                                            </label>
                                        </div>  
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
            </div>
                    <?php endforeach; ?>
                    <div style="display: none;" class="novi_komentar_clanka"></div>
                <?php endif; ?>
            <div class="komentar_wrapper">
                <div class="komentari_greske"></div>
                <form class="komentarisi_clanak"  method="POST" > 
                    <div class="container">
                        
                        <label for="komentar clanka"><b>Komentar:</b></label><br/>
                        <textarea rows="4" cols="50" placeholder="Unesite komentar..." name="komentar"></textarea> <br/>
                        <br/>
                        <input type="button" value="Komentarisi" onclick="komentarisiClanak()" class="registerbtn">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<script>
function komentarisiClanak() {
    $.ajax({
        url: "<?php BASE_URL; ?>index.php?controller=komentar&operation=komentarisiClanak",
        type: 'POST',
        dataType: 'JSON'
    }).done(function(data){
        if (data.login) {
            location.href = data.url + "index.php?controller=login&operation=logovanje";
        }
    });
}
</script>