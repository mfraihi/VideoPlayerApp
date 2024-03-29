function getAddress(target) {
    if (navigator.geolocation) {
	// Use method getCurrentPosition to get coordinates
	navigator.geolocation.getCurrentPosition(function (position) {
		 $.get('http://maps.google.com/maps/api/geocode/xml?latlng=' + position.coords.latitude + ',' + position.coords.longitude + '&sensor=false', function(data) {
		    var address = $(data).find("formatted_address").first().text();                    
		    if (address != "") {
                        $(target).val(address);
			writeCookie("address", address, 3);
		    }
		    });
	});
        }
}

function writeCookie(name,value,days) {
    var date, expires;
    if (days) {
        date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        expires = "; expires=" + date.toGMTString();
            }else{
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var i, c, ca, nameEQ = name + "=";
    ca = document.cookie.split(';');
    for(i=0;i < ca.length;i++) {
        c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1,c.length);
        }
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length,c.length);
        }
    }
    return '';
}
