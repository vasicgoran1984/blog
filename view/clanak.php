<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php include('topContainer.php'); ?><br/>
        <div class="prvi_omotac">
            <div class="novi_clanak">
                <a class="btn btn-info" href="<?php echo BASE_URL; ?>clanci/dodaj-izmijeni-clanak/">Novi Clanak</a>
            </div><br/>
            <form class="izmijeni_clanak" action="<?php BASE_URL; ?>clanci/dodaj-izmijeni-clanak/" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="izmijeni_clanak" value="1">
                <div class='select_broj_clanaka'>
                    <label label='label_broj_clanaka'></label></br>
                </div>
                <div class="paginacija"></div>
            </form>
        </div>
    </body>
</html>
<script>
$(document).ready(function(){
    $.ajax({
        url: "<?php echo BASE_URL; ?>clanci/ajax-prikazi-clanke",
        type: 'POST',
        data: 'po_str=' + 10,
        success: function(data) {
            $('form .paginacija').html(data);
        }
    });
});
</script>