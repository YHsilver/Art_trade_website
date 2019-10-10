//处理登陆状态
function handleSessionStorage(method, key, value) {
    switch (method) {
        case 'get': {
          let   temp = window.sessionStorage.getItem(key);
            return temp;
        }
        case 'set': {
            window.sessionStorage.setItem(key, value);
            break;
        }
        case 'remove': {
            window.sessionStorage.removeItem(key);
            break;
        }
        default: {
            return false;
        }
    }
}

//导航栏对象
var nav = {
    shopping: document.getElementById("shopping"),
    signOut: document.getElementById("signOut"),
    myCount: document.getElementById("myCount"),
    or: document.getElementById("or"),
    sign: document.getElementById("signup"),
    login: document.getElementById("login")
};


//检查是否登陆
function setStatus() {
    var status = handleSessionStorage("get", "status");

    if (status == "loged") {
        nav.sign.style.display = "none";
        nav.login.style.display = "none";
        nav.or.style.display = "none";
        nav.myCount.style.display = "inline-block";
        nav.signOut.style.display = "inline-block";
        nav.shopping.style.display = "inline-block";
    } else {
        nav.sign.style.display = "inline-block";
        nav.login.style.display = "inline-block";
        nav.or.style.display = "inline-block";
        nav.myCount.style.display = "none";
        nav.signOut.style.display = "none";
        nav.shopping.style.display = "none";
    }

}


//登出按钮
nav.signOut.onclick = function () {
    handleSessionStorage("set", "status", "out");
    setStatus();
    var request1 = new XMLHttpRequest();
    request1.open("post", "Log.php", true);
    request1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var para1 = "message=logout";
    request1.send(para1);
    window.location.reload();


};


//注册按钮
nav.sign.onclick = function popBox() {
    var popBox = document.getElementById("popBox");
    var popLayer = document.getElementById("popLayer");
    popBox.style.display = "block";
    popLayer.style.display = "block";

};


//注册弹窗对象
var ele = {
    name: document.getElementById("user"),
    password: document.getElementById("password"),
    repassword: document.getElementById("repassword"),
    tel: document.getElementById("tel"),
    email: document.getElementById("email"),
    address: document.getElementById("address")
};

//验证码对象
let options = {
    canvasId: "auth-code", //canvas的id
    txt: generateCode(), //传入验证码内容
    height: 30, //验证码高度
    width: 100//验证码宽度
};

//登陆弹窗对象
var ele_log = {
    name: document.getElementById("user_log"),
    password: document.getElementById("password_log"),
    code: document.getElementById("confirm_log")
};


//弹窗关闭
function closeBox() {
    var popBox = document.getElementById("popBox");
    var popLayer = document.getElementById("popLayer");
    popBox.style.display = "none";
    popLayer.style.display = "none";

    var popBox_log = document.getElementById("popBox_log");
    var popLayer_log = document.getElementById("popLayer_log");
    popBox_log.style.display = "none";
    popLayer_log.style.display = "none";

    //清空提示内容
    document.getElementById("user_reminder").innerHTML = "&nbsp;";
    document.getElementById("password_reminder").innerHTML = "&nbsp;";
    document.getElementById("repassword_reminder").innerHTML = "&nbsp;";
    document.getElementById("tel_reminder").innerHTML = "&nbsp;";
    document.getElementById("email_reminder").innerHTML = "&nbsp;";
    document.getElementById("address_reminder").innerHTML = "&nbsp;";

    document.getElementById("user_reminder_log").innerHTML = "&nbsp;";
    document.getElementById("password_reminder_log").innerHTML = "&nbsp;";
    document.getElementById("confirm_reminder_log").innerHTML = "&nbsp;";


    //清空input内容
    ele_log.name.value = "";
    ele_log.password.value = "";
    ele_log.code.value = "";

    ele.name.value = "";
    ele.password.value = "";
    ele.repassword.value = "";
    ele.tel.value = "";
    ele.email.value = "";
    ele.address.value = ""
    refreshCode()
}

//登陆按钮事件
nav.login.onclick = function popBox_log() {
    var popBox_log = document.getElementById("popBox_log");
    var popLayer_log = document.getElementById("popLayer_log");
    popBox_log.style.display = "block";
    popLayer_log.style.display = "block";
};

var request = new XMLHttpRequest();
var user_existed = false;

/**注册弹窗*/
ele.name.onblur = function () {
    request.open("post", "user_existed.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
            user_existed = this.responseText;
            // document.getElementById("user_reminder").innerHTML = this.responseText;
            if (user_existed) {
                document.getElementById("user_reminder").innerHTML = "用户名已存在";
            }
        }
    };
    var para = "Name=" + ele.name.value;
    request.send(para);

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
ele.email.onblur = function () {
    checkEmail(ele.email.value);
};
ele.address.onblur = function () {
    checkAddress(ele.address.value);
};

function checkName(name) {
    var re1 = new RegExp(/^[0-9]{6,}$/);
    var re2 = new RegExp(/^[a-zA-Z]{6,}$/);
    if (name === "") {
        document.getElementById("user_reminder").innerHTML = "请输入用户名！"
    } else if (user_existed) {
        document.getElementById("user_reminder").innerHTML = "用户名已存在";
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
    var rel = new RegExp(/^[0-9]{6,}$/);
    if (password == "") {
        document.getElementById("password_reminder").innerHTML = "请输入密码";
    } else if (password.length < 6) {
        document.getElementById("password_reminder").innerHTML = "至少6位";
    } else if (rel.test(password)) {
        document.getElementById("password_reminder").innerHTML = "不能为纯数字";
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

function checkEmail(email) {
    var rel = new RegExp(/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/);
    if (email === "") {
        document.getElementById("email_reminder").innerHTML = "请输入电子邮箱地址！"
    } else if (!rel.test(email)) {
        document.getElementById("email_reminder").innerHTML = "邮箱格式错误！"
    } else {
        document.getElementById("email_reminder").innerHTML = "&nbsp; ";
        return true;
    }

}

function checkAddress(address) {
    if (address == "") {
        document.getElementById("address_reminder").innerHTML = "请输入地址"
    } else {
        document.getElementById("address_reminder").innerHTML = "&nbsp;";
        return true;
    }
}


function check() {
    var nameok = false;
    var passwordok = false;
    var repasswordok = false;
    var telok = false;
    var emailok = false;
    var failed = false;  //由于其他原因注册失败
    var addressok = false;

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
    if (checkEmail(ele.email.value)) {
        emailok = true;
    }
    if (checkAddress(ele.address.value)) {
        addressok = true;
    }
    if (nameok && passwordok && repasswordok && telok && emailok && addressok) {
        if (failed) {
            alert("很遗憾，注册失败, 服务器已爆炸");
            return false;
        }
        handleSessionStorage("set", "status", "loged");
        document.getElementById("signForm").submit();
        alert("恭喜，注册成功");
        closeBox();
        setStatus();

        return true;
    } else {
        checkName(ele.name.value);
        checkPassword(ele.password.value, ele.repassword.value, ele.name.value);
        checkRepassword(ele.password.value, ele.repassword.value);
        checkTel(ele.tel.value);
        checkEmail(ele.email.value);
        checkAddress(ele.address.value);
    }
}


ele_log.name.onblur = function () {
    checkName_log();
};
ele_log.password.onblur = function () {
    checkPassword_log()
};
ele_log.code.onblur = function () {
    checkCode();
};


//验证码
function refreshCode() {
    options.txt = generateCode();
    writeAuthCode(options)
}

//canvas绘制验证码
function writeAuthCode(options) {
    let canvas = document.getElementById(options.canvasId);
    canvas.width = options.width;
    canvas.height = options.height;
    let ctx = canvas.getContext('2d'); //创建一个canvas对象
    ctx.textBaseline = "middle";
    ctx.fillStyle = randomColor(180, 255);//生成随机颜色
    ctx.fillRect(0, 0, options.width, options.height);


    //使每个字的颜色、位置不一样
    for (let i = 0; i < options.txt.length; i++) {
        let txt = options.txt.charAt(i);
        ctx.font = '30px SimHei';
        ctx.fillStyle = randomColor(50, 160);
        ctx.shadowOffsetY = randomNum(-3, 3);
        ctx.shadowBlur = randomNum(-3, 3);
        ctx.shadowColor = "rgba(0, 0, 0, 0.3)";
        let x = options.width / (options.txt.length + 1) * (i + 1);
        let y = options.height / 2;
        let deg = randomNum(-30, 30);
        ctx.translate(x, y);
        ctx.rotate(deg * Math.PI / 180);
        ctx.fillText(txt, 0, 0);
        ctx.rotate(-deg * Math.PI / 180);
        ctx.translate(-x, -y);
    }
    //绘制干扰线条
    for (let i = 0; i < randomNum(1, 4); i++) {
        ctx.strokeStyle = randomColor(40, 180);
        ctx.beginPath();
        ctx.moveTo(randomNum(0, options.width), randomNum(0, options.height));
        ctx.lineTo(randomNum(0, options.width), randomNum(0, options.height));
        ctx.stroke();
    }
    //绘制干扰点
    for (let i = 0; i < options.width / 6; i++) {
        ctx.fillStyle = randomColor(0, 255);
        ctx.beginPath();
        ctx.arc(randomNum(0, options.width), randomNum(0, options.height), 1, 0, 2 * Math.PI);
        ctx.fill();
    }
}

//生成随机数字
function randomNum(min, max) {
    return Math.floor(Math.random() * (max - min) + min);
}

//生成随机颜色
function randomColor(min, max) {
    let r = randomNum(min, max);
    let g = randomNum(min, max);
    let b = randomNum(min, max);
    return "rgb(" + r + "," + g + "," + b + ")";
}

//产生四位数字验证码
function generateCode() {
    var length = 4;
    var code = "";

    for (var i = 0; i < length; i++) {
        code += Math.floor(Math.random() * 10)
    }
    return code;
}


writeAuthCode(options);


function checkCode() {
    if (ele_log.code.value == "") {
        document.getElementById("confirm_reminder_log").innerHTML = "Please enter the confirm code !";
    } else if (ele_log.code.value != options.txt) {
        document.getElementById("confirm_reminder_log").innerHTML = "The confirm code is wrong";
    } else {
        document.getElementById("confirm_reminder_log").innerHTML = "&nbsp;";
        return true;
    }
}

function checkName_log() {
    if (ele_log.name.value == "") {
        document.getElementById("user_reminder_log").innerHTML = "Please enter your user name !";
    } else {
        document.getElementById("user_reminder_log").innerHTML = "&nbsp;";
        return true;
    }
}

function checkPassword_log() {
    if (ele_log.password.value == "") {
        document.getElementById("password_reminder_log").innerHTML = "Please enter your password !";
    } else {
        document.getElementById("password_reminder_log").innerHTML = "&nbsp;";
        return true;
    }
}

function check_log() {
    var nameok = false;
    var passwordok = false;
    var codeok = false;

    if (checkName_log()) {
        nameok = true;

    }
    if (checkPassword_log()) {
        passwordok = true;
    }

    if (checkCode()) {
        codeok = true;
    }
    var correct;
    if (nameok && passwordok && codeok) {
        request.open("post", "Log.php", true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function () {
            if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
                correct = this.responseText;
                if (correct == 'true') {
                    handleSessionStorage("set", "status", "loged");
                    alert("恭喜，登陆成功");
                    closeBox();
                    setStatus();
                    return true;
                } else {
                    document.getElementById("password_reminder_log").innerHTML = "用户名或密码错误!";
                    return false
                }

            }
        };


        var para = "username=" + ele_log.name.value + "&password=" + ele_log.password.value;
        request.send(para);


    } else {
        checkName_log();
        checkPassword_log();
        checkCode();
        return false;
    }
}

document.getElementById('Log').onkeydown = function (e) {
    var theEvent = e || window.event;
    var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
    if (code == 13) {
        check_log()
    }
};
document.getElementById('Sign').onkeydown = function (e) {
    var theEvent = e || window.event;
    var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
    if (code == 13) {
        check()
    }
};
setStatus();








