let btnToChange = document.getElementById("btnToChange");
let personSelect = document.getElementById("personSelect");
let roomDiv = document.getElementById("ShowRooms");

window.onload = function () {
    btnToChange.textContent = "Move " + personSelect.options[personSelect.selectedIndex].innerText + " to:";
    var url = "/YourHouse/Classes/APIs/ShowRooms.php";

    var xhr = new XMLHttpRequest();
    xhr.open("GET", url);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            roomDiv.innerHTML = "";
            roomDiv.innerHTML = xhr.responseText;
        }
    };

    xhr.send();
}

function selectChange(sel) {
    btnToChange.textContent = "Move " + sel.options[sel.selectedIndex].innerText + " to:";
}

let search = document.getElementById('searchTxt').value;

async function SearchSimple(txt) {
    const response = await fetch("Classes/APIs/ShowRooms.php?search=" + txt.value);
    roomDiv.innerHTML = "";
    //roomDiv.innerHTML = response;
    roomDiv.innerHTML = '<iframe src=' + txt.value + '"Classes/APIs/ShowRooms.php?search=" name="targetframe" allowTransparency="true" scrolling="yes" frameborder="0" style="width: 100vw;"></iframe>';
}

async function Search(txt) {
    if (txt.value === "" || txt.value.trim().length === 0) {
        var url = "/YourHouse/Classes/APIs/ShowRooms.php"
    } else {
        var url = "/YourHouse/Classes/APIs/ShowRooms.php?search=" + txt.value;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("GET", url);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            roomDiv.innerHTML = "";
            roomDiv.innerHTML = xhr.responseText;
        }
    };

    xhr.send();
}