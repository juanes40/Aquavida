  #include <WiFi.h>
  #include <HTTPClient.h>
  #include <OneWire.h>
  #include <DallasTemperature.h>

  // Replace with your network credentials
  const char* ssid = "juRedmi Note 9S";
  const char* password = "Juanes453";

  // REPLACE with your Domain name and URL path or IP address with path
  const char* serverName = "http://192.168.51.102/Aquavida/PHP/post-esp-data.php";

  // Keep this API Key value to be compatible with the PHP code provided in the project page.
  // If you change the apiKeyValue value, the PHP file /post-esp-data.php also needs to have the same key
  String apiKeyValue = "tPmAT5Ab3j7F9";
  int pin_dos = 13;
  String sensorName1 = "TemperatureSensor"; // Cambia el nombre del sensor
  String sensorName2 = "WaterSensor";
  String sensorLocation = "UNICAUCA"; // Cambia la ubicación del sensor
  String sensorName3 = "phSensor";
  String alarma = "Apagada";
  int tiempoTemp = 1000;
  int tiempoNivel = 1000;
  int tiempoPH = 1000;

  #define ONE_WIRE_BUS 4 // Pin donde está conectado el sensor DS18B20
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
  }

  void loop() {
    // Check WiFi connection status
    if (WiFi.status() == WL_CONNECTED) {
      WiFiClient client;
      HTTPClient http;
      http.begin(client, serverName);
      String serverPath = "http://192.168.51.102/Aquavida/PHP/get-esp-data.php";
      String conectar = serverPath+"?api_key="+apiKeyValue+"&tiempo1=tiempotemp"+"&tiempo2=tiemponivel"+"&tiempo3=tiempoph";
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
      String parts[3];
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
      tiempoTemp = parts[0].toInt();
      tiempoNivel = parts[1].toInt();
      tiempoPH = parts[2].toInt();

      http.end();
      delay(500);
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverName);

      // Specify content-type header
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      // Prepare your HTTP POST request data
      float temperatureCelsius = leerTemp(tiempoTemp);
      float waterLevel = leerNivel(tiempoNivel);
      float ph = leerPH(tiempoPH);

      String httpRequestData = "api_key=" + apiKeyValue + "&sensor1=" + sensorName1 +
                              "&location=" + sensorLocation + "&value1=" + String(temperatureCelsius) +
                              "&sensor2=" + sensorName2 + "&value2=" + String(waterLevel) +
                              "&sensor3=" + sensorName3 + "&value3=" + String(ph) + "&tiempotemp="+ String(tiempoTemp) +
                              "&tiemponivel=" + String(tiempoNivel) + "&tiempoph=" + String(tiempoPH) + "";

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
    } else {
      Serial.println("WiFi Disconnected");
    }

    // Send an HTTP POST request every 30 seconds
    delay(30000);
  }

  float leerTemp(int tiempoTemp){
    sensors.requestTemperatures();
    float temperatureCelsius = sensors.getTempCByIndex(0);
    if(temperatureCelsius>=26){
      //Encendemos el led
      digitalWrite(pin_dos, HIGH);
      alarma = "Encendida" ;
      delay(1000);
    }else{
      //Apagamos el led
      digitalWrite(pin_dos, LOW);
      alarma = "Apagada" ;
      delay(1000);
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
    return ph;
    delay(tiempoPH);
  }