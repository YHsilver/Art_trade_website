var charge = document.getElementById("recharge");
var confirmBtn = document.getElementById("charge_confirm");
charge.onblur = function () {
    check()
};

function check() {
    var patten = new RegExp(/^[0-9]*$/);
    if (!patten.test(charge.value)) {
        document.getElementById("confirm_charge").innerHTML = "请输入整数";
    } else {
        document.getElementById("confirm_charge").innerHTML = "&nbsp;";
        return true;
    }
}

confirmBtn.addEventListener("click", function () {
    if (check()) {
        if (charge.value != 0) {
            var request = new XMLHttpRequest();
            request.open("post", "Balance.php", true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.onreadystatechange = function () {
                if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
                    alert("充值成功，账户到账:+" + charge.value);
                    window.location.reload();
                }
            };
            var para = "charge=" + charge.value;
            request.send(para);

        }
    }
});


$('.deleteBtn').on('click', function () {

    if (confirm("确定删除？")) {

        var request = new XMLHttpRequest();
        var id = this.getAttribute('artworkID');
        request.open("post", "DeleteUpload.php", true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function () {
            if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
                if (this.responseText == "success") {
                    alert("删除成功");
                    window.location.reload();
                } else alert("删除失败，请稍后再试")
            }
        };
        var para = "delete=" + id;
        request.send(para);

    }
});

$('.modifyBtn').on('click', function () {
    location.href = "Upload.php?artworkID=" + this.getAttribute('artworkID');
});











