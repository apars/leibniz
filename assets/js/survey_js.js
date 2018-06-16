/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function myFunction() {
    //document.getElementById("demo").style.color = "red";
    $(location).attr('href',"http://localhost/surveynow2/");
}

function redirectOnClick(url) {
    //document.getElementById("demo").style.color = "red";
    $(location).attr('href',url);
}

function redirect2importDB(url) {
    document.getElementById("theloaddbbuttons").style.display = "none";
    document.getElementById("theloader").style.display = "";
    $.post(url, {}, function(data){
             
            // show the response
            $('#response').html(data);
            document.getElementById("theloaddbbuttons").style.display = "";
            document.getElementById("theloader").style.display = "none";
             
        }).fail(function() {
         
            // just in case posting your form failed
            //alert( "Posting failed." );
            document.getElementById("theloaddbbuttons").style.display = "";
            document.getElementById("theloader").style.display = "none";
        });
        return false;
}