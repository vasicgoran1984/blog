<!DOCTYPE html>
<html>
    <?php include('header.php'); ?>
    <body>
        <?php include('topContainer.php'); ?>
        <div class="blog-wrapper">
            <div class="blog-search">
                <form class="pretraga" action="" style="margin:auto;">
                    <input type="text" placeholder="Datum od..." name="datum_od">
                    <input type="text" placeholder="Datum do..." name="datum_do">
                    <input type="text" placeholder="Trazi autora..." name="ime_prezime">
                    <input type="text" placeholder="Kljucna rijec..." name="kljucna_rijec">
                    <button class="pretraga-clanka"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="pretraga_clanka_paginacija"></div>
        </div>
    </body>
</html>

<script>
$(document).ready(function(){
    
    // Prikazi sve clanke paginacija
    $(document).ready(function(){
        $.ajax({
            url: "<?php BASE_URL; ?>index.php?controller=index&operation=sviClanciPaginacija",
            type: 'POST',
            data: 'po_strani=' + 8,
            success: function(data) {
                $(".blog-wrapper .pretraga_clanka_paginacija").html(data);
            }
        });
    });
    
   // datepicker za datum od
    $(".blog-wrapper .blog-search form.pretraga input[name='datum_od']").datepicker({
        dateFormat: 'dd-mm-yy',
        showOtherMonths: true,
        changeYear: true,
        changeMonth: true,
        yearRange: '2015:2020'
    });
    
   // datepicker za datum do
    $(".blog-wrapper .blog-search form.pretraga input[name='datum_do']").datepicker({
        dateFormat: 'dd-mm-yy',
        showOtherMonths: true,
        changeYear: true,
        changeMonth: true,
        yearRange: '2015:2020'
    });
    
    // Pretraga clanka
    $(".blog-wrapper .blog-search form.pretraga button.pretraga-clanka").click(function(event) {
        event.preventDefault();    
        var ime_prezime = $(".blog-wrapper .blog-search form.pretraga input[name='ime_prezime']").val();
        var datum_od = $(".blog-wrapper .blog-search form.pretraga input[name='datum_od']").val();
        var datum_do = $(".blog-wrapper .blog-search form.pretraga input[name='datum_do']").val();
        var kljucna_rijec = $(".blog-wrapper .blog-search form.pretraga input[name='kljucna_rijec']").val();
        
        $.ajax({
            url: "<?php BASE_URL; ?>index.php?controller=index&operation=sviClanciPaginacija",
            type: 'POST',
            data: 'ime_prezime=' + ime_prezime + 
            '&datum_od=' + datum_od + 
            '&datum_do=' + datum_do +
            '&kljucna_rijec='  + kljucna_rijec +
            '&po_strani=' + 8,
            success: function(data) {
                $(".blog-wrapper .pretraga_clanka_paginacija").html(data);
            }
        });
    });
});
</script>