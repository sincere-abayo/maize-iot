#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>
ESP8266WebServer server(80);
// Replace with your WiFi credentials
const char* ssid = "Xperia XZ1_1faa";
const char* password = "sony_1234.";
// LED Pin
const int relayPin = D4; // GPIO2

void handleRoot() {
  // Do nothing
}

void handleOn() {
  digitalWrite(relayPin, HIGH);
  server.send(200, "text/plain", "LED turned on");
}

void handleOff() {
  digitalWrite(relayPin, LOW);
  server.send(200, "text/plain", "LED turned off");
}
void setup() {

  Serial.begin(115200);
  pinMode(relayPin, OUTPUT);
  digitalWrite(relayPin, HIGH); // Initialize LED to off
  delay(3000);
 digitalWrite(relayPin, LOW);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

  server.on("/", handleRoot);
  server.on("/on", handleOn);
  server.on("/off", handleOff);

  server.begin();
  Serial.println("HTTP server started");
}

void loop() {
  server.handleClient();
}