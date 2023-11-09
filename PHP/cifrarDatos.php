<?php
    // Función para cifrar datos
    function encryptData($data, $key) {
        $iv = random_bytes(16); // Genera un vector de inicialización aleatorio
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    function decryptData($data, $key) {
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $data = substr($data, 16);
        $decrypted = openssl_decrypt($data, 'aes-256-cbc', $key, 0, $iv);
    
        if ($decrypted === false) {
            echo "Error al descifrar los datos: " . openssl_error_string();
            return false;
        }
    
        return $decrypted;
    }
?>