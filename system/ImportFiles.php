<?php

class Import {

    public function importImage($slika) {
        if (move_uploaded_file($slika['file_tmp'], $slika['lokacija'] . $slika['ime'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
