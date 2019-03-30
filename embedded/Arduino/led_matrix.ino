#include <SPI.h>        //SPI.h must be included as DMD is written by SPI (the IDE complains otherwise)
#include <DMD.h>        //
#include <TimerOne.h>   //
#include "SystemFont5x7.h"
#include "Arial_Black_16_ISO_8859_1.h"

//Fire up the DMD library as dmd
#define DISPLAYS_ACROSS 3
#define DISPLAYS_DOWN 1
DMD dmd(DISPLAYS_ACROSS, DISPLAYS_DOWN);
char * message ; 
String subStr;
String subStr_1;
String message_1;
String text;
/*--------------------------------------------------------------------------------------
  Interrupt handler for Timer1 (TimerOne) driven DMD refresh scanning, this gets
  called at the period set in Timer1.initialize();
--------------------------------------------------------------------------------------*/
void ScanDMD()
{ 
  dmd.scanDisplayBySPI();
}

void drawMar(const char * MSG){
  dmd.clearScreen( true );
  dmd.selectFont(Arial_Black_16_ISO_8859_1);
  dmd.drawMarquee(MSG,strlen(MSG),(32*DISPLAYS_ACROSS)-1,0);
  long start=millis();
  long timer=start;
  boolean check = true;
  while(check){
    check = Serial1 .available() > 0 ? check = false : check = true;
     if ((timer+30) < millis()) {
       dmd.stepMarquee(-1,0);
       timer=millis();
     }
  }
  dmd.clearScreen(true);
}
void drawText(const char * MSG, int x , int y , const uint8_t* font ){
  dmd.selectFont(font);
  dmd.drawString(x,y, MSG, strlen(MSG), GRAPHICS_NORMAL);
}

void setup(void)
{

   //initialize TimerOne's interrupt/CPU usage used to scan and refresh the display
   Timer1.initialize( 3000 );           //period in microseconds to call ScanDMD. Anything longer than 5000 (5ms) and you can see flicker.
   Timer1.attachInterrupt( ScanDMD );   //attach the Timer1 interrupt to ScanDMD which goes to dmd.scanDisplayBySPI()
  digitalWrite(4, HIGH);
   //clear/init the DMD pixels held in RAM
   dmd.clearScreen( true );   //true is normal (all pixels off), false is negative (all pixels on)
  Serial.begin(9600);
  Serial1.begin(9600);
}
void loop(void)
{
  if(Serial1.available() > 0){
       text = Serial1.readStringUntil('\n');
      //start
      Serial.println(text);
    if(text.substring(0,1) == "1"){
      message = "Xin M""\xfe""i Xe V""\xe0""o Tr""\xfd""m";
       drawMar(message);
    }
    //car in loadcell
    if(text.substring(0,1) == "2"){
      message = "LOADING";
      drawText(message, 1, 0, Arial_Black_16_ISO_8859_1);
    }
    //success
    if(text.substring(0,2) == "30"){\
    dmd.clearScreen(true);
     subStr = text.substring((text.indexOf('|')+1),text.length());
     subStr_1= subStr.substring((subStr.indexOf('|')+1),subStr.length());
     
     message_1 = "TT: "+ subStr_1 ;
     Serial.println(message_1);
     drawText(subStr.substring(0,subStr.indexOf('|')).c_str(), 1, 0, SystemFont5x7);
     drawText(message_1.c_str(), 1, 9, SystemFont5x7);
     drawText("\x21", 68, 0, Arial_Black_16_ISO_8859_1);
    }
    
    //overLoad
    if(text.substring(0,2) == "31"){
    dmd.clearScreen(true);
     subStr = text.substring((text.indexOf('|')+1),text.length());
     subStr_1= subStr.substring((subStr.indexOf('|')+1),subStr.length());
     message_1 = "TT: "+ subStr_1 ;
     Serial.println(message_1);
     drawText(subStr.substring(0,subStr.indexOf('|')).c_str(), 1, 0, SystemFont5x7);
     drawText(message_1.c_str(), 1, 9, SystemFont5x7);
     drawText("\x22", 68, 0, Arial_Black_16_ISO_8859_1);
    }
    //go strange
    if(text.substring(0,1) == "4"){
      message = "Th""\xf9""\xfb""ng L""\xf4"" B""\xec""nh An";
      drawMar(message);
    }
    if(text.substring(0,1) == "5"){
      message = "Qu""\xe1"" T""\xff""i Tr""\xfc""ng Xin ""\x44""i Qua >>>";
      drawMar(message);
    }
  }
}
