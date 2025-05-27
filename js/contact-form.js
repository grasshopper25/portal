let form = document.querySelector("form");
form.addEventListener('submit', (e) => {
    e.preventDefault();
    //Validate text box
    document.getElementById("contactError").style.display = "none";
    // if (document.getElementById("contactMessage").value.trim() === "") {
    //     document.getElementById("contactError").innerHTML = "Kindly type your Message";
    //     document.getElementById("contactError").style.display = "block";
    //     return false;
    // }
    // else if (document.getElementById("contactName").value.trim() === "") {
    //     document.getElementById("contactError").innerHTML = "Kindly provide your Name";
    //     document.getElementById("contactError").style.display = "block";
    //     return false;
    // }
    // else 
    if (document.getElementById("contactEmail").value.trim() === "") {
        document.getElementById("contactError").innerHTML = "Kindly provide your Email address";
        document.getElementById("contactError").style.display = "block";
        return false;
    }
    //Calling API
    document.querySelector("#btnContactSumbit").innerHTML = "Submitting..";
    let data = new FormData(form);
    fetch('https://script.google.com/macros/s/AKfycbwGJIR3yRIVN21_mBV_sQ8dO3hRxFUvROTNYEXr5dEbgu_jOGzv_-Dr8MvsETHJyJw3bw/exec', {
        method: "POST",
        body: data
    })
        .then(res => res.text())
        .then(data => {

            var myModal = new bootstrap.Modal(document.getElementById('modalContactSubmittedSuccess'));
            myModal.show();
            document.querySelector("#btnContactSumbit").innerHTML = "SEND";
            // document.getElementById("contactMessage").value = "";
            // document.getElementById("contactName").value = "";
            document.getElementById("contactEmail").value = "";

        });
});


//<------------Create google app script for conact spreadsheet-------------> 
// const sheets = SpreadsheetApp.openByUrl("https://docs.google.com/spreadsheets/d/1KBDyfch_wk_BXBYv0sGVyU6Vy3W4qbPkf1kKs6f45Hk/edit?gid=0#gid=0");
// const sheet = sheets.getSheetByName("Sheet1");
// function doPost(e){
//   var formattedDate = Utilities.formatDate(new Date(), "GMT", "dd-MM-yyyy HH:mm:ss"); 
//   let data = e.parameter;
//   sheet.appendRow([formattedDate,data.name,data.email,data.message]);
//   return ContentService.createTextOutput("Success");
// }