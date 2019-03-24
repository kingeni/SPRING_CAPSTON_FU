#include <HX711.h>
#include <st7565.h>
#define DOUT  3
#define CLK  2 
#define sensor 9
HX711 scale(DOUT, CLK);
float calibration_factor = -406620;
float Barrier1 = 50;
float Scale1 = 40;
float Scale2 = 20;
const int trig = 23;
const int echo = 22;
float distance = 0;
float current_float = 0;
unsigned long duration;
int state = 0;
String message;
ST7565 lcd(4,5,6,7,8);
float chuoi[5];
int i = 0;
void setup() {
  pinMode(trig, OUTPUT);  
  pinMode(echo, INPUT);
  pinMode(sensor, INPUT);
  lcd.begin(0x17, 0, 0, 0, 4); //config LCD interface: SET(byte contrast, bool negative, bool rotation, bool mirror, byte resistorRatio );
  lcd.clear();
  Serial.begin(9600);
  scale.set_scale(calibration_factor);
  scale.tare();
}

void loop() 
{
  digitalWrite(trig, 0);   // tắt chân trig
  delayMicroseconds(2);
  digitalWrite(trig, 1);   // phát xung từ chân trig
  delayMicroseconds(5);   // xung có độ dài 5 microSeconds
  digitalWrite(trig, 0);
  duration = pulseIn(echo, HIGH);
  distance = duration / 2 / 29.412;
  //Serial.print(distance);//Xóa khi chạy
  //Serial.println("cm");//Xóa khi chạy
  if (distance >= Scale1 && state == 0)
  {
    lcd.clear();
    lcd.drawUniString(17, 20, Uni(u"Mời vào trạm!"), 1.5,BLACK);
    lcd.display(); 
  }
  if (distance < Scale1 && distance > Scale2 && state ==0){
    //Serial.println("Đóng barrier 1");//đóng barrier 1
    lcd.clear();
    lcd.drawUniString(1, 1, Uni(u"Xin ổn định vị trí!"), 1.5,BLACK);
    lcd.display();
        if (current_float !=0)
        {
        String package = "1|" + String(current_float);
        Serial.println(package);//Gởi trọng lượng qua Raspberry
        i = 0;
        }
        while(Serial.available()==0)
        {
          lcd.clear();
          lcd.drawUniString(1, 1, Uni(u"Mời quẹt thẻ!"), 1.5,BLACK);
          lcd.display();
        }
        if (Serial.available())
        {
           //message = Serial.readString();
           state =1;
           while (state == 1)//message[0] != '3'
           {
              message = Serial.readString();
              if(message.substring(2) == "canNotIdentify\n")
              {
                lcd.clear();
                lcd.drawUniString(1, 1, Uni(u"Không xác định biển số, mời thử lại!"), 1.5,BLACK);
                lcd.display();
              }
              if(message.substring(2) == "errorIdentify\n")
              {
                lcd.clear();
                lcd.drawUniString(1, 1, Uni(u"Không thể xác định biển số, xin chờ xử lý!"), 1.5,BLACK);
                lcd.display();
                delay(2000);
              }
              if(message[0]== '3')
              {
                lcd.clear();
                int e = 25;
                float max_load = message.substring(message.lastIndexOf('|') +1).toFloat();
                float over_load = current_float - max_load;
                lcd.drawUniString(1, 1, Uni(u"Xe"), 1,BLACK);
                for (int i = 0; i < (message.substring(message.indexOf('|') + 1,message.lastIndexOf('|')).length()); i = i +1)
                {
                  lcd.drawAscChar(e, 5, message[message.indexOf('|') + 1 + i], BLACK);
                  e = e + 7;
                }
                lcd.drawUniString(1, 15, Uni(u"Tải trọng"), 1, BLACK);
                lcd.drawNumberFloat(70, 15, current_float, 2 , ASCII_NUMBER, BLACK);
                if ( over_load > 0)
                {
                  lcd.drawUniString(1, 30, Uni(u"Xe quá tải"), 1, BLACK);
                  lcd.drawNumberFloat(70, 30, abs(over_load), 2, ASCII_NUMBER, BLACK);
                }
                else
                {
                  lcd.drawUniString(1, 30, Uni(u"Xe chở đúng tải"), 1.5, BLACK);
                }
                lcd.display();
                delay(2000);
              }
              if (message[0] == '4')
              {
                if(message.substring(2) == "done\n")
                {
                  lcd.clear();
                  lcd.drawUniString(1, 1, Uni(u"Kiểm tra hoàn tất, xe có thể đi tiếp"), 1.5, BLACK);
                  lcd.display();
                  delay(2000);
                  //Mở barrier 2
                  //Serial.println("Đóng barrier 2");//Đóng barrier 2
                  //Serial.println("Mở barrier 1");//Mở barrier 1
                  state = 0;
                }
                if(message.substring(2) == "overLoad\n")
                {   
                  lcd.clear();
                  lcd.drawUniString(1, 1, Uni(u"Xe quá tải, mời ra ngoài đường tránh để hạ tải"), 1.5, BLACK);
                  lcd.display();
                  delay(2000);
                  state = 2;
                }
              }
           }
        }
      }
  if(distance < Scale2 && state == 0){
    lcd.clear();
    lcd.drawUniString(1, 1, Uni(u"Đã đi quá khu vực cân, mời xe lui lại"), 1.5, BLACK);
    lcd.display();
    delay(500);
  }
  if(distance >= Barrier1 && state == 2)
  {
    state = 0;
    //Serial.println("Mở barrier 1");//Mở barier 1
  }
}
