/***************************FUNCIONES PARA ALUMNOS************************/
function toggle_otra_persona(elemento) {
    if(elemento.value=="m") {
        document.getElementById("div_otra_persona").style.display = "none";
        changeCSSRequire('NombMadre','200px','100px');
        changeCSSRequire('CedMadre','200px','100px');
        changeCSSRequire('OcupMadre','200px','100px');
        changeCSSNoRequire('NombPadre','200px','100px');
        changeCSSNoRequire('CedPadre','200px','100px');
        changeCSSNoRequire('OcupPadre','200px','100px');
        changeCSSNoRequire('NombPerson','','100px');
        changeCSSNoRequire('CedPerson','','100px');
        changeCSSNoRequire('OcupPerson','','100px');
        changeCSSNoRequire('DomicilioPerson','','100px');
        changeCSSNoRequire('TelefPerson','','100px');
    }
    else if(elemento.value=="p") {
        document.getElementById("div_otra_persona").style.display = "none";
        changeCSSNoRequire('NombMadre','200px','100px');
        changeCSSNoRequire('CedMadre','200px','100px');
        changeCSSNoRequire('OcupMadre','200px','100px');
        changeCSSRequire('NombPadre','200px','100px');
        changeCSSRequire('CedPadre','200px','100px');
        changeCSSRequire('OcupPadre','200px','100px');
        changeCSSNoRequire('NombPerson','','100px');
        changeCSSNoRequire('CedPerson','','100px');
        changeCSSNoRequire('OcupPerson','','100px');
        changeCSSNoRequire('DomicilioPerson','','100px');
        changeCSSNoRequire('TelefPerson','','100px');
    } 
    else if(elemento.value=="o") {
        document.getElementById("div_otra_persona").style.display = "block";
        changeCSSNoRequire('NombMadre','200px','100px');
        changeCSSNoRequire('CedMadre','200px','100px');
        changeCSSNoRequire('OcupMadre','200px','100px');
        changeCSSNoRequire('NombPadre','200px','100px');
        changeCSSNoRequire('CedPadre','200px','100px');
        changeCSSNoRequire('OcupPadre','200px','100px');
        changeCSSRequire('NombPerson','','100px');
        changeCSSRequire('CedPerson','','100px');
        changeCSSRequire('OcupPerson','','100px');
        changeCSSRequire('DomicilioPerson','','100px');
        changeCSSRequire('TelefPerson','','100px');
    }
}

function validarSoloLetras(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    else if (tecla==0||tecla==9)  return true;
    patron =/[A-Za-z\s\xf1\xd1\xe1\xe9\xed\xf3\xfa\xc1\xc9\xcd\xd3\xda\xfc\xdc]/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
} 

function validarSoloNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    else if (tecla==0||tecla==9)  return true;
    patron =/[0-9\\]/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function maximaLongitud(texto,maxlong) {
    var in_value, out_value;

    if (texto.value.length > maxlong) {
        in_value = texto.value;
        out_value = in_value.substring(0,maxlong);
        texto.value = out_value;
        return false;
    }
    return true;
}

function changeCSSRequire(identificador,width,width2 ){
    if(document.getElementById("txt"+identificador).value==""){
        document.getElementById("txt"+identificador).setAttribute("required","true");                                
        if(identificador==="dateArrival"){ 
            document.getElementById("lb"+identificador).setAttribute("style","color: #B94A48; float: left; width: "+width2+";");
            document.getElementById("txt"+identificador).setAttribute("style","border-color: #B94A48; float left; width:"+width+"; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset; right: 30px; bottom: 25px; position:relative;");
        }
        else{ 
            document.getElementById("txt"+identificador).setAttribute("style","border-color: #B94A48; float left; width:"+width+"; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;");
            document.getElementById("lb"+identificador).setAttribute("style","color: #B94A48; float: left; width: "+width2+";");
        } 
        return "1";
    }
    else{ changeCSSNoRequire(identificador,width,width2); return "0";}
}

function changeCSSNoRequire(identificador,width,width2){
    document.getElementById("txt"+identificador).removeAttribute("required");                
    if(identificador==="dateArrival"){ 
        document.getElementById("lb"+identificador).setAttribute("style","width: "+width2+";");
        document.getElementById("txt"+identificador).setAttribute("style","float left; width:"+width+"; right: 30px; bottom: 25px; position:relative;");
    }
    else{ 
        document.getElementById("txt"+identificador).setAttribute("style","float left; width:"+width+";");
        document.getElementById("lb"+identificador).setAttribute("style","float: left; width: "+width2+";");
    }
}

function setearEdad(){   
    var actual = new Date();
    var fecha= document.getElementById('txtdateArrival').value;
    var h1=0, h2=0, h3=0, edad=0;
    
    fecha=fecha.split('/');
    if(fecha[0].charAt(0)==="0")h1=fecha[0].charAt(1); else h1=fecha[0];
    if(fecha[1].charAt(0)==="0")h2=fecha[1].charAt(1); else h2=fecha[1];
    if(fecha[2].charAt(0)==="0")h3=fecha[2].charAt(1); else h3=fecha[2];

    if(((actual.getMonth()+1)-parseInt(h2))>0)
        edad=actual.getFullYear()-parseInt(h3);
    else{
        if(((actual.getMonth()+1)-parseInt(h2))===0){
            if((actual.getDate()-parseInt(h1))>=0)
                edad=actual.getFullYear()-parseInt(h3);
            else
                edad=actual.getFullYear()-parseInt(h3)-1;
        }
        else
            edad=actual.getFullYear()-parseInt(h3)-1;
    }

    document.getElementById('txtEdad').value= edad;
}

function require(){
    var r = $("input[name='rbRepresent']:checked").val(), cont=0;
                
    cont=parseInt(changeCSSRequire('Nombres','342px','155px'))+cont;
    cont=parseInt(changeCSSRequire('Apellidos','342px','155px'))+cont;
    cont=parseInt(changeCSSRequire('Domicilio','342px','155px'))+cont;
    cont=parseInt(changeCSSRequire('Telef','120px','155px'))+cont;
    cont=parseInt(changeCSSRequire('LugarNac','120px',''))+cont;
    cont=parseInt(changeCSSRequire('dateArrival','120px',''))+cont;

    if(r=="m"){
        cont=parseInt(changeCSSRequire('NombMadre','200px','100px'))+cont;
        cont=parseInt(changeCSSRequire('CedMadre','200px','100px'))+cont;
        cont=parseInt(changeCSSRequire('OcupMadre','200px','100px'))+cont;
    }
    else{
        if(r=="p"){
            cont=parseInt(changeCSSRequire('NombPadre','200px','100px'))+cont;
            cont=parseInt(changeCSSRequire('CedPadre','200px','100px'))+cont;
            cont=parseInt(changeCSSRequire('OcupPadre','200px','100px'))+cont;
        }
        else{
            cont=parseInt(changeCSSRequire('NombPerson','','100px'))+cont;
            cont=parseInt(changeCSSRequire('CedPerson','','100px'))+cont;
            cont=parseInt(changeCSSRequire('OcupPerson','','100px'))+cont;
            cont=parseInt(changeCSSRequire('DomicilioPerson','','100px'))+cont;
            cont=parseInt(changeCSSRequire('TelefPerson','','100px'))+cont;
        }
    }
    
    return cont;
}
/************************************************************************************************************************************************************************************/

