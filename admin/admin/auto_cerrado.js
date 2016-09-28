document.getElementById("ZERRATO").addEventListener("mousemove",function(){
    reiniciar()
});
var N= 0;

function reiniciar(){
    N=0;
}
var timer = setInterval(reloj,1000);

function reloj(){
    N++;

    if(N > 600)
    window.location = "/admin/pags/cerrar.php"
}