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
        const fname = document.getElementById('fnamevalue').value;
        const sname = document.getElementById('snamevalue').value;
        const age = document.getElementById('agevalue').value;

        const result = sendRequest("save", {fname, sname, age});
    });

    document.getElementById('upload').addEventListener('click', function(){
        const result = sendRequest("upload");
    });

}