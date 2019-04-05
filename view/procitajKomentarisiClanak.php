<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <?php include('topContainer.php'); ?>
    <body>
        <div class="prikazi_autora">
            <span>Autor: <?php echo $prikaziAutora->ime . ' ' . $prikaziAutora->prezime ?></span><br/><br/>
            <div class="autor_slika">
                <img src="<?php echo BASE_URL.'/view/assets/images/korisnici/'. $prikaziAutora->slika_korisnika; ?>"/>
            </div>
        </div>
        <div class="clanak_container">
            <div class="clanak_wrapper">
                <div class="clanak_wrapper_left">
                    <div class="naslov_clanka">
                    <h4><?php echo htmlspecialchars($rezultat->naslov_clanka); ?></h4>
                    </div>
                    
                    <?php if($rezultat->naslovna_slika !== '') : ?>
                    <div class="slika_clanka">
                        <img src="<?php echo BASE_URL.'/view/assets/images/clanci/' . $rezultat->naslovna_slika ; ?>"/>
                    </div>
                    <?php endif; ?>
                    
                    <div class="kratki_tekst_datum">
                        <div class="kratki_tekst_clanka">
                            <span><?php echo htmlspecialchars($rezultat->kratki_tekst); ?></span>
                        </div>
                        <div class="datum_objave_clanka">
                            <span>Datum objave:</span>
                            <span><?php echo htmlspecialchars($rezultat->datum_objave_clanka); ?></span>
                        </div>
                        <div class="pozitivan_negativan_utisak">
                            <div class="ostavi_utisak">
                                <span class="ostavi_utisak">Ostavi utisak:</span>
                            </div>
                            <?php if((isset($_SESSION['korisnik']))): ?>
                            <form class="utisak_na_clanak"  method="POST">
                                <div class="checkbox clanak-utisak-plus" style="">
                                    <input type="checkbox" clanak_id="<?php echo $rezultat->id; ?>" class="checkbox-plus-clanak-utisak">
                                    <label class="css-label">
                                        <span class="fa fa-plus" style="background:<?php echo (isset($kojiUtisakPostoji[0]->utisak) && $kojiUtisakPostoji[0]->utisak == 1 ? "gray" : ""); ?>"></span>
                                    </label>
                                </div>

                                <div class="checkbox clanak-utisak-minus" style="">
                                    <input type="checkbox" clanak_id="<?php echo $rezultat->id; ?>" class="checkbox-minus-clanak-utisak">
                                    <label class="css-label">
                                        <span class="fa fa-minus" style="background:<?php echo (isset($kojiUtisakPostoji[0]->utisak) && $kojiUtisakPostoji[0]->utisak == 2 ? "gray" : ""); ?>"></span>
                                    </label>
                                </div>
                                <?php endif; ?>
                            </form>
                        </div>
                        <div class="ukupno_utisaka">
                            <div class="pozitivni">Pozitivni utisci: <?php echo '<span>' . $pozitivniUtisci . '</span>'; ?></div>
                            <div class="negativni">Pozitivni utisci: <?php echo '<span>' . $negativniUtisci . '</span>'; ?></div>
                            <a href="<?php echo BASE_URL; ?>clanak/pogledaj-sve-clanke/id/<?php echo $rezultat->korisnik_id; ?>">Pogledaj sve clanke</a>
                        </div>
                 
                    </div>
                    <div class="dugacki_tekst_clanka">
                        <span><?php echo htmlspecialchars($rezultat->dugacki_tekst); ?></span>
                    </div>
                    
                </div>
            </div>
            <div class="svi_komentari_container">
                <?php if (isset($clanakSaKomentarima)): ?>
                    <?php foreach($clanakSaKomentarima as $key => $jedanClanak): ?>
                        <div class="komentari_clanka">
                            <span class="kor_datum">Komentarisao <?php echo $jedanClanak->ime . ' ' . $jedanClanak->prezime . ' Datum ' . $jedanClanak->datum_objave_komentara . '<br/>';  ?></span><br/>
                            <span class="komentari_clanka_span"><?php echo $jedanClanak->komentar; ?></span>
                            
                            <div class="reakcije_na_komentar">
                                <?php if((isset($_SESSION['korisnik'])) && (!($jedanClanak->korisnik_id == $_SESSION['korisnik']['id']))): ?>
                                    <form class="utisak_na_komentar"  method="post"> 

                                        <div class="komentar-utisak-plus">
                                            <input type="checkbox" komentar_id="<?php echo $jedanClanak->komentar_id; ?>" class="checkbox-plus-komentar-utisak">
                                            <label class="css-label">
                                                <span class="fa fa-plus" komentar_id="<?php echo $jedanClanak->komentar_id; ?>" style="background:<?php echo (!empty($jedanClanak->utisak) && $jedanClanak->utisak == 1  ? "gray" : ""); ?>"></span>
                                            </label>
                                        </div>
                                        <div class="komentar-utisak-minus">
                                            <input type="checkbox" komentar_id="<?php echo $jedanClanak->komentar_id; ?>" class="checkbox-minus-komentar-utisak">
                                            <label class="css-label">
                                                <span class="fa fa-minus" komentar_id="<?php echo $jedanClanak->komentar_id; ?>" style="background:<?php echo (!empty($jedanClanak->utisak) && $jedanClanak->utisak == 2  ? "gray" : ""); ?>"></span>
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
                <div class="komentari_greske"><span class="prikazi_greske"></span></div>
                <form class="komentarisi_clanak"  method="POST" > 
                    <div class="container">
                        
                        <label for="komentar clanka"><b>Komentar:</b></label><br/>
                        <textarea rows="4" cols="50" placeholder="Unesite komentar..." name="komentar"></textarea> <br/>
                        <br/>
                        <input type="button" value="Komentarisi" onclick="komentarisiClanak(<?php echo $rezultat->id; ?>)" class="registerbtn">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<script>
    
$( document ).ready(function() {
    
    /*Dodaj/Izmijeni utisak na clanak checkbox plus*/
    $('form.utisak_na_clanak .fa.fa-plus').click(function() {
       $(this).parent().parent().find('.checkbox-plus-clanak-utisak').prop("checked", true);
       $(this).css('background', 'gray');

       if ($(this).parent().parent().find('.checkbox-plus-clanak-utisak').prop("checked")) {
           var clanak_id = $(this).parent().parent().find('.checkbox-plus-clanak-utisak').attr("clanak_id");
           dodajIzmijeniUtisakClanak(1, clanak_id);
       }
   });
   /*Dodaj/Izmijeni utisak na clanak checkbox minus*/
    $('form.utisak_na_clanak .fa.fa-minus').click(function() {
       $(this).parent().parent().find('.checkbox-minus-clanak-utisak').prop("checked", true);
       $(this).css('background', 'gray');

       if ($(this).parent().parent().find('.checkbox-minus-clanak-utisak').prop("checked")) {
           var clanak_id = $(this).parent().parent().find('.checkbox-minus-clanak-utisak').attr("clanak_id");
           dodajIzmijeniUtisakClanak(2, clanak_id);
       }
   });
   /****************************************************************************/
   
   /*Dodaj/Izmijeni utisak na komentar checkbox plus*/
    $('form.utisak_na_komentar .fa.fa-plus').click(function() {
       $(this).parent().parent().find('.checkbox-plus-komentar-utisak').prop("checked", true);
       $(this).css('background', 'gray');
       
       if ($(this).parent().parent().find('.checkbox-plus-komentar-utisak').prop("checked")) {
           var komentar_id = $(this).parent().parent().find('.checkbox-plus-komentar-utisak').attr("komentar_id");
           dodajIzmijeniUtisakNaKomentar(1, komentar_id);
       }
   });
   /*Dodaj/Izmijeni utisak na komentar checkbox minus*/
    $('form.utisak_na_komentar .fa.fa-minus').click(function() {
       $(this).parent().parent().find('.checkbox-minus-komentar-utisak').prop("checked", true);
       $(this).css('background', 'gray');

       if ($(this).parent().parent().find('.checkbox-minus-komentar-utisak').prop("checked")) {
           var komentar_id = $(this).parent().parent().find('.checkbox-minus-komentar-utisak').attr("komentar_id");
           dodajIzmijeniUtisakNaKomentar(2, komentar_id);
       }
   });
  
});
    
function dodajIzmijeniUtisakClanak(utisak, clanak_id) {

    //utisak -> 1 pozitivan / 2 negativan / 0 neutralan
    $.ajax({
        url: "<?php echo BASE_URL; ?>utisci-clanka/ajax-upisi-utisak-clanka",
        type: 'POST',
        dataType: 'JSON',
        data: 'utisak=' + utisak +
              '&clanak_id=' + clanak_id
    }).done(function(data){
        $(".kratki_tekst_datum .ukupno_utisaka .pozitivni span").text(data.svi_poz);
        $(".kratki_tekst_datum .ukupno_utisaka .negativni span").text(data.svi_neg);
        
        if (parseInt(data.utisak) == 1) {
            $('form.utisak_na_clanak .fa.fa-minus').css('background', 'red');
        } else if (parseInt(data.utisak) == 2) {
            $('form.utisak_na_clanak .fa.fa-plus').css('background', 'green');
        } else if (parseInt(data.utisak) == 0) {
            $('form.utisak_na_clanak .fa.fa-plus').css('background', 'green');
            $('form.utisak_na_clanak .fa.fa-minus').css('background', 'red');
        }
       
    });
}
     
function komentarisiClanak(clanak_id) {
    
    var komentar = $(".komentar_wrapper form.komentarisi_clanak textarea").val();    
    $.ajax({
        url: "<?php echo BASE_URL; ?>komentar/ajax-komentarisi-clanak",
        type: 'POST',
        dataType: 'JSON',
        data: 'komentar=' + komentar +
              '&clanak_id=' + clanak_id
    }).done(function(data){
        if (data.error) {
            $(".komentari_greske span.prikazi_greske").show();
            $(".komentari_greske span.prikazi_greske").html(data.greske);
        } else if (data.status) {
           
            if ($(".svi_komentari_container").find(".komentari_clanka").length == 0){
                $(".komentari_greske span.prikazi_greske").show();
                $('.svi_komentari_container').append("<div " + "class=komentari_clanka" + "></div>");
                $('.komentari_clanka').append("Komentarisao " + ' ' + data.komentarisao + '<br>' + ' ' + data.komentar).insertBefore(".komentarisi_clanak"); 
                $(".komentar_wrapper form.komentarisi_clanak textarea").val(''); 
            } else {
                var novi_kom = $(".novi_komentar_clanka").clone();
                novi_kom.html("Komentarisao: " + ' ' + data.komentarisao + '<br>' + ' ' + data.komentar);
                novi_kom.removeClass("novi_komentar_clanka");
                novi_kom.addClass("komentari_clanka");
                novi_kom.show();
                $(".komentari_clanka").last().after(novi_kom);
                $(".komentar_wrapper form.komentarisi_clanak textarea").val(''); 
                $(".komentari_greske span.prikazi_greske").hide();
            }
        } else if (data.login) {
            location.href = data.url + "index/pocetna";
        }
    });
}

function dodajIzmijeniUtisakNaKomentar(utisak, komentar_id) {
    
    //utisak -> 1 pozitivan / 2 negativan / 0 neutralan
    $.ajax({
        url: "<?php echo BASE_URL; ?>utisci-komentara/ajax-upisi-utisak-komentara",
        type: 'POST',
        dataType: 'JSON',
        data: 'utisak=' + utisak +
              '&komentar_id=' + komentar_id
    }).done(function(data){
        
        $("form.utisak_na_komentar .fa.fa-minus").each(function(){
            if ($(this).attr("komentar_id") == data.promijenjeni_kom) {
                
                if (parseInt(data.utisak) == 2) { 
                    $(this).css("background", "gray");
                } else if (parseInt(data.utisak) == 1) {
                    $(this).css("background", "red");
                } else if (parseInt(data.utisak) == 0) {
                    $(this).css("background", "red");
                }
            }
        });
        
        $("form.utisak_na_komentar .fa.fa-plus").each(function(){
            if ($(this).attr("komentar_id") == data.promijenjeni_kom) {
                
                if (parseInt(data.utisak) == 1) { 
                    $(this).css("background", "gray");
                } else if (parseInt(data.utisak) == 2) {
                    $(this).css("background", "green");
                } else if (parseInt(data.utisak) == 0) {
                    $(this).css("background", "green");
                }
            }
        });
    });
}
</script>
