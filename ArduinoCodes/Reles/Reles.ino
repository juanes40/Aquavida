// Incluye la biblioteca de la placa ESP32
#include <Arduino.h>

// Define el pin al que está conectado el relé
const int pinRelay = 18; // Cambia el número de pin según tu conexión

void setup(){
  // Inicializa el pin del relé como salida
  pinMode(pinRelay, OUTPUT);

  // Apaga inicialmente el relé
  digitalWrite(pinRelay, LOW);

  // Inicializa la comunicación serial
  Serial.begin(115200);
}

void loop() {
  // Activa el relé durante 5 segundos
  digitalWrite(pinRelay, LOW);
  Serial.println("Relé activado");
  delay(10000); // espera 5 segundos

  // Desactiva el relé durante 5 segundos
  digitalWrite(pinRelay, HIGH);
  Serial.println("Relé desactivado");
  delay(5000); // espera 5 segundos
}
