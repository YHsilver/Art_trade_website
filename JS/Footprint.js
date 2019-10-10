var foot_dom = document.getElementById("footprint");
var footprint = [];
if (sessionStorage.getItem("footprint") != null) {
    footprint = JSON.parse(sessionStorage.getItem("footprint"));
} else {
    sessionStorage.setItem("footprint", JSON.stringify(footprint));
}

var foot_str = "footprint: ";
var title = document.getElementsByTagName("title")[0].textContent;
if (title == "Details") title = window.location.href;
var index = footprint.indexOf(title);

if (index === -1) {
    footprint.push(title);
} else {
    footprint.splice(index + 1);
}

for (j = 0; j < footprint.length; j++) {
    if (j === footprint.length - 1) {
        if (footprint[j].indexOf('Details') != -1) {
            foot_str += "<a href=\" " + footprint[j]  + " \" >Details</a>";
        } else
            foot_str += "<a href=\" " + footprint[j] + ".php" + " \" >" + footprint[j] + "</a>";
    } else {
        if (footprint[j].indexOf('Details') != -1) {
            foot_str += "<a href=\" " + footprint[j]+ " \" >Details</a><span>→</span>";
        } else
        foot_str += "<a href=\" " + footprint[j] + ".php" + " \" >" + footprint[j] + "</a>" + "<span>→</span>";
    }
}
foot_dom.innerHTML = foot_str;
sessionStorage.setItem("footprint", JSON.stringify(footprint));


