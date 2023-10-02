#include <WiFi.h>
#include <HTTPClient.h>
#include <Arduino_JSON.h>
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <OneWire.h>
#include <DallasTemperature.h>

// Replace with your network credentials
const char* ssid = "juRedmi Note 9S";
const char* password = "Juanes453";
int value = 0;
// REPLACE with your Domain name and URL path or IP address with path
const char* serverName = "http://192.168.247.102//Practica1DHT11//post-esp-data.php"; //VERIFICAR EL IP

// Keep this API Key value to be compatible with the PHP code provided in the project page. 
// If you change the apiKeyValue value, the PHP file /post-esp-data.php also needs to have the same key 
String apiKeyValue = "tPmAT5Ab3j7F9";
int pin_dos = 2;
String sensorName = "DS18B20";
String sensorName2 = "SE045";
String alarma = "Apagada" ;
String sensorLocation = "UNICAUCA";
String outputsState;
int retardo;
int deley = 30000;
//---------------
const int oneWireBus = 4;
OneWire oneWire(oneWireBus);
DallasTemperature sensors(&oneWire);
#define POWER_PIN  18 // ESP32 pin GPIO17 connected to sensor's VCC pin
#define SIGNAL_PIN 34 // ESP32 pin GPIO36 (ADC0) connected to sensor's signal pin
//--------------

#define SEALEVELPRESSURE_HPA (1013.25)
#define DHTPIN 27     // Digital pin connected to the DHT sensor
// Uncomment the type of sensor in use:
#define DHTTYPE    DHT11     // DHT 11
//#define DHTTYPE    DHT22     // DHT 22 (AM2302)

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(115200);
  //------------
  sensors.begin();
  pinMode(pin_dos, OUTPUT);
  pinMode(POWER_PIN, OUTPUT);   // configure pin as an OUTPUT
  digitalWrite(POWER_PIN, LOW); // turn the sensor OFF
  //-----------
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  
}

void loop() {
  //-----------
  sensors.requestTemperatures(); 
  float temperatureC = sensors.getTempCByIndex(0);
  digitalWrite(POWER_PIN, HIGH);  // turn the sensor ON
  delay(10);                      // wait 10 milliseconds
  value = analogRead(SIGNAL_PIN); // read the analog value from sensor
  digitalWrite(POWER_PIN, LOW);   // turn the sensor OFF

   if(temperatureC>=25){
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
  //------------
  //Check WiFi connection status
  if(WiFi.status()== WL_CONNECTED){
    WiFiClient client;
    HTTPClient http;
    String serverPath = "http://192.168.247.102//Practica1DHT11//post-esp-data.php";  //Direccion para trabajar el metodo GET es similar a serverName
    
    String conectar = serverPath+"?api_key="+apiKeyValue+"&var=tiempo";
    http.begin(client, conectar.c_str());
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpResponseCodeGet = http.GET();
  
    String payload = "{}"; 
  
    if (httpResponseCodeGet>0) {
      Serial.print("HTTP Response code GET: ");
      Serial.println(httpResponseCodeGet);
      retardo = http.getString().toInt();
      Serial.println(retardo);
    }
    else {
      Serial.print("Error code GET: ");
      Serial.println(httpResponseCodeGet);
    }
    http.end();
               //==================================================================================================================================
    delay(500);//==================================================================================================================================
    // Specify content-type header
    http.begin(client, serverPath);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  // Prepare your HTTP POST request data
   String httpRequestData = "api_key=" + apiKeyValue + "&sensor1=" + sensorName
                          + "&location=" + sensorLocation + "&value1=" + String(temperatureC)
                          + "&sensor2=" + sensorName2 + "&value2=" + String(value) + "&tiempo=" + String(deley) + "&alarma="  + alarma;
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
    int httpResponseCode = http.POST(httpRequestData);
    if (httpResponseCode>0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every retardo seconds
  
  delay(retardo);  
}