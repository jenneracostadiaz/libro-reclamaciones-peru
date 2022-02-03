var razonsocial = document.getElementById('txt_razonsocial')
var ruc = document.getElementById('txt_ruc')
var apoderado = document.getElementById('txt_nombreapoderado')
var empresa = document.getElementById('rbtn_empresa')
var personan = document.getElementById('rbtn_personnatural')
var menoredad = document.getElementById('ckb_menoredad')

function inicar() {
    razonsocial.parentElement.style.display='none'
    ruc.parentElement.style.display='none'
    apoderado.parentElement.style.display='none'
    if(empresa.checked){
        razonsocial.parentElement.style.display='block'
        ruc.parentElement.style.display='block'
    } else {
        razonsocial.parentElement.style.display='none'
        ruc.parentElement.style.display='none'
    }
    if(menoredad.checked){
        apoderado.parentElement.style.display='block'
    } else {
        apoderado.parentElement.style.display='none'
    }
    empresa.addEventListener("click", validarempresa)
    personan.addEventListener("click", validarpersona)
    menoredad.addEventListener("click", addmayoredad)
}

function validarempresa(){
    if(empresa.checked){
        razonsocial.parentElement.style.display='block'
        ruc.parentElement.style.display='block'
    } else {
        razonsocial.parentElement.style.display='none'
        ruc.parentElement.style.display='none'
    }
}

function validarpersona(){
    if(personan.checked){
        razonsocial.parentElement.style.display='none'
        ruc.parentElement.style.display='none'
    } else {
        razonsocial.parentElement.style.display='block'
        ruc.parentElement.style.display='block'
    }
}

function addmayoredad(){
    if(menoredad.checked){
        apoderado.parentElement.style.display='block'
    } else {
        apoderado.parentElement.style.display='none'
    }
}

window.addEventListener("load", inicar)