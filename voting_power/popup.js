document.getElementById('usr').addEventListener('change', function() {
    saveChanges();
}, false);

document.getElementById('save').addEventListener('click', function() {
    window.close();
}, false);


document.addEventListener('DOMContentLoaded', function() {
    chrome.storage.sync.get(['usr'], function(result)
    {
        document.getElementById("usr").value=result.usr;
    });
});

 function saveChanges() {
        var theValue = document.getElementById("usr").value;
        if (!theValue) {
          message('Error: No value specified');
          return;
        }
        chrome.storage.sync.set({'usr': theValue});
 }