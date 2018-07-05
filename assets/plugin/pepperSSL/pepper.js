function updateStatus1() {
  var url='getupdate.php';
  jQuery('#statusElement1').load(url);
}
setInterval('updateStatus1()', 10000);

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =
    h + ':' + m + ':' + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = '0' + i};  // add zero in front of numbers < 10
    return i;
}

setInterval(function time(){
  var d = new Date();
  var hours = 1 - d.getHours();
  var min = 60 - d.getMinutes();
  if((min + '').length == 1){
    min = '0' + min;
  }
  var sec = 60 - d.getSeconds();
  if((sec + '').length == 1){
        sec = '0' + sec;
  }
  jQuery('#the-final-countdown p').html(hours+':'+min+':'+sec)
}, 1000);

  var byId = document.getElementById.bind(document);

  function updateTime()
  {
    var
      time = new Date(),
      // take 1800 seconds (30 minutes) and substract the remaining minutes and seconds
      // 30 minutes mark is rest of (+30 divided by 60); *60 in seconds; substract both, mins & secs
      secsRemaining = 3600 - (time.getUTCMinutes()+30)%60 * 60 - time.getUTCSeconds(),
      // integer division
      mins = Math.floor(secsRemaining / 60),
      secs = secsRemaining % 60
    ;
    byId('min-total').textContent = secsRemaining;
    byId('min-part').textContent  = mins;
    byId('sec-part').textContent  = secs;

    // let's be sophisticated and get a fresh time object
    // to calculate the next seconds shift of the clock
    setTimeout( updateTime, 1000 - (new Date()).getUTCMilliseconds() );
  }
  updateTime();