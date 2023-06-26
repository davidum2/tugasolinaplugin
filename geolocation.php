<?php
/*
Archivo: Geolocation.php
Este archivo contiene la clase Geolocation para manejar la geolocalización.
*/

namespace TuGasolinaEnMexico;

class Geolocation {
    // Método para imprimir el script de JavaScript para obtener la ubicación del usuario
    public function print_geolocation_script() {
        ?>
        <script>
        // Comprueba si el navegador soporta la Geolocation API
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Si el usuario da permiso, obtén y muestra la ubicación en la consola
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                console.log('Latitud: ' + lat + ', Longitud: ' + lon);
            }, function(error) {
                // Si hay un error (por ejemplo, el usuario no da permiso), muestra un mensaje en la consola
                console.log('Error al obtener la ubicación: ' + error.message);
            });
        } else {
            // Si el navegador no soporta la Geolocation API, muestra un mensaje en la consola
            console.log('Tu navegador no soporta la Geolocation API.');
        }
        </script>
        <?php
    }

    // Método para convertir la ubicación a geohash
    public function convert_to_geohash($lat, $lon) {
        $geohash = '';
        $chars = '0123456789bcdefghjkmnpqrstuvwxyz';
        $precision = 5;
        $minLat = -90;
        $maxLat = 90;
        $minLon = -180;
        $maxLon = 180;

        for ($i = 0; $i < $precision; $i++) {
            $geohash .= $chars[$this->encode($lat, $minLat, $maxLat) * 16 + $this->encode($lon, $minLon, $maxLon)];
        }

        return $geohash;
    }

    // Método auxiliar para codificar una coordenada a geohash
    private function encode($coord, $min, $max) {
        $mid = ($min + $max) / 2;
        if ($coord < $mid) {
            $max = $mid;
            return 0;
        } else {
            $min = $mid;
            return 1;
        }
    }
}
?>
