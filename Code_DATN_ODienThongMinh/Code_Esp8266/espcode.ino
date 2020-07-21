#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SoftwareSerial.h>
SoftwareSerial swSer(14, 12);//r,t
#define LED 2
const char* ssid     = "SGT_Student";
const char* password = "123456789";
const char* host = "datn.comxa.com";
const int port = 80;
const char* uri = "/thuong.php";
void setup() {
  Serial.begin(9600);
  delay(10);
  swSer.begin(9600);
  pinMode(LED,OUTPUT);
  digitalWrite(LED,1);
  //swSer.print("\nConnecting to ");
  //swSer.println(ssid);
  WiFi.begin(ssid, password); 
  while (WiFi.status() != WL_CONNECTED) {    
    delay(500);    
  }
  digitalWrite(LED,0);
  //Serial.println("OK");
}
void loop() {
  ESP.wdtDisable();
  //Serial.println("aa");  
  if(Serial.available()>0)
  {
    ESP.wdtDisable();
    //swSer.println("Nhan TH tu Arduino"); 
    String cmd = Serial.readStringUntil('\n');
    delay(200);
    //swSer.printf("RECV Form Arduino...:%s\n",cmd.c_str());     
    if(cmd.indexOf("tag")!=-1)
    {
      //ESP.wdtDisable();
      String r = sendForResponse(host,port,uri,cmd);
      Serial.println(r);  
      //swSer.printf("TRAN to Arduino...:%s\n",r.c_str());  
    }
  }   
}

String sendForResponse(String mhost, int mport, String muri,String mbody){
  HTTPClient http;  
  http.begin(mhost,mport,muri); //HTTP
  http.addHeader("Host",host);
  http.addHeader("Content-Type","application/x-www-form-urlencoded");
  http.addHeader("Accept","*/*");
  http.addHeader("Connection","close");
  int httpCode = http.POST(mbody);
  delay(300);// Gửi dữ liệu đi
  if(httpCode > 0) {
    //swSer.println("Da gui du lieu...");                  
    return http.getString();  //Dữ liệu trả về từ web ( thuong.php)
    //swSer.println(http.getString());     
  }
  return "";
}

