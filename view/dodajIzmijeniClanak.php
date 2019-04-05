<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php echo '<h4>' . 'Clanak' . '</h4>'; ?>
        <hr>
        <?php if(isset($rezultat) && $rezultat->naslovna_slika) : ?>
            <form action="<?php echo BASE_URL; ?>clanak/obrisi-sliku/" method="post">
                <input type="hidden"name="clanak_id" value="<?php echo (isset($rezultat) && $rezultat->id ? $rezultat->id : ""); ?>">
               <button type="submit" class="">Obrisi Sliku</button>
            </form>
        <?php endif; ?>
         
        <div class="dodaj_izmijeni_clanak">
            <form class="novi_clanak" action="<?php echo BASE_URL; ?>clanci/snimi-clanak" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="novi_clanak" value="1">
                <div class="container">
                    <div class="komentari_greske">
                        <?php if(isset($greske)) {
                            foreach($greske as $jednaGreska) {
                                echo $jednaGreska . '<br/>';
                            }
                        } ?>
                    </div>
                    <?php if(isset($rezultat) && $rezultat->naslovna_slika != '') : ?>
                        <div class="slika_clanka">
                            <img src="<?php echo BASE_URL.'/view/assets/images/clanci/'. $rezultat->naslovna_slika; ?>"/>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="clanak_id" value="<?php echo (isset($rezultat) && $rezultat->id ? $rezultat->id : '' );?>" >

                    Izaberite sliku:
                    <input type="file" name="naslovna_slika" id="naslovna_slika_clanka">
                    <br/><br/>

                    <input type="checkbox" name="objavljen" <?php echo (isset($rezultat) && ($rezultat->objavljen == 1) ? "checked" : "" ); ?> value="<?php echo (!empty($rezultat->objavljen) ? $rezultat->objavljen : '' ); ?>">Objavi Clanak<br/><br/>
                    <br/><br/>
                    
                    <label for="naslov clanka"><b>Naslov Clanka:</b></label><br/>
                    <input type="text" placeholder="Naslov Clanka" name="naslov_clanka" value="<?php  echo (isset($rezultat) && $rezultat->naslov_clanka ? $rezultat->naslov_clanka : ''); ?>">
                    <br/><br/>
                    
                    <label for="kratki tekst"><b>Kratki Tekst:</b></label><br/>
                    <input type="text" placeholder="Kratki Tekst" name="kratki_tekst" value="<?php  echo (isset($rezultat) && $rezultat->kratki_tekst ? $rezultat->kratki_tekst : ''); ?>">
                    <br/><br/>

                    <label for="opis clanka"><b>Dugacki Tekst:</b></label><br/>
                    <textarea rows="8" cols="80" placeholder="Tekst..." name="dugacki_tekst"><?php echo (isset($rezultat) && $rezultat->dugacki_tekst ? $rezultat->dugacki_tekst : '');?></textarea> <br/>
                    <br/>

                    <label for="kljucne rijeci"><b>Kljucne Rijeci</b></label><br/>
                    <input type="text" placeholder="Kljucne Rijeci" name="kljucne_rijeci" value="<?php echo (isset($rezultat) && $rezultat->kljucne_rijeci ? $rezultat->kljucne_rijeci : '');?>">
                    <br/><br/>
                
                    <input type="hidden"  placeholder="slug" name="slug" value="<?php echo (isset($rezultat) && $rezultat->slug ? $rezultat->slug : '');?>">
                    <hr>
                    <button type="submit" class="registerbtn">Snimi</button>
                </div>
            </form>
        </div>
    </body>
</html>