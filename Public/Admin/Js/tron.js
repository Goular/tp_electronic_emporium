$(".tron").mouseover(function () {
    //修改每个TD标签的背景色
    $(this).find("td").css('backgroundColor', '#DEE7F5');
});
$(".tron").mouseout(function () {
    $(this).find("td").css('backgroundColor', "#FFFFFF");
});