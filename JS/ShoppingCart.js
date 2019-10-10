$('.deleteBtn').on('click', function () {
    var artworkID = this.getAttribute('index');
    var request = new XMLHttpRequest();
    request.open("post", "CartHandle.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
            if (this.responseText == "DeleteSuccess")
                alert("删除成功");
                window.location.reload();
        }
    };
    var para = "Delete=" + artworkID;
    request.send(para);
});

$('#totalBtn').on('click', function () {
    var request = new XMLHttpRequest();
    request.open("post", "CartHandle.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
            if (this.responseText.indexOf("delete")!=-1){
                alert("您的购物车中有物品已被下架,请删除后操作。\n商品ID："+this.responseText.replace("delete",""))
            }

            if (this.responseText.indexOf("sold")!=-1){
                alert("您的购物车中有物品已被售出,请删除后操作。\n商品名："+this.responseText.replace("sold",""))
            }

            if (this.responseText == "BalanceLack") {
                alert("余额不足，请充值后再购买")
            }
            if (this.responseText == "PaySuccess") {
                alert("恭喜，购买成功");
                window.location.reload();
            }
        }
    };
    var para = "Pay=commit";
    request.send(para);


});