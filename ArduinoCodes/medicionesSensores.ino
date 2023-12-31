#include <WiFi.h>
#include <HTTPClient.h>
#include <OneWire.h>
#include <DallasTemperature.h>

// Replace with your network credentials
const char* ssid = "Bella Maria";
const char* password = "lucesita284";

// REPLACE with your Domain name and URL path or IP address with path
const char* serverName = "http://192.168.1.105/Aquavida/PHP/post-esp-data.php";

// Keep this API Key value to be compatible with the PHP code provided in the project page.
// If you change the apiKeyValue value, the PHP file /post-esp-data.php also needs to have the same key
String apiKeyValue = "tPmAT5Ab3j7F9";

String sensorName1 = "TemperatureSensor"; // Cambia el nombre del sensor
String sensorName2 = "WaterSensor";
String sensorLocation = "UNICAUCA"; // Cambia la ubicación del sensor
String sensorName3 = "phSensor";

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

    // Your Domain name with URL path or IP address with path
    http.begin(client, serverName);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare your HTTP POST request data
    sensors.requestTemperatures();
    float temperatureCelsius = sensors.getTempCByIndex(0);
    int waterLevel = analogRead(ANALOG_PIN); // Lectura del sensor de nivel de agua

    float phValue = analogRead(PH_SENSOR_PIN);
    float voltage = phValue * (3.3 / 5795.0);
    float ph = 3.3 * voltage;

    String httpRequestData = "api_key=" + apiKeyValue + "&sensor1=" + sensorName1 +
                            "&location=" + sensorLocation + "&value1=" + String(temperatureCelsius) +
                            "&sensor2=" + sensorName2 + "&value2=" + String(waterLevel) +
                            "&sensor3=" + sensorName3 + "&value3=" + String(ph);

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
