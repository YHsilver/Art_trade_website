//添加到购物车、心愿单 弹窗
function popBox_add() {
    var popBox = document.getElementById("popBox_add");
    var popLayer = document.getElementById("popLayer_add");
    popBox.style.display = "block";
    popLayer.style.display = "block";
}
function closeBox_add() {
    var popBox = document.getElementById("popBox_add");
    var popLayer = document.getElementById("popLayer_add");
    popBox.style.display = "none";
    popLayer.style.display = "none";

}




//删除提示弹窗
function popBox_delete() {
    var popBox_delete = document.getElementById("popBox_delete");
    var popLayer_delete = document.getElementById("popLayer_delete");
    popBox_delete.style.display = "block";
    popLayer_delete.style.display = "block";
}
function closeBox_delete() {
    var popBox_delete = document.getElementById("popBox_delete");
    var popLayer_delete = document.getElementById("popLayer_delete");
    popBox_delete.style.display = "none";
    popLayer_delete.style.display = "none";

}


//支付成功弹窗
function popBox_pay() {
    var popBox_pay = document.getElementById("popBox_pay");
    var popLayer_pay = document.getElementById("popLayer_pay");
    popBox_pay.style.display = "block";
    popLayer_pay.style.display = "block";
}
function closeBox_pay() {
    var popBox_pay = document.getElementById("popBox_pay");
    var popLayer_pay = document.getElementById("popLayer_pay");
    popBox_pay.style.display = "none";
    popLayer_pay.style.display = "none"
}



//充值弹窗
function popBox_recharge() {
    var popBox_recharge = document.getElementById("popBox_recharge");
    var popLayer_recharge = document.getElementById("popLayer_recharge");
    popBox_recharge.style.display = "block";
    popLayer_recharge.style.display = "block";
}
function closeBox_recharge() {
    var popBox_recharge = document.getElementById("popBox_recharge");
    var popLayer_recharge = document.getElementById("popLayer_recharge");
    popBox_recharge.style.display = "none";
    popLayer_recharge.style.display = "none"

}