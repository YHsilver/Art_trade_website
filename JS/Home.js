//图片轮播
function my$(id) {
    return document.getElementById(id);
}

var box = my$("box");
var inner = box.children[0];
var ulObj = inner.children[0];
var list =   ulObj.children;
var olObj = inner.children[1];
var arr = my$("arr");
var imgWidth = inner.offsetWidth;
var right = my$("right");

var index = 0;

//根据li个数，创建小按钮
for (var i = 0; i < list.length; i++) {
    var liObj = document.createElement("li");
    olObj.appendChild(liObj);
    liObj.innerText = (i + 1);
    liObj.setAttribute("index", i);

    liObj.onclick = function () {
        //先清除所有按钮的样式
        for (var j = 0; j < olObj.children.length; j++) {
            olObj.children[j].removeAttribute("class");
        }
        this.className = "current";
        index = this.getAttribute("index");
        animate(ulObj, -index * imgWidth);
    }
    
}


olObj.children[0].className = "current";
//克隆一个ul中第一个li,加入到ul中的最后
ulObj.appendChild(ulObj.children[0].cloneNode(true));


var timeId = setInterval(onmouseclickHandle, 5000);

//左右焦点实现点击切换图片功能
box.onmouseover = function () {
    arr.style.display = "block";
    clearInterval(timeId);
};
box.onmouseout = function () {
    arr.style.display = "none";
    timeId = setInterval(onmouseclickHandle, 5000);
};

right.onclick = onmouseclickHandle;

function onmouseclickHandle() {
    //动态多生成一个li
    //到最后一个的时候内部改变index=0
    if (index == list.length - 1) {

        index = 0;//先设置index=0
        ulObj.style.left = 0 + "px";//把ul的位置还原成开始的默认位置
    }
    index++;
    animate(ulObj, -index * imgWidth);

    if (index == list.length - 1) {
        olObj.children[olObj.children.length - 1].className = "";
        olObj.children[0].className = "current";
    } else {
        for (var i = 0; i < olObj.children.length; i++) {
            olObj.children[i].removeAttribute("class");
        }
        olObj.children[index].className = "current";
    }
}

left.onclick = function () {
    if (index == 0) {
        index = list.length - 1;
        ulObj.style.left = -index * imgWidth + "px";
    }
    index--;
    animate(ulObj, -index * imgWidth);
    for (var i = 0; i < olObj.children.length; i++) {
        olObj.children[i].removeAttribute("class");
    }
    olObj.children[index].className = "current";
};

//设置任意的一个元素,移动到指定的目标位置
function animate(element, target) {
    clearInterval(element.timeId);
    element.timeId = setInterval(function () {
        //获取元素的当前的位置,数字类型
        var current = element.offsetLeft;
        //每次移动的距离
        var step = 20;

        step = current < target ? step : -step;
        //当前移动到位置
        current += step;
        if (Math.abs(current - target) > Math.abs(step)) {
            element.style.left = current + "px";
        } else {
            //清理定时器
            clearInterval(element.timeId);
            //直接到达目标
            element.style.left = target + "px";
        }
    }, 10);
}





