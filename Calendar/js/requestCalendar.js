function getXHR() {
    var xhr = null;
    if (window.XMLHttpRequest)
        xhr = new XMLHttpRequest();
    else {
        alert("Votre navigateur ne supporte pas AJAX");
        xhr = false;
    }
    return xhr;
}

function goTo(timeInterval) {
    var xhr = getXHR();

    if (!xhr)
        return false;
    
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('calendarFrame').innerHTML = xhr.responseText;
        }
    }

    xhr.open('POST', 'php/calendarWeeks.php', true);
    xhr.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded ;charset=utf-8'
    );

    xhr.send(`timeInterval=${timeInterval}`);
} 

for (btn of document.getElementsByClassName("btn-change")) {
    btn.addEventListener("click", function () {
        goTo(this.value)
    })
}