<?php
require("../lib/pagina.php");
echo Pagina::header("Reportes");
?>
<div class="container">
    <h1>Tu reporte resulto vacío</h1>
    <p>El reporte que solicitaste no iba a tener ninguna página por lo tanto no fue necesario crearlo.</p>
    <h5>¿Qué pasó?</h5>
    <p>Es posible que la informacion que pediste ya no esté y por lo tanto ya no aparecería en el documento y éste terminaría vacío; pero no te preocupes, ya no tienes que hacer nada</p>
    <h5>¿Lo puedo arreglar?</h5>
    <p>No es necesario que lo arregles, no está roto. Puedes hacer otro nuevo pero con otros filtros</p>
</div>
<?php echo Pagina::footer(); ?>