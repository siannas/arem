
var i = 0; /* Set Global Variable i */
function increment(){
    i += 1; /* Function for automatic increment of field's "Name" attribute. */
}
/*
---------------------------------------------
Function to Remove Form Elements Dynamically
---------------------------------------------
*/
function removeElement(parentDiv, childDiv){
    if (childDiv == parentDiv){
        alert("The parent div cannot be removed.");
    }
    else if (document.getElementById(childDiv)){
        var child = document.getElementById(childDiv);
        var parent = document.getElementById(parentDiv);
        parent.removeChild(child);
    }
    else{
        alert("Child div has already been removed or does not exist.");
    return false;
    }
}
/*
----------------------------------------------------------------------------
Functions that will be called upon, when user click on the Name text field.
----------------------------------------------------------------------------
*/
function nameFunction(){
    var value = document.getElementById('terserah').value
    if(value==='1'){
        var temp = document.getElementsByTagName("template")[0];
        var clon = temp.content.cloneNode(true);
        document.getElementById("myForm").appendChild(clon);
    }
    else if(value==='2'){
        var temp = document.getElementsByTagName("template")[1];
        var clon = temp.content.cloneNode(true);
        document.getElementById("myForm").appendChild(clon);
    }
    else if(value==='3'){
        var temp = document.getElementsByTagName("template")[2];
        var clon = temp.content.cloneNode(true);
        document.getElementById("myForm").appendChild(clon);
    }
    else{
        var r = document.createElement('span');
        var y = document.createElement("INPUT");
        y.setAttribute("type", "text");
        y.setAttribute("class", "form-control");
        y.setAttribute("placeholder", "Name");
        var g = document.createElement("I");
        g.setAttribute("class", "fas fa-times-circle");
        increment();
        y.setAttribute("Name", "textelement_" + i);
        r.appendChild(y);
        g.setAttribute("onclick", "removeElement('myForm','id_" + i + "')");
        r.appendChild(g);
        r.setAttribute("id", "id_" + i);
        document.getElementById("myForm").appendChild(r);
    }
    
}
/*
-----------------------------------------------------------------------------
Functions that will be called upon, when user click on the Reset Button.
------------------------------------------------------------------------------
*/
function resetElements(){
document.getElementById('myForm').innerHTML = '';
}
