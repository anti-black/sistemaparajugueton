<?php
require("../page1.php");
Page::header("Contactanos");
?>

<div class="container">
  <div class="row">
      <form id="form1" class="well col-lg-12" action="enviar.php" method="post" novalidate="novalidate" autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
    <div class='row'>
        <!--Campo para agregar el nombre del cliente-->
        <div class='input-field col s12 m6'>
         <i class='material-icons prefix'>assignment_ind</i>
         <label>Nombre*</label> <input id="Nombre" class="form-control" type="text" name="Nombre" />
     </div>-

</div>

<div class='row'>
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>lightbulb_outline</i>
         <textarea id="Mensaje" class="form-control" name="Mensaje" rows="4"></textarea>
    </div>
    <!--Campo para introducir correo electronico valido-->
    <div class='input-field col s12 m6'>
        <i class='material-icons prefix'>email</i>
        <label>Email*</label> <input id="Email" class="form-control" type="email" name="Email" />
    </div>


</div>


<br>
<center><button type='submit' class='btn light-green darken-3'><i class='material-icons right'>done</i>enviar</button>
<a href='pindex.php'class='btn red darken-1'><i class='material-icons right'>clear</i>Cancelar</a></center>
      </div>
      </div>
<?php
Page::footer();
?>