var searchAll = document.getElementById('searchAll');


var totalnum;
var pageSize = 6;       //每一页记录数
var totalPage;

var input = {
    Name: document.getElementById("NameS"),
    Details: document.getElementById("DetailsS"),
    Artist: document.getElementById("ArtistS")
};
var request = new XMLHttpRequest();
var curPage=1;        //当前页数
function doSearch(page, order, upDown) {
    curPage = page;
    if (upDown == "" || upDown == "undefined" || upDown == null) {
        upDown = "asc";
    }
    nocache = "&nocache=" + Math.random() * 1000000;
    let url = "SearchResult.php?Name=" + input.Name.value + "&Details=" + input.Details.value + "&Artist=" + input.Artist.value
        + "&page=" + page + "&order=" + order + "&upDown=" + upDown + nocache;
    request.open("get", url, true);
    request.onreadystatechange = function () {
        if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
            document.getElementById("searchResult").innerHTML = this.responseText;
            totalnum = document.getElementsByClassName('result')[0].getAttribute("totalnum");
            totalPage = Math.ceil(totalnum / pageSize);      //总页数
            getPageBar();
        }
    };
    request.send(null);

}

searchAll.onclick = function () {
    input.Name.value = "";
    input.Details.value = "";
    input.Artist.value = "";
    nocache = "&nocache=" + Math.random() * 1000000;
    let url2 = "SearchResult.php?Name=&Details=&Artist=" + nocache;
    request.open("get", url2, true);
    request.onreadystatechange = function () {
        if ((this.status >= 200 && this.status <= 300 || this.status == 304) && this.readyState == 4) {
            document.getElementById("searchResult").innerHTML = this.responseText;
            totalnum = document.getElementsByClassName('result')[0].getAttribute("totalnum");
            totalPage = Math.ceil(totalnum / pageSize);      //总页数
            getPageBar();
        }
    };

    request.send(null);
};

$('input[type=radio][name=order]').change(function () {
    if (this.value == 'price') {
        doSearch(1, "price");
    } else if (this.value == 'hot') {
        doSearch(1, "view");
    } else if (this.value == 'name') {
        doSearch(1, "title")
    }
});

$('#upDown span').click(function () {
    $('#upDown span').removeClass('select');
    if ($(this).attr("id")=='order-asc') {
        doSearch(curPage, "view", "asc");
    }
    if ($(this).attr("id") == 'order-desc') {
        doSearch(curPage, "view", "desc");
    }
    $(this).addClass('select');
});


//获取分页条（分页按钮栏的规则和样式根据自己的需要来设置）
function getPageBar() {
    if (curPage > totalPage) {
        curPage = totalPage;
    }
    if (curPage < 1) {
        curPage = 1;
    }

    pageBar = "";

    //如果不是第一页
    if (curPage != 1) {
        pageBar += "<span class='pageBtn'><a href='javascript:doSearch(1)'>首页</a></span>";
        pageBar += "<span class='pageBtn'><a href='javascript:doSearch(" + (curPage - 1) + ")'><<</a></span>";
    }

    //显示的页码按钮(6个)
    var start, end;
    if (totalPage <= 6) {
        start = 1;
        end = totalPage;
    } else {
        if (curPage - 2 <= 0) {
            start = 1;
            end = 6;
        } else {
            if (totalPage - curPage < 2) {
                start = totalPage - 5;
                end = totalPage;
            } else {
                start = curPage - 2;

            }
        }
    }

    for (var i = start; i <= end; i++) {
        if (i == curPage) {
            pageBar += "<span class='pageBtn-selected'><a href='javascript:doSearch(" + i + ")'>" + i + "</a></span>";
        } else if (i == end) {
            pageBar += "<span class='pageBtn'><a href='javascript:doSearch(" + totalPage + ")'>" + totalPage + "</a></span>";
        } else if (i == end - 1&&curPage!=end&&curPage!=end-1) {
            pageBar += "<span class='pageBtn'><a href='javascript:doSearch(" + (parseInt(curPage) + 1) + ")'>...</a></span>";
        } else {
            pageBar += "<span class='pageBtn'><a href='javascript:doSearch(" + i + ")'>" + i + "</a></span>";
        }
    }

    //如果不是最后页
    if (curPage != totalPage) {
        pageBar += "<span class='pageBtn'><a href='javascript:doSearch(" + (parseInt(curPage) + 1) + ")'>>></a></span>";
        pageBar += "<span class='pageBtn'><a href='javascript:doSearch(" + totalPage + ")'>尾页</a></span>";
    }

    $("#pageBar").html(pageBar);
}

$(function () {
    doSearch(1);
});




