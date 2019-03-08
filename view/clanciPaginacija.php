<div class='pagination_pages'>
    <div class="pagination_index">
        <?php $i = ''; ?>
        <?php if ($i == $sviClanci['strana'] > $sviClanci['broj_stranica'] && $sviClanci['strana'] != 1) {    ?>
        <a href="<?php echo $sviClanci['pret']; ?>" value="<?php echo $sviClanci['pret']; ?>">&laquo;</a>
    <?php } else {?>
            <a class="isDisabled" href="#" value="">&laquo;</a>
      <?php }?>
    <?php for($i = 1; $i <= $sviClanci['broj_stranica']; $i++) { ?>
        <?php if ($i == $sviClanci['strana']) { ?>
            <a href="#" class="active"><?php echo "$i"; ?></a>
            <?php } else { echo "<a href='#' value='$i'> $i </a>" . ' ' ; } ?>
        <?php } ?>
    <?php if ($sviClanci['strana'] < $sviClanci['broj_stranica']) { ?>
            <a href="<?php echo $sviClanci['sled']; ?>" value="<?php echo $sviClanci['sled']; ?>">&raquo;</a>
      <?php } else {?>
            <a class="isDisabled" href="#" value="">&raquo;</a>
      <?php }?>
    </div>
</div>
<table class="tabela_sa_clancima" border = 1>
    <th>Naslov Clanka</th>
    <th>Objavljen</th>
        <?php if(isset($sviClanci)): ?>
            <?php foreach($sviClanci['sviClanci'] as $jedanClanak) : ?>	
            <tr>
                <td>
                    <?php echo htmlspecialchars($jedanClanak['naslov_clanka']); ?>
                </td>
                <td>
                    <?php echo (htmlspecialchars($jedanClanak['objavljen'] == 1) ? "Da" : 'Ne' ); ?>
                </td>
                <td>
                    <a href="index.php?controller=clanak&operation=dodajIzmijeniClanak&clanak_id=<?php echo $jedanClanak['clanak_id']; ?>">Promijeni</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
</table>

<script>
$(document).ready(function(){
    $('.pagination_pages a').click(function(event) {
        var strana = $(this).attr('value');

        event.preventDefault();
        $.ajax({
            url: "<?php BASE_URL; ?>index.php?controller=clanak&operation=prikaziClankeUTabeli",
            type: 'POST',
            data: 'strana=' + strana + '&po_str=' + 10,
            success: function(data) {
                $("form .paginacija").html(data);
            }
        });
    });
});

</script>