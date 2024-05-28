<?php 
class Download extends CI_Controller {

    public function archivo() {
        $rutaArchivo = './public/apk/lapanca.apk'; // Ruta al archivo en tu servidor
        $nombreArchivo = 'lapanca.apk'; // Nombre del archivo al descargarlo

        // Verifica si el archivo existe
        if (file_exists($rutaArchivo)) {
            // Establece las cabeceras para forzar la descarga
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($nombreArchivo) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($rutaArchivo));

            // Lee el archivo y envía su contenido al navegador
            readfile($rutaArchivo);
            exit;
        } else {
            show_404(); // Muestra una página de error 404 si el archivo no se encuentra
        }
    }
}
