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
    
    thedbfile = document.getElementsByName("dbfile");
    
    var thekey = '';
    var thevalue = '';
    var thepair = {};
    for( i = 0; i < thedbfile.length; i++ ) {
        if( thedbfile[i].checked ) {
            document.getElementById("theloaddbbuttons").style.display = "none";
            document.getElementById("theloader").style.display = "";
            
            thekey = thedbfile[i].name;
            thevalue = thedbfile[i].value;
            thepair = {};
            thepair[thekey] = thevalue;
            
            $.post(url, thepair, function(data){
             
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
            $('#loadDBFile').modal('hide');
            return false; 
        }
    }
    alert('You must select a file.');
    
    
}