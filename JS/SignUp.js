//存放各个input的obj
var ele = {
    name: document.getElementById("user"),
    password: document.getElementById("password"),
    repassword: document.getElementById("repassword"),
    tel: document.getElementById("tel")
};

ele.name.onblur = function () {
    checkName(ele.name.value);
};
ele.password.onblur = function () {
    checkPassword(ele.password.value, ele.repassword.value, ele.name.value);
};
ele.repassword.onblur = function () {
    checkRepassword(ele.password.value, ele.repassword.value);

};
ele.tel.onblur = function () {
    checkTel(ele.tel.value);
};

function checkName(name) {
    var re = new RegExp(/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,}$/);//不为纯数字或字母，但只能字母+数字
    var re1 = new RegExp(/^[0-8]{6,}$/);
    var re2 = new RegExp(/^[a-zA-Z]{6,}$/);
    if (name === "") {
        document.getElementById("user_reminder").innerHTML = "请输入用户名！"
    } else if (name.length < 6) {
        document.getElementById("user_reminder").innerHTML = "格式错误，至少6位"
    } else if (re1.test(name) || re2.test(name)) {
        document.getElementById("user_reminder").innerHTML = "格式错误，不能为纯数字或纯字母"
    } else {
        document.getElementById("user_reminder").innerHTML = "&nbsp;";
        return true;
    }
}

function checkPassword(password, repassword, name) {
    if (password == "") {
        document.getElementById("password_reminder").innerHTML = "请输入密码";
    } else if (password.length < 6) {
        document.getElementById("password_reminder").innerHTML = "至少6位";
    } else if (password == name) {
        document.getElementById("password_reminder").innerHTML = "密码不能与用户名相同";
    } else if (repassword != "" && repassword != password) {
        document.getElementById("repassword_reminder").innerHTML = "两次输入密码不一致";
    } else {
        document.getElementById("password_reminder").innerHTML = "&nbsp;";
        return true;
    }
}

function checkRepassword(password, repassword) {


    if (repassword == "") {
        document.getElementById("repassword_reminder").innerHTML = "请确认密码";
    } else if (repassword != password) {
        document.getElementById("repassword_reminder").innerHTML = "两次输入密码不一致";

    } else {
        document.getElementById("repassword_reminder").innerHTML = "&nbsp;";
        return true;

    }

}

function checkTel(tel) {
    var patten = new RegExp(/^[1][0-9]{10}$/);
    if (tel == "") {
        document.getElementById("tel_reminder").innerHTML = "请输入手机号码";
    } else if (!patten.test(tel)) {
        document.getElementById("tel_reminder").innerHTML = "格式错误";
    } else {
        document.getElementById("tel_reminder").innerHTML = "&nbsp;";
        return true;
    }

}

function check() {
    var nameok = false;
    var passwordok = false;
    var repasswordok = false;
    var telok = false;


    var condition1 = false;
    var condition2 = false;
    if (checkName(ele.name.value)) {
        nameok = true;
    } else {
        checkName(ele.name.value);
    }
    if (checkPassword(ele.password.value, ele.repassword.value, ele.name.value)) {
        passwordok = true;
    }
    if (checkRepassword(ele.password.value, ele.repassword.value)) {
        repasswordok = true;
    }
    if (checkTel(ele.tel.value)) {
        telok = true;
    }


    if (nameok && passwordok && repasswordok && telok) {
        alert("恭喜，注册成功");
        return true;
    }
    else {
        checkName(ele.name.value);
        checkPassword(ele.password.value, ele.repassword.value, ele.name.value);
        checkRepassword(ele.password.value, ele.repassword.value);
        checkTel(ele.tel.value);

        if (condition1) {
            alert("很遗憾，注册失败, 用户已存在")
        }else if (condition2) {
            alert("很遗憾，注册失败, 服务器已爆炸")
        }
      return false;
    }
}



