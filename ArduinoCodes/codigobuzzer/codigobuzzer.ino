int buzzerPin = 16; // Pin al que está conectado el buzzer

// Define las frecuencias para las notas musicales
int notas[] = {262, 294, 330, 349, 392, 440, 494, 523};

void setup() {
  pinMode(buzzerPin, OUTPUT);
}

void loop() {
  // Toca una melodía corta y bonita
  int melody[] = {3, 3, 4, 5, 5, 4, 3, 2, 1, 1, 2, 3, 3, 2, 2}; // Puedes ajustar las notas según tus preferencias
  int duracionNota = 300;

  for (int i = 0; i < sizeof(melody) / sizeof(melody[0]); i++) {
    int nota = melody[i];
    if (nota == 0) {
      // Pausa
      delay(duracionNota);
    } else {
      // Toca la nota
      tone(buzzerPin, notas[nota - 1]);
      delay(duracionNota);
      noTone(buzzerPin);
      delay(50); // Pequeña pausa entre las notas
    }
  }
  delay(2000); // Pausa antes de repetir la melodía
}





