$("#img").change(function () {
    //判断是否支持FileReader
    if (window.FileReader) {
        var reader = new FileReader();
    } else {
        alert("您的设备不支持图片预览功能，如需该功能请升级您的设备！");
    }
    //获取文件
    var file = $("#img")[0].files[0];

    //读取完成
    reader.onload = function (e) {
        //图片路径设置为读取的图片
        // img.src = e.target.result;
        console.log("objUrl = " + e.target.result);
        $("#cvsMove").attr("src", e.target.result);
    };
    reader.readAsDataURL(file);
});


var form = {
    img: $('#img')[0],
    title: $('#title')[0],
    artist: $('#artist')[0],
    yearOfWork: $('#yearOfWork')[0],
    genre: $('#genre')[0],
    price: $('#price')[0],
    width: $('#width')[0],
    height: $('#height')[0],
    description: $('#description')[0]
};

form.title.onblur = function () {
    checkTitle();

};
form.artist.onblur = function () {
    checkArtist();
};
form.yearOfWork.onblur = function () {
    checkYear();
};
form.genre.onblur = function () {
    checkGenre();
};
form.price.onblur = function () {
    checkPrice();
};
form.width.onblur = function () {
    checkWidth();
};
form.height.onblur = function () {
    checkHeight();
};
form.description.onblur = function () {
    checkDes();
};
var patten = new RegExp(/^[0-9]*$/);

function checkImg() {
    //todo
    if (document.getElementById('cvsMove').getAttribute('src')==="../img/" ) {
        document.getElementById("img-rem").innerHTML = "请选择！"
    } else {
        document.getElementById("img-rem").innerHTML = "&nbsp;";
        return true;
    }
}

function checkTitle() {
    if (form.title.value === "") {
        document.getElementById("title-rem").innerHTML = "请输入名称！"
    } else {
        document.getElementById("title-rem").innerHTML = "&nbsp; ";
        return true;
    }
}

function checkArtist() {
    if (form.artist.value === "") {
        document.getElementById("artist-rem").innerHTML = "请输入作家！"
    } else {
        document.getElementById("artist-rem").innerHTML = "&nbsp; ";
        return true;
    }
}

function checkYear() {

    if (form.yearOfWork.value === "") {
        document.getElementById("year-rem").innerHTML = "请输入年份！"
    }else if (!patten.test(form.yearOfWork.value)){
        document.getElementById("year-rem").innerHTML = "请输入正确格式";}
    else {
        document.getElementById("year-rem").innerHTML = "&nbsp; ";
        return true;
    }
}

function checkGenre() {
    if (form.genre.value === "") {
        document.getElementById("genre-rem").innerHTML = "请输入流派！"
    } else {
        document.getElementById("genre-rem").innerHTML = "&nbsp; ";
        return true;
    }
}
function checkPrice() {

    if (form.price.value === "") {
        document.getElementById("price-rem").innerHTML = "请输入价格！"
    }else if (!patten.test(form.price.value)){
        document.getElementById("price-rem").innerHTML = "请输入正确格式"; }
    else {
        document.getElementById("price-rem").innerHTML = "&nbsp; ";
        return true;
    }
}

function checkWidth() {

    if (form.width.value === "") {
        document.getElementById("size-rem").innerHTML = "请输入艺术品宽度！"
    } else if (!patten.test(form.width.value)){
        document.getElementById("size-rem").innerHTML = "请输入正确格式"; }else {
        document.getElementById("size-rem").innerHTML = "&nbsp; ";
        return true;
    }

}

function checkHeight() {
    var patten = new RegExp(/^[0-9]*$/);
    if (form.height.value === "") {
        document.getElementById("size-rem").innerHTML = "请输入艺术品高度！"
    }else if (!patten.test(form.height.value)){
        document.getElementById("size-rem").innerHTML = "请输入正确格式"; } else {
        document.getElementById("size-rem").innerHTML = "&nbsp; ";
        return true;
    }

}

function checkDes() {
    if (form.description.value === "") {
        document.getElementById("des-rem").innerHTML = "请输入商品描述！"
    } else {
        document.getElementById("des-rem").innerHTML = "&nbsp; ";
        return true;
    }
}


document.getElementById('submitBtn').addEventListener('click', function () {
    if (checkHeight() && checkWidth() && checkDes() && checkGenre() && checkPrice() && checkYear() && checkArtist() && checkTitle() && checkImg()) {
      document.getElementById("modifyForm").submit();
        alert("提交成功");
    } else {
        checkHeight();
        checkWidth();
        checkDes();
        checkGenre();
        checkPrice()
        checkYear();
        checkArtist();
        checkTitle();
        checkImg();
    }
});
