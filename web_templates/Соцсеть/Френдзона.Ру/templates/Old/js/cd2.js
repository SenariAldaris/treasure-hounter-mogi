function CountBack2(secs) {
  if (secs < 0) {
    document.getElementById("cntdwn2").innerHTML = FinishMessage2;
    return;
  }
  DisplayStr = DisplayFormat2.replace(/%%D%%/g, calcage(secs,86400,100000));
  DisplayStr = DisplayStr.replace(/%%H%%/g, calcage(secs,3600,24));
  DisplayStr = DisplayStr.replace(/%%M%%/g, calcage(secs,60,60));
  DisplayStr = DisplayStr.replace(/%%S%%/g, calcage(secs,1,60));

  document.getElementById("cntdwn2").innerHTML = DisplayStr;
  if (CountActive2)
    lotoTime = setTimeout("CountBack2(" + (secs+CountStepper2) + ")", SetTimeOutPeriod2);
}
if (typeof(BackColor2)=="undefined")
  BackColor2 = "white";
if (typeof(ForeColor2)=="undefined")
  ForeColor2= "black";
if (typeof(TargetDate2)=="undefined")
  TargetDate2 = "12/31/2020 5:00 AM";
if (typeof(DisplayFormat2)=="undefined")
  DisplayFormat2 = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
if (typeof(CountActive2)=="undefined")
  CountActive2 = true;
if (typeof(FinishMessage2)=="undefined")
  FinishMessage2 = "";
if (typeof(CountStepper2)!="number")
  CountStepper2 = -1;
if (typeof(LeadingZero2)=="undefined")
  LeadingZero2 = true;

CountStepper2 = Math.ceil(CountStepper2);
if (CountStepper2 == 0)
  CountActive2 = false;
var SetTimeOutPeriod2 = (Math.abs(CountStepper2)-1)*1000 + 990;
var dthen2 = new Date(TargetDate2);
var dnow2 = new Date(TekDate2);
if(CountStepper2>0)
  ddiff2 = new Date(dnow2-dthen2);
else
  ddiff2 = new Date(dthen2-dnow2);
gsecs2 = Math.floor(ddiff2.valueOf()/1000);
CountBack2(gsecs2);