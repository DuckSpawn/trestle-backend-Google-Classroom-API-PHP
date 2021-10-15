let currentURL = window.location.href;
let url = new URL(currentURL);
let code = url.searchParams.get("code");

let grantAccess = document.querySelector('#grantAccess');
let data = document.querySelector('#data');

let collection;

const xhttp = new XMLHttpRequest();
// initial loadout
getAuthURL();

if(code != null){
    grantAccess.classList.add('hide-grant-acess');
    data.innerHTML = 'Waiting for data to load...';
    getCollection();
}else{
    console.log('no access code');
}

// puts the created auth url in the href
function getAuthURL(){
    xhttp.onload = function(){
        if (this.readyState == 4 && this.status == 200) {
            grantAccess.setAttribute('href', this.responseText);
        }
    }
    xhttp.open("GET", "api.php", true);
    xhttp.send();
}

function getCollection(){
    xhttp.onload = function(){
        if (this.readyState==4 && this.status == 200) {
            collection = JSON.parse(this.response);
            data.innerHTML = arrangingData(collection);
        }
    }
    xhttp.open('POST', 'api.php?code=' + code, true);
    xhttp.send();

}

function arrangingData(collection){
    let html = 'Data loaded &#10004;<br>';
        collection.forEach(element => {
            let dueDate = element.dueDate;
            let dueTime = element.dueTime;
            https://stackoverflow.com/questions/6525538/convert-utc-date-time-to-local-date-time
            var date = new Date(dueDate.month.toString() + '/' + dueDate.day.toString() + '/' + dueDate.year.toString() + ' ' +
                (dueTime.hours == null ? '00' : dueTime.hours.toString()) + ':' +
                (dueTime.minutes == null ? '00' : dueTime.minutes.toString()) + ' UTC');

            let hours = date.getHours() == '0' ? '00' : date.getHours();
            let minutes = date.getMinutes() == '0' ? '00' : date.getMinutes();

            html += '<b>' + element.courseName + '</b><br>';
            html += element.title + '| Due date: ' +
                dueDate.month + '/' +
                dueDate.day + '/' +
                dueDate.year +' | Due time: '+
                    timeConvert(hours + ':' + minutes) + '<br>' +
                'Description: ' + element.description + '<br>' +
                'Link: ' + '<a href=' + element.alternateLink + '>course work link</a>' +
                '<br><br>'
        });
    return html;
}

// https://stackoverflow.com/questions/13898423/javascript-convert-24-hour-time-of-day-string-to-12-hour-time-with-am-pm-and-no
function timeConvert (time) {
    // Check correct time format and split into components
    time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
  
    if (time.length > 1) { // If time format correct
      time = time.slice (1);  // Remove full string match value
      time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
      time[0] = +time[0] % 12 || 12; // Adjust hours
    }
    return time.join (''); // return adjusted time or original string
}
