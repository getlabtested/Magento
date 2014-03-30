var ages = new Array();
var genders = new Array();
var listOfAge = new Array();
var avgPartnersMale = new Array();
var avgPartnersFemale = new Array();

function createData() {
    listOfAge[0] = "16 - 17";
    listOfAge[1] = "18 - 19";
    listOfAge[2] = "20 - 22";
    listOfAge[3] = "23 - 25";
    listOfAge[4] = "26 - 28";
    listOfAge[5] = "29 - 31"; 
    listOfAge[6] = "32 - 35";
    listOfAge[7] = "36 - 39";
    listOfAge[8] = "40 - 44";
    listOfAge[9] = "45 - 49";
    listOfAge[10] = "50 - 54";
    listOfAge[11] = "55 - 59";
    listOfAge[12] = "60 - 64";
    listOfAge[13] = "65 - 69";
    listOfAge[14] = "70 - 74";
    listOfAge[15] = "75+";

    avgPartnersMale[0] = 4.0;
    avgPartnersMale[1] = 4.4;
    avgPartnersMale[2] = 5.6;
    avgPartnersMale[3] = 6.9;
    avgPartnersMale[4] = 9.7;
    avgPartnersMale[5] = 10.1;
    avgPartnersMale[6] = 10.3;
    avgPartnersMale[7] = 11.5;
    avgPartnersMale[8] = 10.5
    avgPartnersMale[9] = 11.6;
    avgPartnersMale[10] = 9.8;
    avgPartnersMale[11] = 9.9;
    avgPartnersMale[12] = 8.9;
    avgPartnersMale[13] = 7.1;
    avgPartnersMale[14] = 6.6;
    avgPartnersMale[15] = 6.8;

    avgPartnersFemale[0] = 1.8;
    avgPartnersFemale[1] = 2.7;
    avgPartnersFemale[2] = 4.6;
    avgPartnersFemale[3] = 7.5;
    avgPartnersFemale[4] = 7.5;
    avgPartnersFemale[5] = 8.5;
    avgPartnersFemale[6] = 9.7;
    avgPartnersFemale[7] = 7.6;
    avgPartnersFemale[8] = 7.2;
    avgPartnersFemale[9] = 6.6;
    avgPartnersFemale[10] = 6.6;
    avgPartnersFemale[11] = 6.3;
    avgPartnersFemale[12] = 5.0;
    avgPartnersFemale[13] = 4.5;
    avgPartnersFemale[14] = 3.7;
    avgPartnersFemale[15] = 4.9;
}

function isOpera() {
    var browser = navigator.appName;
    if (browser == "Opera") {
        return true;
    }
    else {
        return false;
    }
}

function isIE() {
    var browser = navigator.appName;
    var b_version = navigator.appVersion;
    var version = parseFloat(b_version);
    if (browser == "Microsoft Internet Explorer" && version < 8) {
        return true;
    }
    else {
        return false;
    }
}

//show/hide HTML element
function toggle(animate, pageElement, speed) {
    switch (animate) {
        case "hide":
            $(pageElement).hide(speed);
            break;
        case "show":
            $(pageElement).show(speed);
            break;
    }
}

//change (update) all elements on the page according to chosen gender
function changeYourGender(gender) {
    var temp = new Array();
    var before = "";
    var middle = "";
    var after1 = "";
    var after2 = "";
    if (document.getElementById("table").childNodes.length == 1) {
        if (document.getElementById("gf").checked) {
            if (document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue.search("Were all your sexual partners women?") == 0) {
                document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue = "Were all your sexual partners men?";
            }
        }
        if (document.getElementById("gm").checked) {
            if (document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue.search("Were all your sexual partners men?") == 0) {
                document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue = "Were all your sexual partners women?";
            }
        }
    }
    if (document.getElementById("table").childNodes.length > 1) {
        if (document.getElementById("table").childNodes[1].childNodes[0].childNodes[0].nodeValue.search("How old was Person") == 0) {
            if (document.getElementById("gf").checked) {
                if (document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue.search("Were all your sexual partners women?") == 0) {
                    document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue = "Were all your sexual partners men?";
                }
            }
            if (document.getElementById("gm").checked) {
                if (document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue.search("Were all your sexual partners men?") == 0) {
                    document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue = "Were all your sexual partners women?";
                }
            }
        }
    }
    if (document.getElementById("table").childNodes.length > 1 && document.getElementById("yesRadio").checked == true) {
        if (document.getElementById("gf").checked) {
            if (document.getElementById("table").childNodes[1].childNodes[0].childNodes[0].nodeValue.search("Approximate Age of Woman") == 0) {
                document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue = "Were all your sexual partners men?";
                for (var i = 1; i < document.getElementById("table").childNodes.length; i++) {
                    before = document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.substring(0, 12);
                    middle = "Man";
                    if (document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.length == 50) {
                        after1 = document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.substring(17, 46);
                    }
                    if (document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.length == 51) {
                        after1 = document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.substring(17, 47);
                    }
                    after2 = "him?";
                    document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue = before + middle + after1 + after2;
                }
            }
        }
        if (document.getElementById("gm").checked) {
            if (document.getElementById("table").childNodes[1].childNodes[0].childNodes[0].nodeValue.search("Approximate Age of Man") == 0) {
                document.getElementById("table").childNodes[0].childNodes[0].childNodes[0].nodeValue = "Were all your sexual partners women?";
                for (var i = 1; i < document.getElementById("table").childNodes.length; i++) {
                    before = document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.substring(0, 12);
                    middle = "Woman";
                    if (document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.length == 48) {
                        after1 = document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.substring(15, 44);
                    }
                    if (document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.length == 49) {
                        after1 = document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue.substring(15, 45);
                    }
                    after2 = "her?";
                    document.getElementById("table").childNodes[i].childNodes[0].childNodes[0].nodeValue = before + middle + after1 + after2;
                }
            }
        }
    }
    if (gender == "male") {
        document.getElementById("gm").checked = true;
        document.getElementById("gf").checked = false;
    }
    if (gender == "female") {
        document.getElementById("gf").checked = true;
        document.getElementById("gm").checked = false;
    }
}

function clearTable(table, maleOrFemaleSelect) {
    if (document.getElementById(table).innerHTML != "") {
        oldTable = document.getElementById(table);
        newTable = document.createElement(oldTable.tagName);
        newTable.id = oldTable.id;
        newTable.className = oldTable.className;
        newTable.cellspacing = "0";
        newTable.setAttribute("cellspacing", "0");
        oldTable.parentNode.replaceChild(newTable, oldTable);
    }
    if (maleOrFemaleSelect == "male") {
        document.getElementById("gm").checked = true;
        document.getElementById("gf").checked = false;
        document.getElementById("noOfPartners").selectedIndex = 0;
    }
    if (maleOrFemaleSelect == "female") {
        document.getElementById("gf").checked = true;
        document.getElementById("gm").checked = false;
        document.getElementById("noOfPartners").selectedIndex = 0;
    }
}

//ask whether all your partners had opposite or same sex as you
function askGender(selectedItem) {
    createData();
    if (document.getElementById("noOfPartners").value == 0) {
        clearTable("table", "");
        toggle("hide", "#summary", "fast");
    }
    else {
        clearTable("table", "");
        var tr = document.createElement("tr");

        var td1 = document.createElement("td");
        td1.align = "left";
        td1.width = "420px";
        td1.setAttribute("align", "left");
        td1.setAttribute("width", "420px");
        td1.setAttribute("style","color: #31838a;font-size: 20px;font-weight: bold;");

        var td2 = document.createElement("td");
        td2.align = "left";
        td2.width = "185px";
        td2.className = "selectCell";
        td2.setAttribute("align", "left");
        td2.setAttribute("width", "185px");
        td2.setAttribute("class", "selectCell");

        var yesRadio = document.createElement("input");
        yesRadio.id = "yesRadio";
        yesRadio.name = "yesno";
        yesRadio.type = "radio";
        yesRadio.value = "yes";
        yesRadio.marginRight = "3px";
        yesRadio.setAttribute("value", "yes");
        yesRadio.setAttribute("style", "margin-right: 3px");

        var yesLabel = document.createElement("label");
        yesLabel.marginRight = "5px";
        yesLabel.setAttribute("for", "yesRadio");
        yesLabel.setAttribute("style", "margin-right: 5px");
        var yesLabelText = document.createTextNode("Yes");
        yesLabel.appendChild(yesLabelText);

        var noRadio = document.createElement("input");
        noRadio.type = "radio";
        noRadio.value = "yes";
        noRadio.marginRight = "3px";
        noRadio.id = "noRadio";
        noRadio.name = "yesno";
        noRadio.setAttribute("value", "yes");
        noRadio.setAttribute("style", "margin-right: 3px");

        var noLabel = document.createElement("label");
        noLabel.setAttribute("for", "noRadio");
        var noLabelText = document.createTextNode("No");
        noLabel.appendChild(noLabelText);

        if (document.getElementById("noOfPartners").value == "Over 50") {
            document.getElementById("summary").innerHTML = "<h3 style='color: #31838a;'>We are unable to perform this calculation.</h3>";
            $.scrollTo("#summaryBottom", 250);
            toggle("show", "#summary", "slow");
        }
        else {
            if (document.getElementById("gm").checked == true) {
                var tdcontent1 = document.createTextNode("Were all your sexual partners women?");
                td1.appendChild(tdcontent1);
                yesRadio.onclick = function() { document.getElementById("yesRadio").checked = true; addPartner(true, 1, document.getElementById("noOfPartners").value, true); document.getElementById("yesRadio").checked = true; return false; };
                noRadio.onclick = function() { document.getElementById("noRadio").checked = true; addPartner(true, 1, document.getElementById("noOfPartners").value, false); document.getElementById("noRadio").checked = true; return false; };
            }
            if (document.getElementById("gf").checked == true) {
                var tdcontent1 = document.createTextNode("Were all your sexual partners men?");
                td1.appendChild(tdcontent1);
                yesRadio.onclick = function() { document.getElementById("yesRadio").checked = true; addPartner(true, 1, document.getElementById("noOfPartners").value, true); document.getElementById("yesRadio").checked = true; return false; };
                noRadio.onclick = function() { document.getElementById("noRadio").checked = true; addPartner(true, 1, document.getElementById("noOfPartners").value, false); document.getElementById("noRadio").checked = true; return false; };
            }

            if (selectedItem == "Yes") {
                yesRadio.checked = true;
                yesRadio.setAttribute("checked", "checked");
            }
            if (selectedItem == "No") {
                noRadio.checked = true;
                noRadio.setAttribute("checked", "checked");
            }
            td2.appendChild(yesRadio);
            td2.appendChild(yesLabel);
            td2.appendChild(noRadio);
            td2.appendChild(noLabel);
            tr.appendChild(td1);
            tr.appendChild(td2);

            document.getElementById("table").appendChild(tr);
            toggle("hide", "#summary", "fast");
        }
    }
}

//desides whether to add or delete partners from the page
function changeNumberOfPartners() {    
    var number = document.getElementById("noOfPartners").value;
    if (number == "Over 50") {
        if (document.getElementById("gm").checked) {
            clearTable("table", "male");
            document.getElementById("noOfPartners").selectedIndex = 51;
        }
        else {
            clearTable("table", "female");
            document.getElementById("noOfPartners").selectedIndex = 51;
        }
        document.getElementById("noOfPartners").onchange = function() { askGender(null); return false; };
        document.getElementById("summary").innerHTML = "<h3>We are unable to perform this calculation.</h3>";
        $.scrollTo("#summaryBottom", 250);
        toggle("show", "#summary", "slow");
    }
    if (number == "0" || number == 0) {
        toggle("hide", "#summary", "fast");
        if (document.getElementById("gm").checked) {
            clearTable("table", "male");
        }
        else {
            clearTable("table", "female");
        }
        document.getElementById("noOfPartners").onchange = function() { askGender(null); return false; };
    }
    if (number != "Over 50" && number != "0") {
        toggle("hide", "#summary", "fast");
        var all = "";
        var gender = "";
        if (document.getElementById("yesRadio").checked) {
            all = true;
        }
        else {
            all = false;
        }
        
        if (document.getElementById("gm").checked) {
            gender = "Woman";
        }
        else {
            gender = "Man";
        }
        
        if (number > (document.getElementById("table").childNodes.length - 1)) {
            var lastIndex = "";
            var id = document.getElementById("table").lastChild.childNodes[1].childNodes[0].id;
            if (id.length == 7) {
                lastIndex = id.charAt(6);
            }
            else {
                lastIndex = id.charAt(6) + id.charAt(7);
            }
            document.getElementById("table").lastChild.className = "";
            document.getElementById("table").lastChild.removeAttribute("class");
            addPartner(false, ((lastIndex * 1) + 1), number, all);
        }
        if (number < (document.getElementById("table").childNodes.length - 1)) {
            while ((document.getElementById("table").childNodes.length - 1) > number) {
                document.getElementById("table").removeChild(document.getElementById("table").lastChild);
            }
        }
    }
}

//save genders (each time person's gender changed)
function saveGenders() {
    for (var i = 1; i <= document.getElementById("noOfPartners").value; i++) {
        if (document.getElementById("maleRadio" + i).checked) {
            genders[i] = "male";
        }
        if (document.getElementById("femaleRadio" + i).checked) {
            genders[i] = "female";
        }
    }
}

//save ages (each time person's age changed)
function saveAges() {
    for (var i = 1; i <= document.getElementById("noOfPartners").value; i++) {
        ages[i] = document.getElementById("person" + i).selectedIndex;
    }
}

//add partners
function addPartner(clear, first, last, all) {
    var mixed = false;
    var gender = "";
    toggle("hide", "#summary", "fast");

    if (clear == true) {
        if (all == true) {
            askGender("Yes");
        }
        else {
            askGender("No");
        }
    }

    if (document.getElementById("gm").checked) {
        gender = "Woman";
    }
    else {
        gender = "Man";
    }

    for (var i = first; i <= last; i = i + 1) {
        //Create element
        var newElement = document.createElement("select");
        //Add parameters
        newElement.id = "person" + i;
        newElement.name = "person" + i;
        newElement.setAttribute("style","width: 120px;height: 28px;");
        for (var y = 0; y < listOfAge.length; y = y + 1) {
            newElement.options[y] = new Option(listOfAge[y], listOfAge[y]);
        }
        
        newElement.onchange = function() { saveAges(); };
        if (ages[i] != null) {
            newElement.selectedIndex = ages[i];
        }
        else {
            newElement.selectedIndex = 0;
        }

        if (all == false) {
            var maleRadio = document.createElement("input");
            maleRadio.id = "maleRadio" + i;
            maleRadio.name = "malefemale" + i;
            maleRadio.type = "radio";
            maleRadio.value = "male";
            maleRadio.marginRight = "3px";
            maleRadio.marginTop = "3px";
            if (isIE()) {
                maleRadio.onclick = function() { checkOneButtonOnly(this.id); return true; };
            }
            else {
                maleRadio.onclick = function() { saveGenders(); return true; };
            }
            maleRadio.setAttribute("value", "male");
            maleRadio.setAttribute("style", "margin-right: 3px; margin-top: 3px");

            var maleLabel = document.createElement("label");
            maleLabel.marginRight = "3px";
            maleLabel.marginTop = "3px";
            maleLabel.setAttribute("for", "maleRadio" + i);
            maleLabel.setAttribute("style", "margin-right: 2px; margin-top: 3px");
            var maleLabelText = null;
            if (isIE() || isOpera()) {
                maleLabelText = document.createTextNode("M");
            }
            else {
                maleLabelText = document.createTextNode("Male");
            }
            maleLabel.appendChild(maleLabelText);

            var femaleRadio = document.createElement("input");
            femaleRadio.id = "femaleRadio" + i;
            femaleRadio.name = "malefemale" + i;
            femaleRadio.type = "radio";
            femaleRadio.value = "female";
            femaleRadio.marginRight = "3px";
            femaleRadio.marginTop = "3px";
            if (isIE()) {
                femaleRadio.onclick = function() { checkOneButtonOnly(this.id, i); return true; };
            }
            else {
                femaleRadio.onclick = function() { saveGenders(); };
            }
            femaleRadio.setAttribute("value", "female");
            femaleRadio.setAttribute("style", "margin-right: 3px; margin-top: 3px");

            var femaleLabel = document.createElement("label");
            femaleLabel.marginTop = "3px";
            femaleLabel.setAttribute("for", "femaleRadio" + i);
            femaleLabel.setAttribute("style", "margin-top: 3px");
            var maleLabelText = null;
            if (isIE() || isOpera()) {
                femaleLabelText = document.createTextNode("F");
            }
            else {
                femaleLabelText = document.createTextNode("Female");
            }
            femaleLabel.appendChild(femaleLabelText);

            mixed = true;
        }

        var tr4 = document.createElement("tr");
        if (i == document.getElementById("noOfPartners").value) {
            tr4.className = "bottomRow";
            tr4.setAttribute("class", "bottomRow");
        }
        
        var td7 = document.createElement("td");
        td7.align = "left";
        td7.width = "425px";
        td7.setAttribute("align", "left");
        td7.setAttribute("width", "425px");
        td7.setAttribute("style","padding-bottom: 25px;font-family: arial,garuda,helvatica;font-size: 14px;");

        if (mixed == false) {
            var tdcontent7 = null;
            if (gender == "Woman") {
                tdcontent7 = document.createTextNode("Approximate Age of " + gender + " #" + i + "?");
            }
            if (gender == "Man") {
                tdcontent7 = document.createTextNode("Approximate Age of " + gender + " #" + i + "?");
            }
            td7.appendChild(tdcontent7);
        }
        else {
            var tdcontent71 = document.createTextNode("Approximate Age of Partner #" + i + "?");
            var lineBreak = document.createElement("br");
            var tdcontent72 = document.createTextNode("What gender had Partner #" + i + " ?");
            td7.appendChild(tdcontent71);
            td7.appendChild(lineBreak);
            td7.appendChild(lineBreak);
            td7.appendChild(tdcontent72);
        }

        var td8 = document.createElement("td");
        td8.align = "left";
        td8.width = "185px";
        td8.className = "selectCell";
        td8.setAttribute("align", "left");
        td8.setAttribute("width", "185px");
        td8.setAttribute("class", "selectCell");
        td8.setAttribute("style","padding-bottom: 25px;font-family: arial,garuda,helvatica;font-size: 14px;");
        td8.appendChild(newElement);

        if (mixed == true) {
            var lineBreak1 = document.createElement("br");
            td8.appendChild(lineBreak1);

            if (gender[i] != null) {
                if (genders[i] == "male") {
                    maleRadio.checked = true;
                    maleRadio.checked = "true";
                    maleRadio.setAttribute("checked", "checked");
                }
                if (genders[i] == "female") {
                    femaleRadio.checked = true;
                    femaleRadio.checked = "true";
                    femaleRadio.setAttribute("checked", "checked");
                }
            }
            td8.appendChild(maleRadio);
            td8.appendChild(maleLabel);
            td8.appendChild(femaleRadio);
            td8.appendChild(femaleLabel);
        }
        tr4.appendChild(td7);
        tr4.appendChild(td8);

        document.getElementById("table").appendChild(tr4);
    }
    document.getElementById("noOfPartners").onchange = function() { changeNumberOfPartners(); return false; };
}

//make sure IE doesn't allow you to check multiple radio buttons of the same name (male/female)
function checkOneButtonOnly(id) {
    var index = 0;
    var index1 = 0;
    var index2 = 0;
    var name = null;
    var id2 = null;
    if (id.search("femaleRadio") == 0) {
        if (id.length == 12) {
            index = id.charAt(id.length - 1);
            name = id.substr(0, id.length - 1);
            id2 = "maleRadio" + index;
        }
        else {
            index1 = id.charAt(id.length - 2);
            index2 = id.charAt(id.length - 1);
            name = id.substr(0, id.length - 2);
            id2 = "maleRadio" + index1 + index2;
        }
    }
    if (id.search("maleRadio") == 0) {
        if (id.length == 10) {
            index = id.charAt(id.length - 1);
            name = id.substr(0, id.length - 1);
            id2 = "femaleRadio" + index;
        }
        else {
            index1 = id.charAt(id.length - 2);
            index2 = id.charAt(id.length - 1);
            name = id.substr(0, id.length - 2);
            id2 = "femaleRadio" + index1 + index2;
        }
    }
    if (document.getElementById(id).checked == true) {
    }
    else {
        document.getElementById(id).checked = true;
        document.getElementById(id2).checked = false;
    }
    saveGenders();
}

//check whether gender has been chosen for each partner (only if some/all partners had the same sex as user)
function checkIfSubGendersChecked() {
    var notChecked = new Array();
    var counter = 0;
    if (document.getElementById("noRadio").checked == true) {
        for (var i = 1; i <= document.getElementById("noOfPartners").value; i = i + 1) {
            if (document.getElementById("maleRadio" + i).checked == false && document.getElementById("femaleRadio" + i).checked == false) {
                notChecked[counter] = i;
            }
            counter = counter + 1;
        }
    }
    return notChecked;
}

//returns the average number of direct sexual partners a typical person (in particular age) has
function noOfDirectSexPartners(gender, ageIndex) {
    if (gender == "Male") {
        return avgPartnersMale[ageIndex] * 1;
    }
    else {
        return avgPartnersFemale[ageIndex] * 1;
    }
}

//returns the number of indirect sexual partners (of one partner)
function noOfIndirectSexPartners(personsSleptWithDirectly) {
    var personsSleptWithIndirectly = ((((((((personsSleptWithDirectly - 1) * personsSleptWithDirectly) * personsSleptWithDirectly) * personsSleptWithDirectly) * personsSleptWithDirectly) * personsSleptWithDirectly) + (1 * 1)));
    return personsSleptWithIndirectly;
}

function noOfIndirectSexPartnersThreeDegrees(personsSleptWithDirectly) {
    var personsSleptWithIndirectly = (((personsSleptWithDirectly - 1) * personsSleptWithDirectly) * personsSleptWithDirectly) + (1 * 1);
    return personsSleptWithIndirectly;
}

//calculates the overall number of sexual partners (direct and indirect) user has had
//all data saved to hidden ASP fields
function calc() {
    var sum = 0;
    var sumThreeDegrees = 0;
    var success = true;
    if (document.getElementById("noOfPartners").value == 0) {
        if (document.getElementById("gm").checked) {
            document.getElementById("hidden_gender").value = "male";
        }
        if (document.getElementById("gf").checked) {
            document.getElementById("hidden_gender").value = "female";
        }
        document.getElementById("hidden_age").value = document.getElementById("age").value;
        document.getElementById("hidden_sum").value = sum;
        document.getElementById("hidden_direct").value = sum;
        document.getElementById("hidden_indirect").value = sum;
    }
    if (document.getElementById("noOfPartners").value == "Over 50") {
        success = false;
    }
    else {
        if (document.getElementById("yesRadio").checked) {
            sum = 0;
            sumThreeDegrees = 0;
            if (document.getElementById("gm").checked) {
                for (var i = 1; i <= document.getElementById("noOfPartners").value; i = i + 1) {
                    sum = sum + noOfIndirectSexPartners(noOfDirectSexPartners("Female", document.getElementById("person" + i).selectedIndex));
                    sumThreeDegrees = sumThreeDegrees + noOfIndirectSexPartnersThreeDegrees(noOfDirectSexPartners("Female", document.getElementById("person" + i).selectedIndex));
                }
            }
            else {
                for (var i = 1; i <= document.getElementById("noOfPartners").value; i = i + 1) {
                    sum = sum + noOfIndirectSexPartners(noOfDirectSexPartners("Male", document.getElementById("person" + i).selectedIndex));
                    sumThreeDegrees = sumThreeDegrees + noOfIndirectSexPartnersThreeDegrees(noOfDirectSexPartners("Male", document.getElementById("person" + i).selectedIndex));
                }
            }
        }
        if (document.getElementById("noRadio").checked) {
            var notChecked1 = new Array();
            notChecked1 = checkIfSubGendersChecked();
            if (notChecked1.length == 0) {
                sum = 0;
                sumThreeDegrees = 0;
                for (var i = 1; i <= document.getElementById("noOfPartners").value; i = i + 1) {
                    if (document.getElementById("maleRadio" + i).checked) {
                        sum = sum + noOfIndirectSexPartners(noOfDirectSexPartners("Male", document.getElementById("person" + i).selectedIndex));
                        sumThreeDegrees = sumThreeDegrees + noOfIndirectSexPartnersThreeDegrees(noOfDirectSexPartners("Male", document.getElementById("person" + i).selectedIndex));
                    }
                    else {
                        sum = sum + noOfIndirectSexPartners(noOfDirectSexPartners("Female", document.getElementById("person" + i).selectedIndex));
                        sumThreeDegrees = sumThreeDegrees + noOfIndirectSexPartnersThreeDegrees(noOfDirectSexPartners("Female", document.getElementById("person" + i).selectedIndex));
                    }
                }
            }
            else {
                var notCheckedString = "";
                for (var i = 0; i < notChecked1.length; i = i + 1) {
                    if (notChecked1[i] != null) {
                        if (i == notChecked1.length - 1) {
                            notCheckedString = notCheckedString + "#" + notChecked1[i];
                        }
                        else {
                            notCheckedString = notCheckedString + "#" + notChecked1[i] + ", ";
                        }
                    }
                }
                document.getElementById("hidden_notchecked").value = notCheckedString;
                alert("Please choose gender for all your sexual partners.\n\nGender hasn't been selected for the following Persons:\n" + notCheckedString);
                success = false;
            }
        }
    }
    if (sum > 0) {
        sum = Math.round(parseFloat(sum));
        sumThreeDegrees = Math.round(parseFloat(sumThreeDegrees));
        document.getElementById("hidden_indirect").value = sum;
        document.getElementById("hidden_direct").value = document.getElementById("noOfPartners").value;
        sum = sum * 1 + document.getElementById("noOfPartners").value * 1;
        if (document.getElementById("gm").checked) {
            document.getElementById("hidden_gender").value = "male";
        }
        if (document.getElementById("gf").checked) {
            document.getElementById("hidden_gender").value = "female";
        }
        document.getElementById("hidden_age").value = document.getElementById("age").value;
        document.getElementById("hidden_sum").value = sum;
        document.getElementById("hidden_sumThreeDegrees").value = sumThreeDegrees;        
    }
    
    if (document.getElementById("yesRadio") != null && document.getElementById("noRadio") != null) {
        if (document.getElementById("yesRadio").checked == false && document.getElementById("noRadio").checked == false) {
            if (document.getElementById("gm").checked == true) {
                alert("Please choose whether all your partners were women or not.");
            }
            if (document.getElementById("gf").checked == true) {
                alert("Please choose whether all your partners were men or not.");
            }
            success = false;
        }
    }
    return success;
}