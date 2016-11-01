// basis date is used to convert real time to game time.
// Use UTC functions to allow calculations to work for any timezone
basisDate = new Date();
basisDate.setUTCFullYear(2002, 5, 23); // Set date to 2003-06-23
basisDate.setUTCHours(15, 0, 0, 0);    // Set time to 15:00:00.0000

// moon date is used to determien the current phase of the moon.
// Use UTC functions to allow calculations to work for any timezone
Mndate = new Date();
Mndate.setUTCFullYear(2004, 0, 25); // Set date to 2004-01-25
Mndate.setUTCHours(2, 31, 12, 0);    // Set time to 02:31:12.0000

// basis date for RSE calculations
//RSEdate = new Date();
//RSEdate.setUTCFullYear(2004, 0, 28); // Set date to 2004-01-28
//RSEdate.setUTCHours(9, 14, 24, 0);    // Set time to 09:14:24.0000

// basis date for day of week calculations
Daydate = new Date();
Daydate.setUTCFullYear(2004, 0, 28); // Set date to 2004-01-28
Daydate.setUTCHours(9, 14, 24, 0);    // Set time to 09:14:24.0000

EarthDay = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
VanaDay = new Array("Firesday", "Earthsday", "Watersday", "Windsday", "Iceday", "Lightningday", "Lightsday", "Darksday");
DayIcon = new Array("w_fire.png", "w_earth.png", "w_water.png", "w_wind.png", "w_ice.png", "w_lightning.png", "w_light.png", "w_dark.png");
DayClosed = new Array("Weavers' Guild<br>Carpenters' Guild<br>San d'Orian Goblin Vendors", "Tenshodo Guild", "Smithing Guild", "Boneworkers' Guild<br>Bastokan Goblin Vendors", "Goldsmithing Guild<br>Tanners' Guild", "Fishing Guild", "Alchemist Guild<br>Windurstian Goblin Vendors", "Culinarian Guild");
weakMagic = new Array("Ice","Lightning","Fire","Earth","Wind","Water","Darkness","Light");
weakIcon = new Array("ws_ice.png", "ws_lightning.png", "ws_fire.png", "ws_earth.png", "ws_wind.png", "ws_water.png", "ws_dark.png", "ws_light.png");
PhaseName = new Array("Full Moon","Waning Gibbous","Last Quarter","Waning Crescent","New Moon","Waxing Crescent","First Quarter","Waxing Gibbous");
PhaseIcon = new Array("m_full.png","m_wangibbous.png","m_last.png","m_wancrescent.png","m_new.png","m_waxcrescent.png","m_first.png","m_waxgibbous.png");

sMonth = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
//RSErace = new Array("M. Hume","F. Hume","M. Elvaan","F. Elvaan","M. TaruTaru","F. TaruTaru","Mithra","Galka");
//RSEloc = new Array("Gusgen Mines","Shakrami Maze","Ordelle Caves");
//BoatSched = new Array("08:00", "16:00", "00:00");
//BoatSched2 = new Array("06:30", "14:30", "22:30");
//BoatDayOffset = new Array(0,0,7);

msGameDay	= (24 * 60 * 60 * 1000 / 25); // milliseconds in a game day
msRealDay	= (24 * 60 * 60 * 1000); // milliseconds in a real day

//balJug = new Array("","Entry ","Match ","Closing Ceremony ","","");
//balPas = new Array("", "", "", "Entry ","Match ","Closing Ceremony ");
//balMer = new Array("Match ","Closing Ceremony ", "", "", "", "Entry ");
//balJugTeam = new Array("San D'oria vs Bastok", "Bastok vs Windurst", "San D'oria vs Windurst");
//balPasTeam = new Array("Bastok vs Windurst", "San D'oria vs Windurst", "San D'oria vs Bastok");
//balMerTeam = new Array("San D'oria vs Windurst", "San D'oria vs Bastok", "Bastok vs Windurst");
lastvTime = "";
lastvDate = "";
lastvGuild = "";
lastMoon = "";


//**************
// Functions  **
//**************


function getVanadielTime()  {
   var now = new Date();
   vanaDate =  ((898 * 360 + 30) * msRealDay) + (now.getTime() - basisDate.getTime()) * 25;

   vYear = Math.floor(vanaDate / (360 * msRealDay));
   vMon  = Math.floor((vanaDate % (360 * msRealDay)) / (30 * msRealDay)) + 1;
   vDate = Math.floor((vanaDate % (30 * msRealDay)) / (msRealDay)) + 1;
   vHour = Math.floor((vanaDate % (msRealDay)) / (60 * 60 * 1000));
   vMin  = Math.floor((vanaDate % (60 * 60 * 1000)) / (60 * 1000));
   vSec  = Math.floor((vanaDate % (60 * 1000)) / 1000);
   vDay  = Math.floor((vanaDate % (8 * msRealDay)) / (msRealDay));

   if (vYear < 1000) { VanaYear = "0" + vYear; } else { VanaYear = vYear; }
   if (vMon  < 10)   { VanaMon  = "0" + vMon; }  else { VanaMon  = vMon; }
   if (vDate < 10)   { VanaDate = "0" + vDate; } else { VanaDate = vDate; }
   if (vHour < 10)   { VanaHour = "0" + vHour; } else { VanaHour = vHour; }
   if (vMin  < 10)   { VanaMin  = "0" + vMin; }  else { VanaMin  = vMin; }
   if (vSec  < 10)   { VanaSec  = "0" + vSec; }  else { VanaSec  = vSec; }
   VanaDate = vDate;
   VanaHour = vHour;

   VanaTimeDate = sMonth[vMon] + " " + VanaDate + " " + VanaYear;
   VanaTime = "<img class='clock' src='images/icons/" + DayIcon[vDay] + "'>" + VanaHour + ":" + VanaMin;
   VanaTimeDate_New = VanaDay[vDay] + ", " + VanaTimeDate;
   //VanaGuilds = "<a id='tip' href='#' class='time'>" + " <span><table><tr><td>Weak:&nbsp;</td><td style='color:#74736d;'><img style='vertical-align:text-bottom;position:relative;top:-2px' src='images/icons/" + weakIcon[vDay] + "'><br></td></tr><tr><td>Closed:&nbsp;</td><td style='color:#74736d;'>" + DayClosed[vDay] + "</td></tr></table></span></a>";
   VanaGuilds = "<table><tr style=\"vertical-align:text-top\"><td align=\"right\"><img class=\"clock\" src=\"images/icons/14400.png\" />Closed:&nbsp;</td><td>&nbsp;</td><td style=\"color:#74736d;text-align:left\">" + DayClosed[vDay] + "</td></tr></table>";
//   VanaTime += VanaYear + "/" + VanaMon + "/" + VanaDate + "  " + VanaHour + ":" + VanaMin;
   if (lastvTime != VanaTime) {
      document.getElementById("vTime").innerHTML = VanaTime;
      lastvTime = VanaTime;
      //console.log("Updated vTime!");
   }
   if (lastvDate != VanaTimeDate_New) {
      document.getElementById("vDate").innerHTML = VanaTimeDate_New;
      lastvDate = VanaTimeDate_New;
      //console.log("Updated vDate!");
   }
   if (lastvGuild != VanaGuilds) {
      document.getElementById("closed").innerHTML = VanaGuilds;
      lastvGuild = VanaGuilds;
      //console.log("Updated closed!");
   }
}

function getEarthTime()  {
   var now = new Date();
   earthTime = formatDate(now.getTime(), 1);
   document.getElementById("eTime").innerHTML = earthTime;
}

function getMoonPhase()  {
   var timenow = new Date();
   var localTime = timenow.getTime();
   var moonDays = (Math.floor((localTime - Mndate.getTime()) / msGameDay))  % 84;

   var mnElapsedTime = (localTime - Mndate.getTime()) % msGameDay;

   // determine phase percentage
         moonpercent = - Math.round((42 - moonDays) / 42 * 100);
         if (moonpercent <= -94)  {
            mnPhase = 0;
            optPhase = 4;
            toNextPhase = (3 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (38 - moonDays) * msGameDay - mnElapsedTime;

         }  else if (moonpercent >= 90)  {
	    mnPhase = 0;
            optPhase = 4;
            toNextPhase = (87 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (38 + 84 - moonDays) * msGameDay - mnElapsedTime;

         }  else if (moonpercent >= -93 && moonpercent <= -62)  {
	      mnPhase = 1;
            optPhase = 4;
            toNextPhase = (17 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (38 - moonDays) * msGameDay - mnElapsedTime;

         }  else if (moonpercent >= -61 && moonpercent <= -41)  {
	      mnPhase = 2;
            optPhase = 4;
            toNextPhase = (25 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (38 - moonDays) * msGameDay - mnElapsedTime;

         }  else if (moonpercent >= -40 && moonpercent <= -11)  {
	      mnPhase = 3;
            optPhase = 4;
            toNextPhase = (38 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (38 - moonDays) * msGameDay - mnElapsedTime;

         }  else if (moonpercent >= -10 && moonpercent <= 6)  {
	      mnPhase = 4;
            optPhase = 0;
            toNextPhase = (45 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (80 - moonDays) * msGameDay - mnElapsedTime;

         }  else if (moonpercent >= 7 && moonpercent <= 36)  {
	      mnPhase = 5;
            optPhase = 0;
            toNextPhase = (58 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (80 - moonDays) * msGameDay - mnElapsedTime;

         }  else if (moonpercent >= 37 && moonpercent <= 56)  {
	      mnPhase = 6;
            optPhase = 0;
            toNextPhase = (66 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (80 - moonDays) * msGameDay - mnElapsedTime;

         }  else if (moonpercent >= 57 && moonpercent <= 89)  {
	      mnPhase = 7;
            optPhase = 0;
            toNextPhase = (60 - moonDays) * msGameDay - mnElapsedTime;
            toOptimalPhase = (80 - moonDays) * msGameDay - mnElapsedTime;
         }

         mnpercent = PhaseName[mnPhase] + " (" + Math.abs(moonpercent) + "%)";

//         if (moonpercent <= 5 && moonpercent >= -10)  {
//              mnpercent = "<FONT COLOR='#FF0000'>" + mnpercent+ "</FONT>";
//         } else if (moonpercent >= 90 || moonpercent <= -95)  {
//              mnpercent = "<FONT COLOR='#0000FF'>" + mnpercent+ "</FONT>";
//         }

   nextPhase = "Next phase (" + PhaseName[(mnPhase + 1) % 8] + "): " + formatCountdown(toNextPhase);
//   nextOptPhase = "Next " + PhaseName[optPhase] + ": " + formatCountdown(toOptimalPhase);
   nextOptPhase = "Next " + PhaseName[optPhase] + ": " + formatNextmoon(toOptimalPhase);

//   document.getElementById("mPhase").innerHTML = mnpercent + nextPhase + "<BR>" + nextOptPhase;


   var fullMoonBasis = Mndate.getTime() + (3 * msGameDay);

   i = 1;
   elapsedCycles = Math.floor( (localTime - fullMoonBasis) / (84 * msGameDay) ) + i;
   FullEnd = fullMoonBasis + (elapsedCycles * 84 * msGameDay);
   //Full Moon starts 7 games days prior to end
   FullStart = FullEnd - 7 * msGameDay;
   //New Moon starts 49 games days prior to Full Moon end
   NewStart = FullEnd - 49 * msGameDay;
   //New Moon ends 42 games days prior to Full Moon end
   NewEnd = FullEnd - 42 * msGameDay;

//   moonCal = "<table><tr><td>Next Full Moon: &nbsp;</td><td style='color:#74736d;'>" + formatMoonDate(FullStart,2) + " &#x2500; " + formatMoonDate(FullEnd, 2) + "</td></tr></table>";
   moonCal = "<table><tbody><tr><td>New Moon: &nbsp;</td><td style='color:#74736d;'>" + formatMoonDate(NewStart,2) + "</td></tr><tr><td>Full Moon: &nbsp;</td><td style='color:#74736d;'>" + formatMoonDate(FullStart,2) + "</td></tr></tbody></table>";
   htmlTmp = "<img class='clock' src='images/icons/" + PhaseIcon[mnPhase] + "'>" + mnpercent + ""
   if (lastMoon != htmlTmp) {
      lastMoon = htmlTmp;
      document.getElementById("mPhase").innerHTML = htmlTmp;
      //console.log("Updated mPhase!");
   }
   
//   document.getElementById("mCalendar").innerHTML = moonCal;
}

function formatCountdown(varTime) {

   var dayLeft = varTime / msRealDay;
   var hourLeft = (dayLeft - Math.floor(dayLeft)) * 24;
   var minLeft = (hourLeft - Math.floor(hourLeft)) * 60;
   var secLeft = Math.floor((minLeft - Math.floor(minLeft)) * 60);
   var formattedTime = '';

   dayLeft = Math.floor(dayLeft);
   hourLeft = Math.floor(hourLeft);
   minLeft = Math.floor(minLeft);

   if (minLeft < 10) {minLeft = '0' + minLeft;}
   if (secLeft < 10) {secLeft = '0' + secLeft;}

   if (dayLeft > 0) {
      formattedTime = dayLeft + ':';
      if (hourLeft < 10) {
         formattedTime = formattedTime + '0' + hourLeft + ':';
      } else {
         formattedTime = formattedTime + hourLeft + ':';
      }
   } else if (hourLeft > 0) {
      formattedTime = hourLeft + ':';
   }

   formattedTime = formattedTime + minLeft + ':' + secLeft;
   return formattedTime;
}

function formatNextmoon(varTime) {

   var dayLeft = varTime / msRealDay;
   var hourLeft = (dayLeft - Math.floor(dayLeft)) * 24;
   var minLeft = (hourLeft - Math.floor(hourLeft)) * 60;
   var secLeft = Math.floor((minLeft - Math.floor(minLeft)) * 60);
   var formattedTime = '';

   dayLeft = Math.floor(dayLeft);
   hourLeft = Math.floor(hourLeft);
   minLeft = Math.floor(minLeft);

   if (minLeft < 10) {minLeft = '0' + minLeft;}
   if (secLeft < 10) {secLeft = '0' + secLeft;}

   if (dayLeft > 0) {
      formattedTime = dayLeft + ':';
      if (hourLeft < 10) {
         formattedTime = formattedTime + '0' + hourLeft + ':';
      } else {
         formattedTime = formattedTime + hourLeft + ':';
      }
   } else if (hourLeft > 0) {
      formattedTime = hourLeft + ':';
   }

   formattedTime = formattedTime + minLeft;
   return formattedTime;
}

function formatDate(varTime, showDay) {

   var varDate = new Date(varTime);
   var yyyy = varDate.getYear();

   var mm = varDate.getMonth() + 1;
   if (mm < 10) { mm = "0" + mm; }

   var dd = varDate.getDate();
   if (dd < 10) { dd = "0" + dd; }

   var day = varDate.getDay();

   var hh = varDate.getHours();

   if (hh < 10) { hh = "0" + hh; }

   var min = varDate.getMinutes();
   if (min < 10) { min = "0" + min; }

   var ss = varDate.getSeconds();
   if (ss < 10) { ss = "0" + ss; }

   if (showDay == 1)  {
      dateString = EarthDay[day] + ", " + sMonth[mm-1] + ' ' + dd + ', ' + yyyy + " " + hh + ":" + min + ":" + ss;
   } else if (showDay == 2)  {
      dateString = sMonth[mm-1] + " " + dd + ",  " + hh + ":" + min + ":" + ss;
   }
   return dateString;
}

function formatMoonDate(varTime, showDay) {

   var varDate = new Date(varTime);
   var yyyy = varDate.getYear();

   var mm = varDate.getMonth() + 1;
   if (mm < 10) { mm = "0" + mm; }

   var dd = varDate.getDate();
   if (dd < 10) { dd = "0" + dd; }

   var day = varDate.getDay();

   var hh = varDate.getHours();

//   if (hh < 10) { hh = "0" + hh; }

   var min = varDate.getMinutes();
   if (min < 10) { min = "0" + min; }

   var ss = varDate.getSeconds();
   if (ss < 10) { ss = "0" + ss; }

   var tz = -varDate.getTimezoneOffset()/60;

   if (showDay == 1)  {
      dateString = EarthDay[day] + ", " + sMonth[mm-1] + ' ' + dd + ', ' + yyyy + " " + hh + ":" + min + ":" + ss;
   } else if (showDay == 2)  {
      dateString = sMonth[mm-1] + " " + dd + ",  " + hh + ":" + min + " GMT" + tz;
   }
   return dateString;
}

function printPage() {
   getVanadielTime();
//   getEarthTime();
   getMoonPhase();
//   getRSE();
//   getConquest();
//   getShipSched();
//   getDaySched();
//   getGuildHours();
//   getAirSched();
   setTimeout("printPage()", 500);
}

function vanaClock() {
    getVanadielTime();
    getMoonPhase();
    setTimeout("vanaClock()", 500);
}



// -->