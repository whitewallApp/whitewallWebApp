window.onload = function(){
    var breadcrumbs = document.getElementById("breadcrumbs");
    var url = document.URL;
    var url = url.replace("http://", "");
    var page = url.split("/")[1];

    var html;
    var link = page.charAt(0).toUpperCase() + page.slice(1);

    if (page != "dashboard"){
        html = `/ <a href="/dashboard">Dashboard</a> / <a href="/${page}">${link}</a>`; //TODO: Make it so second link works, is capatilized right now
    }else{
        html = `/ <a href="/dashboard">Dashboard</a> /`;
    }
    console.log(page);

    breadcrumbs.innerHTML = html;
}