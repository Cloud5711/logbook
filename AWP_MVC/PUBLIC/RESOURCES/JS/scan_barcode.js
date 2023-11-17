
    function startTime() {
      const today = new Date();
      let h = today.getHours();
      let m = today.getMinutes();
      let s = today.getSeconds();
      let ampm = h >= 12 ? 'PM' : 'AM';
      
      // Convert to 12-hour format
      h = h % 12;
      h = h ? h : 12; // 0 should be displayed as 12

      m = checkTime(m);
      s = checkTime(s);
      
      document.getElementById('txt').innerHTML = h + ":" + m + ":" + s + " " + ampm;
      setTimeout(startTime, 1000);
    }

    function checkTime(i) {
      if (i < 10) { i = "0" + i; }  // add zero in front of numbers < 10
      return i;
    }
