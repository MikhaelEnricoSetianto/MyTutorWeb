function rememberMe() {
    var email = document.forms["login"]["email"].value;
    var pass = document.forms["login"]["password"].value;
    var remember = document.forms["login"]["remember"].checked;
    if (!remember) {
        setCookies("ce", "", 0);
        setCookies("cp", "", 0);
        setCookies("cr", false, 0);
        document.forms["login"]["email"].value = "";
        document.forms["login"]["pass"].value = "";
        document.forms["login"]["remember"].checked = false;
        alert("Credentials removed");
    } else {
        if (email == "" || pass == "") {
            document.forms["login"]["remember"].checked = false;
            alert("Please enter your credentials");
            return false;
        } else {
            setCookies("ce", email, 50);
            setCookies("cp", pass, 50);
            setCookies("cr", remember, 50);
            alert("Credentials Stored Success");
        }
    }
}

function setCookies(cookiename, cookiedata, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 48 * 3600 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cookiename + "=" + cookiedata + ";" + expires + ";path=/";
}

function loadCookies() {
    var username = getCookie("ce");
    var password = getCookie("cp");
    var rememberme = getCookie("cr");
    document.forms["login"]["email"].value = username;
    document.forms["login"]["pass"].value = password;
    if (rememberme) {
        document.forms["login"]["remember"].checked = true;
    } else {
        document.forms["login"]["remember"].checked = false;
    }
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function deleteCookie(cname) {
    const d = new Date();
    d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=;" + expires + ";path=/";
}

function acceptCookieConsent() {
    deleteCookie('user_cookie_consent');
    setCookies('user_cookie_consent', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
}