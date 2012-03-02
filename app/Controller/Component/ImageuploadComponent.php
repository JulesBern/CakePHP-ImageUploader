<?php
/*
 *	ImageuploadComponent
 *
 *	@cake_version: 2.1
 *
 *
 *
 */
class ImageuploadComponent extends Object {
	
function initialize(&$controller) {
        $this->controller =& $controller;
}

function startup(&$controller){
        $this->controller =& $controller;
}

function beforeRedirect(&$controller){
        $this->controller =& $controller;
}

function beforeRender(&$controller){
        $this->controller =& $controller;
}

function shutdown(&$controller){
        $this->controller =& $controller;
}

// Cartella base in cui verranno create le due cartelle "original/" e "thumb/" dove verranno
// caricate rispettivamente immagini originali e immagini rimpicciolite ( thumb ).
var $upload_folder = "uploads/";
// Misura in pixel massima a cui verra fatto il resize dell'immagine originale rispetto
// a quella di partenza prendendo come riferimento il lato più lungo.
var $original_size = 400;
// Misura in pixel massima a cui verra fatto il resize dell'immagine rimpicciolita ( thumb ) rispetto
// a quella di partenza prendendo come riferimento il lato più lungo.
var $thumb_size = 100;


/*		uploadOriginal 
 *
 *		Carica l'immagine ed effettua il resize utilizzando $original_size come parametro
 *		
 */
public function uploadOriginal ($file = NULL, $type = NULL) {

	if ( $file == NULL ) {
		return -1;
	}
	
	if ( $type == NULL ) {
		return -1;
	}
	
	if ( is_uploaded_file( $file['tmp_name'] ) ) {
		
		return $this->resizeImage( $file, $type );
		
	}
	
}

/*		resizeImage 
 *
 *		Carica l'immagine ed effettua il resize utilizzando $original_size come parametro
 *		
 */
private function resizeImage( $file = NULL, $type = NULL ) {

	// Controlla se è stato passato il file
	if ( $file == NULL ) { return -1; }
	// Controlla se il tipo di immagine è stato settato
	if ( $type == NULL ) { return -1; }
	// Controlla se il "type" specificato è corretto
	if ( $type != 'original' && $type != 'thumb' ) { return -1; }
	
	// Ottengo i valori dell'immagine di base
	list($width, $height ) = getimagesize( $file['tmp_name'] );
	
	// A seconda del tipo di immagine da creare "Original" o miniatura
	// assegno il parametro di proporzione
	if ( $type == 'original' ) {
		
		$ref = $this->original_size;
		
	} else if ( $type == 'thumb') {
		
		$ref = $this->thumb_size;
	}
	
	// Calcolo ed assegnazione di altezza e larghezza all'immagine
	// secondo tre casi differenti
	
	// 1 - Alterzza e Larghezza uguali
	if ( $width == $height ) {
		
		$new_width = $ref;
		$new_height = $ref;
	
	// 2 - Larghezza > Altezza 
	} else if ( $width > $height ) {
		
		$new_width = $ref;
		$new_height = $height * ( $width / $ref );
	
	// 3 - Alterzza > Larghezza	
	} else {
		
		$new_height = $ref;
		$new_width = $width * ( $height / $ref );
		
	}
	
	// A seconda del tipo di immagine da produrre e caricaricare
	// eseguo operazioni diverse
	switch ($type) {
		case 'original':
			$thumb = imagecreatetruecolor($new_width, $new_height);
			$source = $this->smartcreatefrom( $file );
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($thumb, $this->upload_folder."original/".$file['name'], 90);
			return $this->upload_folder."original/".$file['name'];
			break;
		
		case 'thumb':
			$thumb = imagecreatetruecolor($new_width, $new_height);
			$source = $this->smartcreatefrom( $file );
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($thumb, $this->upload_folder."thumb/".$file['name'], 90);
			return $this->upload_folder."thumb/".$file['name'];
			break;			
		
		default:
			exit -1;
			break;
	}

	
}


/*		smartcreatefrom( $file )
 *
 *		la funzione reindirizza alla corretta funzione per creare l'immagine
 *		in relazione al tipo di immagine passata
 *		
 */
private function smartcreatefrom( $file = NULL ) {
	
	switch ( exif_imagetype( $file['tmp_name'] ) ) {
		case '1':
			return imagecreatefromgif( $file['tmp_name'] );
			break;
		
		case '2':
			return imagecreatefromjpeg( $file['tmp_name'] );
			break;
		
		case '3':
			return imagecreatefrompng( $file['tmp_name'] );
			break;
		
		default:
			return -1;
			break;
	}
	
}



}
?>
