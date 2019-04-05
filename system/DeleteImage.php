<?php

class DeleteImage {

    public function deleteOldImage($slika) {
        $ime_slike = $slika['lokacija'] . $slika['ime'];
        if (file_exists($ime_slike)) {
            unlink($ime_slike);
        } 
    }
}
