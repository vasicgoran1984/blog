<?php if(isset($greske)) :?>
    <?php foreach($greske as $jednaGreska) : ?>
        <?php echo $jednaGreska; ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php if(isset($sviObjavljeniClanci)): ?>
<div class='pagination_pages'>
    <div class="pagination">
        <?php $i = ''; ?>
        <?php if($sviObjavljeniClanci['broj_red'] > 8) : ?>
            <?php if ($i == $sviObjavljeniClanci['strana'] > $sviObjavljeniClanci['broj_str'] && $sviObjavljeniClanci['strana'] != 1) {    ?>
            <a href="<?php echo $sviObjavljeniClanci['pret']; ?>" value="<?php echo $sviObjavljeniClanci['pret']; ?>">&laquo;</a>
        <?php } else {?>
                <a class="isDisabled" href="#" value="">&laquo;</a>
          <?php }?>
            <?php endif; ?> 
        <?php if($sviObjavljeniClanci['broj_red'] > 8) : ?>
        <?php for($i = 1; $i <= $sviObjavljeniClanci['broj_str']; $i++) { ?>
            <?php if ($i == $sviObjavljeniClanci['strana']) { ?>
                <a href="#" class="active isDisabled"><?php echo "$i"; ?></a>
                <?php } else { echo "<a href='#' value='$i'> $i </a>" . ' ' ; } ?>
            <?php } ?>
        <?php endif; ?>        
        <?php if($sviObjavljeniClanci['broj_red'] > 8) : ?>
            <?php if ($sviObjavljeniClanci['strana'] < $sviObjavljeniClanci['broj_str']) { ?>
                    <a href="<?php echo $sviObjavljeniClanci['sled']; ?>" value="<?php echo $sviObjavljeniClanci['sled']; ?>">&raquo;</a>
              <?php } else {?>
                    <a class="isDisabled" href="#" value="">&raquo;</a>
              <?php }?>
        <?php endif; ?>
    </div>
</div>
<div class="nadjeni_clanci">
    <?php if (isset($sviObjavljeniClanci)) : ?>
        <?php foreach($sviObjavljeniClanci['sviClanci'] as $jedanClanak) : ?>	
            <div class="blog-container">
                <?php if($jedanClanak->naslovna_slika !== '') : ?>
                    <div class="blog-image">
                        <img src="<?php echo BASE_URL.'/view/assets/images/clanci/'. $jedanClanak->naslovna_slika; ?>"/>
                    </div>
                <?php endif; ?>
                <div class="blog-title">
                    <h4><?php echo htmlspecialchars($jedanClanak->naslov_clanka); ?></h4>
                </div>
                <div class="blog-text">
                    <h4><?php echo htmlspecialchars(substr($jedanClanak->dugacki_tekst, 0, 100)) . '...'; ?></h4>
                </div>
                <div class="blog-autor"><hr/>
                    <h5>Autor: <?php echo htmlspecialchars($jedanClanak->ime . ' ' . $jedanClanak->prezime); ?> </h5>
                </div>
                <div class="blog-link-komentar">
                    <a href="clanak/procitaj-komentarisi/slug/<?php echo $jedanClanak->slug; ?>">Procitaj Vise</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<script>
$(document).ready(function(){
    $('.pagination_pages a').click(function(event) {
        var stranica = $(this).attr('value');
        var ime_prezime = $(".blog-wrapper .blog-search form.pretraga input[name='ime_prezime']").val();
        var datum_od = $(".blog-wrapper .blog-search form.pretraga input[name='datum_od']").val();
        var datum_do = $(".blog-wrapper .blog-search form.pretraga input[name='datum_do']").val();
        var naslov_kljucna_rijec = $(".blog-wrapper .blog-search form.pretraga input[name='kljucna_rijec']").val();
        
        event.preventDefault();
        $.ajax({
            url: "<?php echo BASE_URL; ?>index/ajax-index-pretraga",
            type: 'POST',
            data: 'po_strani=' + 8 + 
            '&stranica=' + stranica + 
            '&ime_prezime=' + ime_prezime + 
            '&datum_od=' + datum_od + 
            '&datum_do=' + datum_do +
            '&naslov_kljucna_rijec='  + naslov_kljucna_rijec,
            success: function(data) {
                $(".blog-wrapper .pretraga_clanka_paginacija").html(data);
            }
        });
    });
});

</script>


