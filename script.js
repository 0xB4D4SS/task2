function sendRequest(method, data) {
    var request = new XMLHttpRequest();
    if (!request) {
        return;
    }
    var url = `api/?method=${method}`;
    if (data != null) {
        const dataArr = [];
        for (let key in data) {
            dataArr.push(`${key}=${data[key]}`);
        }
        url += `&${dataArr.join("&")}`;
    }
    console.log(url);
    request.open("get", url);
    request.send(null);
    return request.responseText;
}
window.onload = function() {;

    document.getElementById('save').addEventListener('click', function(){
        const fnameobj = document.getElementById('fnamevalue');
        const snameobj = document.getElementById('snamevalue');
        const ageobj = document.getElementById('agevalue');
        if (fnameobj.validity.valid && snameobj.validity.valid && ageobj.validity.valid) {
            const age = parseInt(ageobj.value);
            const fname = fnameobj.value;
            const sname = snameobj.value;
            const result = sendRequest("save", {fname, sname, age});
            alert("Success!");
        }
        else {
            alert("Invalid data!");
        }
    });

    document.getElementById('upload').addEventListener('click', function(){
        const result = sendRequest("upload");
        alert("Upload complete!");
    });

}