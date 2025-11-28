
function CountDownTimer(dt, id) {

    var end = new Date(dt);
    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;

    function showRemaining() {
        var now = new Date();
        var distance = end - now;
        if (distance < 0) {

            clearInterval(timer);
            document.getElementById(id).innerHTML = 'EXPIRED!';

            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);

        var show_days = (days<10) ? "0" + days : days;
        var show_hours = (hours<10) ? "0" + hours : hours;
        var show_minutes = (minutes<10) ? "0" + minutes : minutes;
        var show_seconds = (seconds<10) ? "0" + seconds : seconds;

        document.getElementById(id).innerHTML = show_days + ':';
        document.getElementById(id).innerHTML += show_hours + ':';
        document.getElementById(id).innerHTML += show_minutes + ':';
        document.getElementById(id).innerHTML += show_seconds + '';

    }

    timer = setInterval(showRemaining, 1000);

}