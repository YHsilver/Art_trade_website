var addCart=document.getElementById('addCart');
var artworkID=addCart.getAttribute('artworkID');
addCart.addEventListener("click", function () {

    var request = new XMLHttpRequest();
    request.open("post", "CartHandle.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
            if (this.responseText=="soldOut"){
                alert("商品已售出，不能添加")
            }
            if (this.responseText == "notLog")
                alert("请登录后再操作");
            if (this.responseText=="alreadyExisted") {
                alert("商品已在购物车，请勿重复添加")
            }
            if (this.responseText=="AddSuccess") {
                alert("添加成功")
            }
        }
    };
    var para = "Add=" + artworkID;
    request.send(para);

});