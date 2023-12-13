  #include <WiFi.h>
  #include <HTTPClient.h>
  #include <OneWire.h>
  #include <DallasTemperature.h>

  // Replace with your network credentials
  const char* ssid = "juRedmi Note 9S";
  const char* password = "Juanes453";

  // REPLACE with your Domain name and URL path or IP address with path

  const char* serverName = "http://192.168.21.102/Aquavida/PHP/post-esp-data.php";

  // Keep this API Key value to be compatible with the PHP code provided in the project page.
  // If you change the apiKeyValue value, the PHP file /post-esp-data.php also needs to have the same key
  String apiKeyValue = "tPmAT5Ab3j7F9";
  int pin_dos = 13;
  int pinRelay = 18;
  String sensorName1 = "TemperatureSensor"; // Cambia el nombre del sensor
  String sensorName2 = "WaterSensor";
  String sensorLocation = "UNICAUCA"; // Cambia la ubicación del sensor
  String sensorName3 = "phSensor";
  String alarma = "Apagada";
  int tiempoTemp = 1000;
  int tiempoNivel = 1000;
  int tiempoPH = 1000;
  String activacionLuz = "off" ;


  int buzzerPin = 27;
  int notas[] = {262, 294, 330, 349, 392, 440, 494, 523};

  #define ONE_WIRE_BUS 5 // Pin donde está conectado el sensor DS18B20
  #define ANALOG_PIN 34 // Pin donde está conectado el sensor de nivel de agua (analógico)
  #define PH_SENSOR_PIN 32 // Pin donde está conectado el sensor de pH (analógico)

  OneWire oneWire(ONE_WIRE_BUS);
  DallasTemperature sensors(&oneWire);

  void setup() {
    Serial.begin(115200);

    WiFi.begin(ssid, password);
    Serial.println("Connecting");
    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
      Serial.print(".");
    }
    Serial.println("");
    Serial.print("Connected to WiFi network with IP Address: ");
    Serial.println(WiFi.localIP());

    // Inicializa el pin del sensor de pH
    pinMode(PH_SENSOR_PIN, INPUT);
    pinMode(buzzerPin, OUTPUT);
    //Inicializa el pin de la tira led
    pinMode(pinRelay, OUTPUT);
    digitalWrite(pinRelay, LOW);
  }

  void loop() {
    // Check WiFi connection status
    if (WiFi.status() == WL_CONNECTED) {
      WiFiClient client;
      HTTPClient http;
      //==========================================================================================================
      const char* serverName1 = "http://192.168.21.102/Aquavida/PHP/post-Luz.php";
      http.begin(client, serverName1);
      // Specify content-type header
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      String httpRequestData1 = "api_key=" + apiKeyValue +"&switch_estado=" +String(activacionLuz) +"";
      int httpResponseCode1 = http.POST(httpRequestData1);
      http.end();

      http.begin(client, serverName);
      String serverPath1 = "http://192.168.21.102/Aquavida/PHP/get-Luz.php";
      String conectar1 = serverPath1+"?api_key="+apiKeyValue+"&estadoLuz=switch_estado";
      http.begin(client, conectar1.c_str());
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      int httpResponseCodeGet1 = http.GET();
      String response1 = http.getString();
      http.end();
      activacionLuz = response1;
      //===========================================================================================================
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverName);
      // Specify content-type header
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      // Prepare your HTTP POST request data
      float temperatureCelsius = leerTemp(tiempoTemp);
      float waterLevel = leerNivel(tiempoNivel);
      float ph = leerPH(tiempoPH);
//===================== activacionLuz ===============
      
      if(activacionLuz=="on"){
        digitalWrite(pinRelay, LOW);
        Serial.println("Relé activado");

      }else if( activacionLuz=="off"){
        digitalWrite(pinRelay, HIGH);
        Serial.println("Relé desactivado");
      }else{
        Serial.println("ERRORRRRRRR");
      }
      if(temperatureCelsius > 22){
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
        delay(200);
      }

      String httpRequestData = "api_key=" + apiKeyValue + "&sensor1=" + sensorName1 +
                              "&location=" + sensorLocation + "&value1=" + String(temperatureCelsius) +
                              "&sensor2=" + sensorName2 + "&value2=" + String(waterLevel) +
                              "&sensor3=" + sensorName3 + "&value3=" + String(ph) + "&tiempotemp="+ String(tiempoTemp) +
                              "&tiemponivel=" + String(tiempoNivel) + "&tiempoph=" + String(tiempoPH) +"";


      Serial.print("httpRequestData: ");
      Serial.println(httpRequestData);

      // Send HTTP POST request
      
      int httpResponseCode = http.POST(httpRequestData);

      if (httpResponseCode > 0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
      } else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }

      // Free resources
      http.end();


      http.begin(client, serverName);
      String serverPath = "http://192.168.21.102/Aquavida/PHP/get-esp-data.php";

      String conectar = serverPath+"?api_key="+apiKeyValue+"&tiempo1=tiempotemp"+"&tiempo2=tiemponivel"+"&tiempo3=tiempoph"+"&estadoLuz=switch_estado";
      http.begin(client, conectar.c_str());
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      int httpResponseCodeGet = http.GET();

      if (httpResponseCodeGet>0) {
        Serial.print("HTTP Response code GET: ");
        Serial.println(httpResponseCodeGet);
        
      }
      else {
        Serial.print("Error code GET: ");
        Serial.println(httpResponseCodeGet);
      }
      // Realiza la solicitud HTTP GET y obtiene la respuesta
      String response = http.getString();

// Divide la respuesta en partes usando la coma como delimitador
      String parts[4];
      int index = 0;
      int lastIndex = 0;
      for (int i = 0; i < response.length(); i++) {
        if (response.charAt(i) == ',') {
        parts[index] = response.substring(lastIndex, i); // Obtiene la parte entre comas
        index++;
        lastIndex = i + 1;
      }
    }
    parts[index] = response.substring(lastIndex); // La última parte después de la última coma

// Convierte las partes en enteros
      //Temperatura
      tiempoTemp = parts[0].toInt();

      //Nivel
      tiempoNivel = parts[1].toInt();

      //PH
      tiempoPH = parts[2].toInt();

      //Luz
      //activacionLuz =parts[3];
      http.end();
      delay(500);
      //=======================================================================================
      
    } else {
      Serial.println("WiFi Disconnected");
    }

    // Send an HTTP POST request every 30 seconds
    delay(3000);
  }

  float leerTemp(int tiempoTemp){
    sensors.requestTemperatures();
    float temperatureCelsius = sensors.getTempCByIndex(0);
    if(temperatureCelsius>=26){
      //Encendemos el led
      digitalWrite(pin_dos, HIGH);
      alarma = "Encendida" ;
    }else{
      //Apagamos el led
      digitalWrite(pin_dos, LOW);
      alarma = "Apagada" ;
    }
    return temperatureCelsius;
    delay(tiempoTemp);
  }
  float leerNivel(int tiempoNivel){
    float waterLevel = analogRead(ANALOG_PIN); // Lectura del sensor de nivel de agua, lo cambie a float pero iba int
    return waterLevel;
    delay(tiempoNivel);
  }
  float leerPH(int tiempoPH){
    float phValue = analogRead(PH_SENSOR_PIN);
    float voltage = phValue * (3.3 / 4095.0);
    float ph = 3.3 * voltage;
    //Serial.print(ph);
    return ph;
    delay(tiempoPH);
  }
