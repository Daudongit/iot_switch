
#include <LiquidCrystal.h>
LiquidCrystal lcd(3, 4, 5, 6, 7, 8);

const int relay1=12;
const int relay2=11;
const int relay3=10;
const int relay4=9;

 
boolean wifi_status();
void httpget();
boolean server_connected();
boolean connectWiFi();
boolean cwmode3();
boolean cipmux0();




char ssid[] = "LASPO TELECOM";            // your network SSID (name)
char pass[] = "14061120";        // your network password


char server1[] = "darmocruise.000webhostapp.com";
String uri = "  IOT/relayCheck.php";
char c;
int loops = 0;  //a counter for testing
boolean connect_ok;
String  cmd;
char data[16], dat;

unsigned long lastConnectionTime = 0;         // last time you connected to the server, in milliseconds
const unsigned long postingInterval = 1000L; // delay between updates, in milliseconds



void setup(void)
{
  pinMode(relay1,OUTPUT);
  pinMode(relay2,OUTPUT);
  pinMode(relay3,OUTPUT);
  pinMode(relay4,OUTPUT);
  
  digitalWrite(relay1,LOW);
  digitalWrite(relay2,LOW);
  digitalWrite(relay3,LOW);
  digitalWrite(relay4,LOW);
  
  Serial.begin(115200);
  //Serial1.begin(115200);
  lcd.begin(16, 2);
  lcd.clear();
  delay(1000);
  lcd.setCursor(0, 0);
  lcd.print("Booting...");
  delay(500);
  if (wifi_status()==false) {
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.print("WiFi not present");
      while (true);
  }
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Connecting...");
  lcd.setCursor(0, 1);
  lcd.print(ssid);
  boolean wifi_connected=false;  //not connected yet...
  for(int i=0;i<99;i++)    //attempt 99 times to connect to wifi - this is a good idea
  {
    if(connectWiFi())  //are we connected?
    {
      wifi_connected = true;  //yes
      break;              //get outta here!
    }
  }
  if (!wifi_connected) 
  { 
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Connected");
  while(1);
  }
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print ("Connected to:");
   lcd.setCursor(0, 1);
  lcd.print (ssid);
  delay(1000);
  delay(1000);
  lcd.clear();
}
void loop(void)
{
 lcd.setCursor(0, 0); 
 lcd.print("Home Automation");
 lcd.setCursor(0, 1);
 lcd.print("of 4 Appliance");
  delay(2000);
 lcd.clear();
 lcd.setCursor(0, 0); 
 lcd.print("(c) Telecom Team");
 lcd.setCursor(0, 1);
 lcd.print("       2017");
 delay(2000);
  httpget();
  lastConnectionTime = millis();
  lcd.clear();
}
void httpget()
{
 if(server_connected(server1)==true)
  { 
     lcd.clear();
     lcd.setCursor(0, 0);
     lcd.print ("Connected to:");
     lcd.setCursor(0, 1);
     lcd.print  (server1);
   cmd =  "GET /IOT/relayCheck.php HTTP/1.0\r\n";
   cmd += "Host: darmocruise.000webhostapp.com\r\n\r\n";
    
    Serial.print("AT+CIPSEND=");                //www.cse.dmu.ac.uk/~sexton/test.txt
    Serial.println(cmd.length());  //esp8266 needs to know message length of incoming message - .length provides this
    delay(10);
    if(Serial.find(">"))    //prompt offered by esp8266
    {
     Serial.println(cmd);  //this is our http GET request
    }
  }
   else
  {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print  ("no response!:");
    delay(1000);
  }
   Serial.println("AT+CIPCLOSE");
  //delay(10);
 if (Serial.find("Relay")) //get the date line from the http header (for example)
 { 
   int i=1;
   while(i<15){ 
    while (!Serial.available());
           c=Serial.read();
           data[i]=c;
           i++;
       //   Serial.print(c);
    }
   lcd.clear();
   lcd.setCursor(0, 0);
  lcd.print  ("Downloaded  file");
  lcd.setCursor(0, 1);
  for(int i =1;i <5;i++){
    lcd.print(data[i]);
  }
  if(data[1]=='1'){ digitalWrite(relay1,HIGH); }  else{  digitalWrite(relay1,LOW); }
  
  if(data[2]=='1'){ digitalWrite(relay2,HIGH); }  else{  digitalWrite(relay2,LOW); }
  
  if(data[3]=='1'){ digitalWrite(relay3,HIGH); }  else{  digitalWrite(relay3,LOW); }
  
  if(data[4]=='1'){ digitalWrite(relay4,HIGH); }  else{  digitalWrite(relay4,LOW); } 
}
 delay(1500);
 Serial.flush();
}

//============================================

//============================================
  boolean server_connected(char *server)
  {
   boolean success=false;
   String cmd = "AT+CIPSTART=\"TCP\",\"";  //make this command: AT+CPISTART="TCP","146.227.57.195",80
   cmd += server;
   cmd += "\",80";
   Serial.println(cmd);
   delay(1000);
   
   if(Serial.find("CONNECT"))  //message returned when connection established WEAK SPOT!! DOESN'T ALWAYS CONNECT
  {
   success= true;
  }
   return success;
  }
boolean connectWiFi()
{
  String cmd="AT+CWJAP=\"";  //form eg: AT+CWJAP="HACKER","123456789"
  cmd+=ssid;
  cmd+="\",\"";
  cmd+=pass;
  cmd+="\"";
  Serial.println(cmd);
  delay(2000); //give it time - my access point can be very slow sometimes
  if(Serial.find("OK"))  //healthy response
  {
    return true;
  }
  else
  {   
    return false;
  }
}
boolean wifi_status()
 {  
  boolean ok=false;
  for(int i=0;i<15;i++){  
   Serial.println("AT+RST");
   delay(100);
  if (Serial.find("ready"))
  {
   ok=true;
   break;
  }
  }
  return ok;
}
//=====================================================

//=====================================================
boolean cwmode3()
// Odd one. CWMODE=3 means configure the device as access point & station. This function can't fail?

{
  Serial.println("AT+CWMODE=3");
  if (Serial.find("no change"))  //only works if CWMODE was 3 previously
  {
    return true;
  }
  else
  {
    return false;
  }
}
boolean cipmux0()
{
  Serial.println("AT+CIPMUX=0");
  if (Serial.find("OK"))
  {
    return true;
  }
  else
  {
    return false;
  }
}
boolean cipmode0()
{
  Serial.println("AT+CIPMODE=0");
  if (Serial.find("OK"))
  {
    return true;
  }
  else
  {
    return false;
  }
}