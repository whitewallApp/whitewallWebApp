window.onload = function(){
    var breadcrumbs = document.getElementById("breadcrumbs");
    var url = document.URL;
    var url = url.replace("http://", "");
    var page = url.split("/")[1];

    var html;
    page = page.charAt(0).toUpperCase() + page.slice(1);

    if (page != "Dashboard"){
        html = `/ <a href="/dashboard">Dashboard</a> / <a href="/${page}">${page}</a>`;
    }else{
        html = `/ <a href="/dashboard">Dashboard</a> /`;
    }
    console.log(page);

    breadcrumbs.innerHTML = html;
}