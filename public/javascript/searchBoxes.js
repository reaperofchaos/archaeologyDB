function createAuthorList()
{
       //sources searchbox
    var authorList = document.getElementById('authors');
    var authorJson = new XMLHttpRequest();
    authorJson.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myArr = JSON.parse(this.responseText);
            var html = "";
            myArr.map((curr)=>
            {
                html += `<option value='${curr.author}'>
                            ${curr.author}
                        </option>`;
            });
            authorList.innerHTML = html;
        }
    };
    authorJson.open("GET", "javascript/json/authors.json", true);
    authorJson.send();
}

function createSourceList()
{
       //sources searchbox
       var sourceList = document.getElementById('source');
       var sourceJson = new XMLHttpRequest();
       sourceJson.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var myArr = JSON.parse(this.responseText);
               var html = "";
               myArr.map((curr)=>
               {
                   html += `<option value='${curr.srcType}-${curr.srcID}'>
                               ${curr.title}
                           </option>`;
               });
               sourceList.innerHTML = html;
           }
       };
       sourceJson.open("GET", "javascript/json/sourceTitles.json", true);
       sourceJson.send();
}
function createSiteList()
{
         //sites searchbox
         var sitesList = document.getElementById('sites');
         var sitesJson = new XMLHttpRequest();
         sitesJson.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
                 var myArr = JSON.parse(this.responseText);
                 var html = "";
                 myArr.map((currentElement)=>
                 {
                     html += `<option value='${currentElement.site}'>`;
                 })
                 sitesList.innerHTML = html;
             }
         };
         sitesJson.open("GET", "javascript/json/sites.json", true);
         sitesJson.send();
}
$(document).ready(function(){
    createAuthorList();
    createSiteList();
    createSourceList();
});