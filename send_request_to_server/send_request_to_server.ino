#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WebServer.h>
#include <WiFiClient.h>
#include <Wire.h> // Include Wire library for I2C
#include <hd44780.h> // Include hd44780 library
#include <hd44780ioClass/hd44780_I2Cexp.h> // Include I2C expander class
#include <DHT11.h> // Include DHT11 library

#define DHTPIN D3 // Define the pin where the DHT11 is connected
#define DHTVCCPIN D6 // Define the vcc pin to turn the DHT11 ON
#define RELAY_PIN D4 // Define relay pin to turn ON/OFF ac
#define greenLedPin D5 // Define relay green red pin pin for wifi indicator
#define redLedPin D8 // Define relay green red pin pin for wifi indicator

const char* ssid = "CANALBOX-333B-2G"; // set wifi name
const char* password = "Idatech@02525"; //set wifi password

const char* serverName = "http://192.168.1.65/maize/post.php/"; //set public address of ip v4 with path/project

WiFiClient wifiClient;
ESP8266WebServer server(80);

DHT11 dht11(DHTPIN); // Create an instance of the DHT11 class
hd44780_I2Cexp lcd; // Declare the lcd object

String acStatus ="ON";
  
void handleRoot() {
  // Do nothing
}

void handleOn() {
  digitalWrite(RELAY_PIN, HIGH);
  server.send(200, "text/plain", "Relay turned on");
  acStatus="ON";
}

void handleOff() {
  digitalWrite(RELAY_PIN, LOW);
  server.send(200, "text/plain", "Relay turned off");
  acStatus="OFF";
}

void sendSensor() {
  int temperature = 0;
  int humidity = 0;

  // Attempt to read the temperature and humidity values from the DHT11 sensor.
  int result = dht11.readTemperatureHumidity(temperature, humidity);

  // Clear the LCD before writing new data
  lcd.clear();

  // Check the results of the readings.
  // If the reading is successful, print the temperature and humidity values.
  if (result == 0) {
   
    // Send the data to the server
    if (WiFi.status() == WL_CONNECTED) {
      if (temperature < 10) {
         if(acStatus == "ON"){
          digitalWrite(RELAY_PIN, LOW);
           acStatus = "OFF";
        }
       
        
      
        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print("Ac status: ");
        lcd.print(acStatus);
      } if(temperature >15) {
       
        Serial.println("Status on");
        if(acStatus == "ON"){
          digitalWrite(RELAY_PIN, HIGH);
           acStatus = "ON";
        }
        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print("AC status: ");
        lcd.print(acStatus);
      }
delay(2000);
lcd.clear();
       Serial.print("Temperature: ");
    Serial.print(temperature);
    Serial.print(" °C\tHumidity: ");
    Serial.print(humidity);
    Serial.println(" %");

    // Print the results to the LCD
    lcd.setCursor(0, 0);
    lcd.print("Temperature: ");
    lcd.print(temperature);
    lcd.print("c");
    lcd.setCursor(0, 1);
    lcd.print("Humidity: ");
    lcd.print(humidity);
    lcd.print("%");

      HTTPClient http;
      http.begin(wifiClient, serverName);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      String postData = "temperature=" + String(temperature) + "&humidity=" + String(humidity) + "&status=" + acStatus;
      int httpResponseCode = http.POST(postData);

      if (httpResponseCode > 0) {
        String response = http.getString();
        Serial.println("HTTP Response Code: " + String(httpResponseCode));
        Serial.println("Response from server: " + response);
      } else {
        Serial.println("Error sending POST request");
      }

      http.end();
    } else {
      Serial.println("WiFi disconnected");
    }
  } else {
    // Print error message based on the error code.
    Serial.println(DHT11::getErrorString(result));
    // Display the error message on the LCD
    lcd.setCursor(0, 0);
    lcd.print("Error reading");
    lcd.setCursor(0, 1);
    lcd.print("sensor data");
  }
}

void setup() {
  pinMode(greenLedPin, OUTPUT);
   pinMode(redLedPin, OUTPUT);
  pinMode(DHTVCCPIN, OUTPUT);
  pinMode(RELAY_PIN, OUTPUT);
  digitalWrite(DHTVCCPIN, HIGH);
   digitalWrite(redLedPin, HIGH); //set red LED ONN when device pluged onn
  Serial.begin(9600); // Initialize serial communication for debugging
  lcd.begin(16, 2); // Initialize the LCD with 16 columns and 2 rows
  lcd.setBacklight(HIGH); // Turn on the LCD backlight

  lcd.setCursor(1, 0);
  lcd.print("Preventing Maize weevils.!");
  lcd.setCursor(3, 1);
  lcd.print("Using IOT.!");

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
     
  }
  digitalWrite(greenLedPin, HIGH);
  Serial.println("Connected to WiFi");

  server.on("/", handleRoot);
  server.on("/on", handleOn);
  server.on("/off", handleOff);

  server.begin();
  Serial.println("HTTP server started");
}

void loop() {
  sendSensor();
  server.handleClient();
  delay(1000); // Delay between sensor readings
}
