#include <ESP8266WiFi.h>
#include <PubSubClient.h>

const char* mqtt_server = "test.mosquitto.org";
WiFiClient espclient;

void callback(char* topic, byte* payload, unsigned int length1){
  Serial.print("Message arrived[");
  Serial.print(topic);
  Serial.println("]");

  for (int i=0;i<length1;i++){
    Serial.print(payload[i]);
  }

  if (payload[0] == 49) digitalWrite(2, HIGH);
  else if (payload[0] == 50) digitalWrite(2, LOW);
  Serial.println();
}

PubSubClient client(mqtt_server,1883,callback,espclient);

void setup() {
  pinMode(2, OUTPUT);
  Serial.begin(115200);
  Serial.print("Connecting");
  WiFi.begin("ssid","pass");
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }
  Serial.println();
  _reconnect();
}



void _reconnect(){
  while (WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }

  while(!client.connected()){
    if(client.connect("ESP8266Client123456789")){
      Serial.println("connected");
      client.subscribe("ledcontrol");
    } else {
      Serial.print("falied, rc = ");
      Serial.println(client.state());
      delay(500);
    }
  }
}

void loop() {
  if(!client.connected()){
    _reconnect();
  }

  client.loop();
}
