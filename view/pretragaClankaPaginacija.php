<?php if(isset($greske)) :?>
    <?php foreach($greske as $jednaGreska) : ?>
        <?php echo $jednaGreska; ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php if(isset($sviObjavljeniClanci)): ?>
<div class='pagination_pages'>
    <div class="pagination">
        <?php $i = ''; ?>
        <?php if ($i == $sviObjavljeniClanci['strana'] > $sviObjavljeniClanci['broj_str'] && $sviObjavljeniClanci['strana'] != 1) {    ?>
        <a href="<?php echo $sviObjavljeniClanci['pret']; ?>" value="<?php echo $sviObjavljeniClanci['pret']; ?>">&laquo;</a>
    <?php } else {?>
            <a class="isDisabled" href="#" value="">&laquo;</a>
      <?php }?>
    <?php for($i = 1; $i <= $sviObjavljeniClanci['broj_str']; $i++) { ?>
        <?php if ($i == $sviObjavljeniClanci['strana']) { ?>
            <a href="#" class="active"><?php echo "$i"; ?></a>
            <?php } else { echo "<a href='#' value='$i'> $i </a>" . ' ' ; } ?>
        <?php } ?>
    <?php if ($sviObjavljeniClanci['strana'] < $sviObjavljeniClanci['broj_str']) { ?>
            <a href="<?php echo $sviObjavljeniClanci['sled']; ?>" value="<?php echo $sviObjavljeniClanci['sled']; ?>">&raquo;</a>
      <?php } else {?>
            <a class="isDisabled" href="#" value="">&raquo;</a>
      <?php }?>
    </div>
</div>

<form class="pretraga_procitaj_komentarisi_clanak" action="<?php BASE_URL; ?>index.php?controller=komentar&operation=procitajKomentarisiClanak" method="post">
    <input type="hidden" name="izmijeni_clanak" value="1">
    <div class="nadjeni_clanci">
        <?php if (isset($sviObjavljeniClanci)) : ?>
            <?php foreach($sviObjavljeniClanci['sviClanci'] as $jedanClanak) : ?>	
                <div class="blog-container">
                    <?php if($jedanClanak['naslovna_slika'] !== '') : ?>
                        <div class="blog-image">
                            <img src="<?php echo BASE_URL.'/view/assets/images/clanci/'. $jedanClanak['naslovna_slika']; ?>"/>
                        </div>
           
                    <?php endif; ?>
                    <div class="blog-title">
                        <h4><?php echo htmlspecialchars($jedanClanak['naslov_clanka']); ?></h4>
                    </div>
                    <div class="blog-text">
                        <h4><?php echo htmlspecialchars(substr($jedanClanak['dugacki_tekst'], 0, 100)) . '...'; ?></h4>
                    </div>
                    <div class="blog-autor"><hr/>
                        <h5>Autor: <?php echo htmlspecialchars($jedanClanak['ime'] . ' ' . $jedanClanak['prezime']); ?> </h5>
                    </div>
                    <div class="blog-link-komentar">
                        <a href="index.php?controller=clanak&operation=procitajKomentarisiClanak&clanak_id=<?php echo $jedanClanak['clanak_id']; ?>">Procitaj Vise</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</form>
<?php endif; ?>
<script>
$(document).ready(function(){
    $('.pagination_pages a').click(function(event) {
        var stranica = $(this).attr('value');
        
        event.preventDefault();
        $.ajax({
            url: "<?php BASE_URL; ?>index.php?controller=index&operation=sviClanciPaginacija",
            type: 'POST',
            data: 'stranica=' + stranica + '&po_strani=' + 8,
            success: function(data) {
                $(".blog-wrapper .pretraga_clanka_paginacija").html(data);
            }
        });
    });
});

</script>


